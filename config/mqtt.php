<?php

return [
    'host' => env('MQTT_HOST', 'broker.avisha.id'),
    'port' => env('MQTT_PORT', 1883),
    'username' => env('MQTT_USERNAME', ''),
    'password' => env('MQTT_PASSWORD', ''),
    'client_id' => env('MQTT_CLIENT_ID', 'laravel_mqtt_client'),
];
