<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\SensorData;
use Illuminate\Support\Facades\Log;

class MqttListenerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Connect to MQTT broker and listen for messages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $host = config('mqtt.host');
        $port = config('mqtt.port');
        $username = config('mqtt.username');
        $password = config('mqtt.password');
        $clientId = config('mqtt.client_id');
        $topic = config('mqtt.topic');

        $mqtt = new MqttClient($host, $port, $clientId);

        $connectionSettings = (new ConnectionSettings)
            ->setUsername($username)
            ->setPassword($password)
            ->setConnectTimeout(5)
            ->setSocketTimeout(5)
            ->setResendTimeout(10)
            ->setKeepAliveInterval(60);

        while (true) {
            try {
                $this->info("Connecting to MQTT broker at {$host}:{$port}...");
                $mqtt->connect($connectionSettings, true);
                $this->info("Connected! Subscribing to topic [{$topic}]...");

                $mqtt->subscribe($topic, function ($topic, $message) {
                    $this->info("Received message on topic [{$topic}]: {$message}");

                    try {
                        // This new logic is more resilient. It creates a structured payload
                        // from the topic and raw message, instead of expecting perfect JSON.
                        $topicParts = explode('/', $topic);
                        $value = trim($message);

                        // Create a universally unique device_id from the full topic path (excluding prefix)
                        $payloadDeviceId = implode('/', array_slice($topicParts, 1)) ?: 'unknown_device'; // e.g., 'rumah/ruangtamu/kelembapan'

                        $payload = [
                            'device_id' => $payloadDeviceId,
                            // Location can still be derived from the middle parts for display if needed
                            'location' => implode('/', array_slice($topicParts, 1, -1)) ?: 'root_location', // e.g., 'rumah/ruangtamu'
                            'value' => is_numeric($value) ? (float)$value : $value,
                            'status' => is_numeric($value) ? 'normal' : strtolower($value),
                            'unit' => null,
                        ];

                        SensorData::create([
                            'topic' => $topic,
                            'payload' => $payload,
                        ]);
                        $this->info("Data structured and saved to database.");

                    } catch (\Exception $e) {
                        Log::error("MQTT: Error processing message on topic [{$topic}]: " . $e->getMessage());
                        $this->error("Error processing message: " . $e->getMessage());
                    }
                }, 0);

                $mqtt->loop(true);

            } catch (\PhpMqtt\Client\Exceptions\MqttClientException $e) {
                Log::error("MQTT Connection failed: " . $e->getMessage());
                $this->error("MQTT Connection failed: " . $e->getMessage() . ". Reconnecting in 5 seconds...");
                sleep(5);
            } catch (\Exception $e) {
                Log::error("An unexpected error occurred: " . $e->getMessage());
                $this->error("An unexpected error occurred: " . $e->getMessage() . ". Retrying in 5 seconds...");
                sleep(5);
            }
        }
    }
}
