<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

echo "=== Testing Peminjaman Flow with WhatsApp Notification ===\n\n";

// Authenticate as userlogistik
$userLogistik = \App\Models\User::where('email', 'userlogistik@pln.co.id')->first();

if (!$userLogistik) {
    echo "❌ User logistik not found!\n";
    exit(1);
}

echo "✅ User authenticated: {$userLogistik->name} ({$userLogistik->email})\n\n";

// Get available materials
$materials = \App\Models\Material::where('stok', '>', 0)->take(2)->get();

if ($materials->isEmpty()) {
    echo "❌ No materials available for testing!\n";
    exit(1);
}

echo "Materials to borrow:\n";
foreach ($materials as $material) {
    echo "- {$material->nama_material} (Stock: {$material->stok} {$material->satuan})\n";
}
echo "\n";

// Create peminjaman
echo "Creating peminjaman...\n";

$peminjaman = \App\Models\Peminjaman::create([
    'user_id' => $userLogistik->id,
    'tanggal_peminjaman' => now(),
    'status' => 'pending',
]);

echo "✅ Peminjaman created with ID: {$peminjaman->id}\n\n";

// Add peminjaman details
$materialList = [];
foreach ($materials as $material) {
    $jumlah = min(2, $material->stok); // Borrow 2 or less if stock is low
    
    \App\Models\PeminjamanDetail::create([
        'peminjaman_id' => $peminjaman->id,
        'material_id' => $material->id,
        'jumlah' => $jumlah,
    ]);
    
    // Decrement stock
    $material->decrement('stok', $jumlah);
    
    $materialList[] = "- {$material->nama_material}: {$jumlah} {$material->satuan}";
    
    echo "✅ Added: {$material->nama_material} x {$jumlah}\n";
}

echo "\n";

// Send WhatsApp notification
echo "Sending WhatsApp notification to admin logistik...\n\n";

try {
    // Get all admin logistik users
    $adminLogistikUsers = \App\Models\User::role('admin logistik')->get();

    if ($adminLogistikUsers->isEmpty()) {
        echo "⚠️  No admin logistik users found to send notification\n";
    } else {
        $whatsappService = new \App\Services\WhatsAppService();
        
        // Format the message
        $materialsText = implode("\n", $materialList);
        $message = "*NOTIFIKASI PEMINJAMAN MATERIAL BARU*\n\n";
        $message .= "📋 *ID Peminjaman:* {$peminjaman->id}\n";
        $message .= "👤 *Peminjam:* {$userLogistik->name}\n";
        $message .= "📧 *Email:* {$userLogistik->email}\n";
        $message .= "📅 *Tanggal:* " . $peminjaman->tanggal_peminjaman->format('d M Y H:i') . "\n";
        $message .= "📊 *Status:* Pending\n\n";
        $message .= "*Material yang Dipinjam:*\n{$materialsText}\n\n";
        $message .= "Silakan cek sistem untuk menyetujui atau menolak peminjaman ini.";

        // Send to all admin logistik
        foreach ($adminLogistikUsers as $admin) {
            echo "Sending to: {$admin->name} ({$admin->email})\n";
            
            if (!empty($admin->phone)) {
                $formattedPhone = \App\Services\WhatsAppService::formatPhoneNumber($admin->phone);
                echo "Phone: {$formattedPhone}\n";
                
                $result = $whatsappService->sendMessage($formattedPhone, $message);
                
                if ($result['success']) {
                    echo "✅ WhatsApp notification sent successfully!\n";
                    if (isset($result['data'])) {
                        echo "Response: " . json_encode($result['data']) . "\n";
                    }
                } else {
                    echo "❌ Failed to send WhatsApp notification\n";
                    echo "Error: " . ($result['error'] ?? 'Unknown error') . "\n";
                }
            } else {
                echo "⚠️  Admin does not have a phone number\n";
            }
            echo "\n";
        }
    }
} catch (\Exception $e) {
    echo "❌ Error sending notification: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n\n";

echo "Summary:\n";
echo "- Peminjaman ID: {$peminjaman->id}\n";
echo "- User: {$userLogistik->name}\n";
echo "- Status: {$peminjaman->status}\n";
echo "- Materials borrowed: " . count($materialList) . "\n";
echo "\nCheck storage/logs/laravel.log for detailed logs.\n";
