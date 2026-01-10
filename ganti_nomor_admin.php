<?php

/**
 * Script untuk mengubah nomor telepon Admin Logistik
 * 
 * Cara pakai:
 * 1. Edit nomor di baris 15
 * 2. Jalankan: php ganti_nomor_admin.php
 */

require __DIR__.'/vendor/autoload.php';

// ============================================
// UBAH NOMOR TELEPON DI SINI
// ============================================
$nomorBaru = '081292724798'; // <-- GANTI DENGAN NOMOR ADMIN YANG BENAR
// ============================================

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n";
echo "╔════════════════════════════════════════════════════════╗\n";
echo "║   UPDATE NOMOR TELEPON ADMIN LOGISTIK                  ║\n";
echo "╚════════════════════════════════════════════════════════╝\n";
echo "\n";

// Validasi format nomor
if (!preg_match('/^(08|628)\d{8,11}$/', $nomorBaru)) {
    echo "❌ Format nomor tidak valid!\n";
    echo "   Format yang benar: 08xxxxxxxxxx atau 628xxxxxxxxxx\n";
    echo "   Contoh: 081234567890\n";
    echo "\n";
    echo "⚠️  Silakan edit file ini dan ganti nomor di baris 15\n";
    echo "   dengan nomor admin yang benar, lalu jalankan lagi.\n\n";
    exit(1);
}

// Cari admin
$admin = \App\Models\User::where('email', 'adminlogistik@pln.co.id')->first();

if (!$admin) {
    echo "❌ Admin logistik tidak ditemukan!\n";
    echo "   Email: adminlogistik@pln.co.id\n\n";
    exit(1);
}

// Tampilkan info sebelum update
echo "📋 Data Admin Saat Ini:\n";
echo "   Nama  : {$admin->name}\n";
echo "   Email : {$admin->email}\n";
echo "   Nomor : " . ($admin->phone ?: '(belum ada)') . "\n";
echo "\n";

// Konfirmasi
echo "🔄 Akan diubah menjadi:\n";
echo "   Nomor Baru : {$nomorBaru}\n";
echo "   Format Int : " . \App\Services\WhatsAppService::formatPhoneNumber($nomorBaru) . "\n";
echo "\n";

// Update
$nomorLama = $admin->phone;
$admin->phone = $nomorBaru;
$admin->save();

echo "✅ Nomor telepon berhasil diupdate!\n\n";

// Tampilkan ringkasan
echo "📊 Ringkasan Perubahan:\n";
echo "   Nomor Lama : " . ($nomorLama ?: '(belum ada)') . "\n";
echo "   Nomor Baru : {$admin->phone}\n";
echo "   Format Int : " . \App\Services\WhatsAppService::formatPhoneNumber($admin->phone) . "\n";
echo "\n";

// Saran next steps
echo "📝 Langkah Selanjutnya:\n";
echo "   1. Verifikasi: php test_admin_phone.php\n";
echo "   2. Test WA   : php test_whatsapp_notification.php\n";
echo "   3. Test Flow : php test_peminjaman_flow.php\n";
echo "\n";

echo "╔════════════════════════════════════════════════════════╗\n";
echo "║   UPDATE SELESAI                                       ║\n";
echo "╚════════════════════════════════════════════════════════╝\n";
echo "\n";
