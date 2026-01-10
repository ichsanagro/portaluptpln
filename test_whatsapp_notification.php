<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing WhatsApp Notification ===\n\n";

// Check if Fonnte token is configured
$fonteToken = config('services.fonnte.token');
if (empty($fonteToken)) {
    echo "❌ FONNTE_API_TOKEN is not configured in .env file!\n";
    echo "Please add: FONNTE_API_TOKEN=7BGkY1QrtVve76U9ertV\n";
    exit(1);
}

echo "✅ Fonnte token configured: " . substr($fonteToken, 0, 10) . "...\n\n";

// Get admin logistik
$admin = \App\Models\User::role('admin logistik')->first();

if (!$admin) {
    echo "❌ No admin logistik found!\n";
    exit(1);
}

echo "Admin Details:\n";
echo "- Name: {$admin->name}\n";
echo "- Email: {$admin->email}\n";
echo "- Phone: " . ($admin->phone ?? 'NULL') . "\n\n";

if (empty($admin->phone)) {
    echo "❌ Admin does not have a phone number!\n";
    exit(1);
}

// Test WhatsApp Service
echo "Testing WhatsApp Service...\n\n";

$whatsappService = new \App\Services\WhatsAppService();

// Format phone number
$formattedPhone = \App\Services\WhatsAppService::formatPhoneNumber($admin->phone);
echo "Formatted phone: {$formattedPhone}\n\n";

// Create test message
$message = "*TEST NOTIFIKASI PEMINJAMAN MATERIAL*\n\n";
$message .= "📋 *ID Peminjaman:* TEST-001\n";
$message .= "👤 *Peminjam:* Test User\n";
$message .= "📧 *Email:* test@pln.co.id\n";
$message .= "📅 *Tanggal:* " . now()->format('d M Y H:i') . "\n";
$message .= "📊 *Status:* Pending\n\n";
$message .= "*Material yang Dipinjam:*\n";
$message .= "- Kabel NYA 2.5mm: 10 Meter\n";
$message .= "- MCB 2A: 5 Buah\n\n";
$message .= "Ini adalah pesan test dari sistem Portal UPT PLN.";

echo "Sending WhatsApp message...\n";
echo "To: {$formattedPhone}\n\n";

$result = $whatsappService->sendMessage($formattedPhone, $message);

if ($result['success']) {
    echo "✅ WhatsApp message sent successfully!\n\n";
    echo "Response:\n";
    print_r($result['data']);
} else {
    echo "❌ Failed to send WhatsApp message!\n\n";
    echo "Error: " . ($result['error'] ?? 'Unknown error') . "\n";
}

echo "\n=== Test Complete ===\n";
