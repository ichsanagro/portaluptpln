# WhatsApp Notification Setup Guide

## Fitur
Ketika user dengan role `userlogistik` melakukan peminjaman material dan menekan tombol "Ajukan Peminjaman" di modal, maka admin logistik akan menerima notifikasi WhatsApp secara otomatis.

## Perubahan yang Dilakukan

### 1. File Baru
- `app/Services/WhatsAppService.php` - Service untuk mengirim pesan WhatsApp via Fonnte API
- `database/migrations/2026_01_10_000000_add_phone_to_users_table.php` - Menambah kolom phone ke tabel users
- `.env.example.whatsapp` - Contoh konfigurasi environment variables

### 2. File yang Dimodifikasi
- `app/Http/Controllers/Logistik/UserLogistikController.php` - Menambahkan fungsi notifikasi WhatsApp
- `app/Models/User.php` - Menambahkan field phone ke fillable
- `config/services.php` - Menambahkan konfigurasi Fonnte API
- `database/seeders/RoleAndUserSeeder.php` - Menambahkan nomor telepon default untuk admin logistik

## Cara Setup

### Step 1: Update Environment Variables
Tambahkan konfigurasi berikut ke file `.env`:

```env
FONNTE_API_URL=https://api.fonnte.com/send
FONNTE_API_TOKEN=7BGkY1QrtVve76U9ertV
```

### Step 2: Jalankan Migration
Jalankan migration untuk menambahkan kolom phone ke tabel users:

```bash
php artisan migrate
```

### Step 3: Update Data Admin Logistik
Jalankan seeder untuk update data admin logistik dengan nomor telepon:

```bash
php artisan db:seed --class=RoleAndUserSeeder
```

Atau update manual nomor telepon admin logistik melalui database/aplikasi:
- Login sebagai admin
- Update nomor telepon di profil
- Format: 081234567890 (akan otomatis dikonversi ke 628123456789)

### Step 4: Test Notifikasi
1. Login sebagai user logistik (userlogistik@pln.co.id / password123)
2. Buka halaman Peminjaman Material
3. Tambahkan material ke keranjang
4. Klik tombol "Ajukan Peminjaman"
5. Admin logistik akan menerima notifikasi WhatsApp

## Format Pesan WhatsApp

Pesan yang dikirim ke admin logistik:

```
*NOTIFIKASI PEMINJAMAN MATERIAL BARU*

📋 *ID Peminjaman:* 1
👤 *Peminjam:* User Logistik
📧 *Email:* userlogistik@pln.co.id
📅 *Tanggal:* 10 Jan 2026 14:30
📊 *Status:* Pending

*Material yang Dipinjam:*
- Kabel NYA 2.5mm: 10 Meter
- MCB 2A: 5 Buah

Silakan cek sistem untuk menyetujui atau menolak peminjaman ini.
```

## Troubleshooting

### Notifikasi tidak terkirim
1. Cek log di `storage/logs/laravel.log`
2. Pastikan token Fonnte valid dan aktif
3. Pastikan admin logistik memiliki nomor telepon di database
4. Pastikan format nomor telepon benar (08xxx atau 628xxx)

### Error "No admin logistik users found"
- Pastikan ada user dengan role "admin logistik" di database
- Jalankan seeder: `php artisan db:seed --class=RoleAndUserSeeder`

### Error "Admin does not have a phone number"
- Update nomor telepon admin logistik di database
- Kolom: `users.phone`
- Format: 081234567890

## Fitur WhatsAppService

### Mengirim Pesan Tunggal
```php
$whatsappService = new WhatsAppService();
$result = $whatsappService->sendMessage('628123456789', 'Pesan Anda');
```

### Mengirim Pesan ke Multiple Recipients
```php
$whatsappService = new WhatsAppService();
$phoneNumbers = ['628123456789', '628987654321'];
$results = $whatsappService->sendBulkMessage($phoneNumbers, 'Pesan Anda');
```

### Format Nomor Telepon
```php
$formatted = WhatsAppService::formatPhoneNumber('081234567890');
// Output: 628123456789
```

## Catatan Penting

1. **Token Fonnte**: Token yang digunakan adalah `7BGkY1QrtVve76U9ertV`. Pastikan token ini valid dan memiliki saldo/kuota yang cukup.

2. **Nomor Telepon Admin**: Secara default, admin logistik memiliki nomor `081234567890`. Ganti dengan nomor yang sebenarnya.

3. **Logging**: Semua aktivitas pengiriman WhatsApp dicatat di log Laravel untuk monitoring dan debugging.

4. **Error Handling**: Jika pengiriman WhatsApp gagal, sistem tetap akan menyimpan peminjaman dan menampilkan pesan sukses ke user. Error hanya dicatat di log.

5. **Multiple Admin**: Sistem mendukung multiple admin logistik. Semua admin dengan role "admin logistik" yang memiliki nomor telepon akan menerima notifikasi.

## Support

Untuk pertanyaan atau masalah, silakan cek:
- Log aplikasi: `storage/logs/laravel.log`
- Dokumentasi Fonnte: https://fonnte.com/api
