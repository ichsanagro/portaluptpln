# Cara Mengubah Nomor Telepon Admin Logistik

Ada 3 cara untuk mengubah nomor telepon admin logistik:

---

## Cara 1: Menggunakan Script PHP (Paling Mudah) ✅

### Langkah-langkah:

1. **Buat file PHP baru** (atau gunakan yang sudah ada):
   ```bash
   # File sudah tersedia: ganti_nomor_admin.php
   ```

2. **Edit nomor telepon di file tersebut**:
   ```php
   // Buka file: ganti_nomor_admin.php
   // Ubah baris 15 dengan nomor admin yang benar:
   $nomorBaru = '08XXXXXXXXXX'; // Ganti dengan nomor admin
   ```

3. **Jalankan script**:
   ```bash
   php update_admin_phone_real.php
   ```

4. **Verifikasi**:
   ```bash
   php test_admin_phone.php
   ```

### Contoh Output:
```
=== Updating Admin Logistik Phone Number ===

Current admin details:
- Name: Admin Logistik
- Email: adminlogistik@pln.co.id
- Old Phone: 081234567890

✅ Phone number updated successfully!

New admin details:
- Name: Admin Logistik
- Email: adminlogistik@pln.co.id
- New Phone: 081319445552
- Formatted: 6281319445552
```

---

## Cara 2: Menggunakan Tinker (Laravel Console) 🔧

### Langkah-langkah:

1. **Buka Laravel Tinker**:
   ```bash
   php artisan tinker
   ```

2. **Update nomor telepon**:
   ```php
   $admin = App\Models\User::where('email', 'adminlogistik@pln.co.id')->first();
   $admin->phone = '081319445552'; // Ganti dengan nomor baru
   $admin->save();
   ```

3. **Verifikasi**:
   ```php
   $admin->phone; // Akan menampilkan nomor baru
   ```

4. **Keluar dari Tinker**:
   ```php
   exit
   ```

---

## Cara 3: Langsung ke Database 💾

### Menggunakan MySQL/MariaDB:

1. **Buka database**:
   ```bash
   # Jika menggunakan Laragon
   mysql -u root -p
   ```

2. **Pilih database**:
   ```sql
   USE nama_database_anda;
   ```

3. **Update nomor telepon**:
   ```sql
   UPDATE users 
   SET phone = '081319445552' 
   WHERE email = 'adminlogistik@pln.co.id';
   ```

4. **Verifikasi**:
   ```sql
   SELECT name, email, phone 
   FROM users 
   WHERE email = 'adminlogistik@pln.co.id';
   ```

### Menggunakan phpMyAdmin (Laragon):

1. Buka browser: `http://localhost/phpmyadmin`
2. Pilih database Anda
3. Klik tabel `users`
4. Cari user dengan email `adminlogistik@pln.co.id`
5. Klik "Edit" (icon pensil)
6. Ubah field `phone` dengan nomor baru
7. Klik "Go" untuk save

---

## Format Nomor Telepon

### Format yang Diterima:
- ✅ `081234567890` (format Indonesia)
- ✅ `628234567890` (format internasional)
- ✅ `+628234567890` (dengan plus)
- ✅ `0812-3456-7890` (dengan strip, akan dibersihkan otomatis)

### Sistem akan otomatis convert ke:
- `081234567890` → `6281234567890`

### Contoh Nomor Valid:
- `081234567890`
- `082123456789`
- `085678901234`
- `087890123456`

---

## Script Cepat untuk Update

Buat file baru `update_phone.php`:

```php
<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// UBAH NOMOR DI SINI
$newPhone = '081319445552'; // <-- Ganti dengan nomor baru

$admin = \App\Models\User::where('email', 'adminlogistik@pln.co.id')->first();

if (!$admin) {
    echo "❌ Admin not found!\n";
    exit(1);
}

echo "Old phone: {$admin->phone}\n";
$admin->phone = $newPhone;
$admin->save();
echo "✅ New phone: {$admin->phone}\n";
echo "Formatted: " . \App\Services\WhatsAppService::formatPhoneNumber($admin->phone) . "\n";
```

Jalankan:
```bash
php update_phone.php
```

---

## Menambah Admin Logistik Baru

Jika ingin menambah admin logistik baru (bukan update yang lama):

### Menggunakan Tinker:

```bash
php artisan tinker
```

```php
// Buat user baru
$admin = new App\Models\User();
$admin->name = 'Admin Logistik 2';
$admin->email = 'adminlogistik2@pln.co.id';
$admin->phone = '081234567890'; // Nomor telepon admin baru
$admin->password = Hash::make('password123');
$admin->save();

// Assign role
$admin->assignRole('admin logistik');

// Verifikasi
$admin->roles->pluck('name'); // Harus menampilkan ['admin logistik']
```

---

## Verifikasi Setelah Update

### 1. Cek di Database:
```bash
php test_admin_phone.php
```

### 2. Test Kirim WhatsApp:
```bash
php test_whatsapp_notification.php
```

### 3. Test Full Flow:
```bash
php test_peminjaman_flow.php
```

---

## Troubleshooting

### Nomor tidak berubah?
- Pastikan script dijalankan tanpa error
- Cek apakah email admin benar: `adminlogistik@pln.co.id`
- Clear cache: `php artisan cache:clear`

### WhatsApp tidak terkirim?
- Pastikan nomor format Indonesia (08xxx)
- Cek Fonnte device sudah connected
- Cek quota Fonnte masih ada
- Lihat log: `storage/logs/laravel.log`

### Multiple Admin?
Semua user dengan role "admin logistik" yang punya nomor telepon akan dapat notifikasi.

Untuk melihat semua admin:
```bash
php artisan tinker
```
```php
App\Models\User::role('admin logistik')->get(['name', 'email', 'phone']);
```

---

## Tips

1. **Backup Database** sebelum update langsung ke database
2. **Test dulu** dengan script sebelum production
3. **Verifikasi** nomor sudah benar sebelum test kirim WhatsApp
4. **Simpan nomor lama** untuk berjaga-jaga

---

## Quick Reference

```bash
# Cek nomor admin saat ini
php test_admin_phone.php

# Update nomor (edit file dulu)
php update_admin_phone_real.php

# Test kirim WhatsApp
php test_whatsapp_notification.php

# Verifikasi
php test_admin_phone.php
```

---

## Kontak Support

Jika ada masalah:
1. Cek `storage/logs/laravel.log`
2. Jalankan `php test_admin_phone.php`
3. Pastikan format nomor benar (08xxx)
