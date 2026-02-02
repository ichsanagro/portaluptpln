<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\Exceptions\MqttClientException;
use Illuminate\Support\Facades\Log;

/**
 * MqttService - A robust, production-safe MQTT client service for Laravel.
 *
 * This service class provides a defensive and reliable wrapper around the php-mqtt/client library.
 * It ensures that connections are properly established and validated before any operations
 * like subscribing or looping are attempted. It is designed to fail fast with clear exceptions
 * and detailed logging, preventing common issues like `feof(null)` by strictly managing the client's state.
 */
class MqttService
{
    protected MqttClient $client;
    protected ConnectionSettings $connectionSettings;
    private bool $isConnected = false;

    /**
     * Initializes the MQTT client and connection settings from the configuration.
     */
    public function __construct()
    {
        $host = config('mqtt.host');
        $port = (int) config('mqtt.port');
        $clientId = config('mqtt.client_id');
        $username = config('mqtt.username');
        $password = config('mqtt.password');

        if (!$host || !$port || !$clientId) {
            throw new \InvalidArgumentException('MQTT configuration is incomplete. Please check config/mqtt.php and your .env file.');
        }

        $this->client = new MqttClient($host, $port, $clientId);
        
        $this->connectionSettings = (new ConnectionSettings)
            ->setUsername($username)
            ->setPassword($password)
            ->setConnectTimeout(10) // Stop if connection is not established within 10 seconds.
            ->setKeepAliveInterval(60); // Send a ping every 60 seconds to keep the connection alive.
    }

    /**
     * Connects to the broker, subscribes to a topic, and starts the event loop.
     * This method encapsulates the entire "connect and listen" logic.
     *
     * @param string $topic The topic to subscribe to.
     * @param callable $callback The function to execute when a message is received.
     * @param int $qos The Quality of Service level for the subscription.
     * @throws MqttClientException if connection or subscription fails.
     */
    public function connectAndSubscribe(string $topic, callable $callback, int $qos = 0): void
    {
        // 1. Connect to the broker
        Log::info("MQTT: Attempting to connect to " . $this->client->getHost() . ":" . $this->client->getPort() . "...");
        $this->client->connect($this->connectionSettings, true); // Use a clean session
        $this->isConnected = true;
        Log::info("MQTT: Connection successful.");

        // 2. Subscribe to the topic
        Log::info("MQTT: Attempting to subscribe to topic '{$topic}' with QoS {$qos}.");
        $this->client->subscribe($topic, function ($receivedTopic, $message) use ($callback) {
            Log::debug("MQTT: Message received on topic '{$receivedTopic}'.");
            $callback($receivedTopic, $message);
        }, $qos);
        Log::info("MQTT: Subscription to '{$topic}' successful.");

        // 3. Start the loop ONLY if connection and subscription were successful
        Log::info("MQTT: Starting event loop. Listening for messages...");
        $this->client->loop(true); // The `true` parameter makes it a blocking loop
    }
    
    /**
     * Gracefully disconnects from the broker if connected.
     * This is useful for cleanup in console commands or long-running processes.
     */
    public function disconnect(): void
    {
        if ($this->isConnected) {
            Log::info("MQTT: Disconnecting from broker.");
            $this->client->disconnect();
            $this->isConnected = false;
        }
    }
}