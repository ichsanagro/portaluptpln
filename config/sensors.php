<?php

return [
    'names' => [
        'rumah/dapur/suhu' => 'Sensor Suhu Dapur',
        'rumah/dapur/kelembapan' => 'Sensor Kelembapan Dapur',
        'rumah/dapur/asap' => 'Detektor Asap Dapur',
        'rumah/ruangtamu/suhu' => 'Sensor Suhu Ruang Tamu',
        'rumah/ruangtamu/kelembapan' => 'Sensor Kelembapan Ruang Tamu',
        'rumah/ruangtamu/asap' => 'Detektor Asap Ruang Tamu',
        'default' => 'Sensor Tidak Dikenal', // Fallback for any other device_id not listed
    ],
    'units' => [
        'rumah/dapur/suhu' => '°C',
        'rumah/dapur/kelembapan' => '% (Persen)',
        'rumah/dapur/asap' => 'PPM',
        'rumah/ruangtamu/suhu' => '°C',
        'rumah/ruangtamu/kelembapan' => '% (Persen)',
        'rumah/ruangtamu/asap' => 'PPM',
    ],
    'whitelist' => [
        'rumah/dapur/suhu',
        'rumah/dapur/kelembapan',
        'rumah/dapur/asap',
        'rumah/ruangtamu/suhu',
        'rumah/ruangtamu/kelembapan',
        'rumah/ruangtamu/asap',
    ],
];