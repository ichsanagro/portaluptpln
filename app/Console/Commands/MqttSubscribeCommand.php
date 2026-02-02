<?php

namespace App\Console\Commands;

use App\Services\MqttService;
use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;

/**
 * MqttSubscribeCommand
 *
 * A console command to connect to an MQTT broker and subscribe to a topic.
 * It uses the robust MqttService to handle connection, subscription, and the event loop.
 * Exceptions are caught and logged. This version is compatible with Windows (no PCNTL).
 */
class MqttSubscribeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Connects to the MQTT broker and subscribes to a topic to log messages.';

    protected MqttService $mqttService;
    protected LoggerInterface $logger;

    public function __construct(MqttService $mqttService, LoggerInterface $logger)
    {
        parent::__construct();
        $this->mqttService = $mqttService;
        $this->logger = $logger;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $topic = 'bgmamat/#';
        $qos = 0;

        $this->info("Starting MQTT subscriber for topic '{$topic}'...");
        $this->info("Press Ctrl+C to stop the process.");

        try {
            // This is a blocking call that encapsulates connection, subscription, and the loop.
            $this->mqttService->connectAndSubscribe(
                $topic,
                function ($receivedTopic, $message) {
                    $this->line("<fg=cyan>Topic:</> {$receivedTopic}");
                    $this->line("<fg=cyan>Message:</> {$message}");
                    $this->line('---');
                },
                $qos
            );
        } catch (\Exception $e) {
            $this->logger->error("MQTT Subscription failed: " . $e->getMessage(), [
                'exception' => $e
            ]);
            $this->error("Subscription failed. Check the logs for details. Error: " . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
