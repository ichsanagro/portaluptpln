<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Checking Admin Logistik Phone Numbers ===\n\n";

$admins = \App\Models\User::role('admin logistik')->get();

if ($admins->isEmpty()) {
    echo "❌ No admin logistik users found!\n";
} else {
    echo "✅ Found " . $admins->count() . " admin logistik user(s):\n\n";
    foreach ($admins as $admin) {
        echo "ID: {$admin->id}\n";
        echo "Name: {$admin->name}\n";
        echo "Email: {$admin->email}\n";
        echo "Phone: " . ($admin->phone ?? 'NULL') . "\n";
        echo "---\n";
    }
}
