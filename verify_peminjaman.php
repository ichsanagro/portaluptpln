<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Verifying Peminjaman Data ===\n\n";

$peminjaman = \App\Models\Peminjaman::with(['user', 'details.material'])->latest()->first();

if (!$peminjaman) {
    echo "❌ No peminjaman found!\n";
    exit(1);
}

echo "✅ Latest Peminjaman Found:\n\n";
echo "ID: {$peminjaman->id}\n";
echo "User: {$peminjaman->user->name} ({$peminjaman->user->email})\n";
echo "Tanggal: " . \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d M Y H:i') . "\n";
echo "Status: {$peminjaman->status}\n";
echo "\nMaterial Details:\n";

foreach ($peminjaman->details as $detail) {
    echo "- {$detail->material->nama_material}: {$detail->jumlah} {$detail->material->satuan}\n";
}

echo "\n=== Verification Complete ===\n";
