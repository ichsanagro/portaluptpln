# 📱 WhatsApp Notification - Portal UPT PLN

## 🎯 Fitur

Notifikasi WhatsApp otomatis ke admin logistik ketika user mengajukan peminjaman material.

---

## 🚀 Quick Start

### 1. Setup Nomor Admin (WAJIB)

Edit file `ganti_nomor_admin.php` baris 15:
```php
$nomorBaru = '08XXXXXXXXXX'; // Ganti dengan nomor admin
```

Jalankan:
```bash
php ganti_nomor_admin.php
```

### 2. Verifikasi

```bash
php test_admin_phone.php
```

### 3. Test Notifikasi

```bash
php test_whatsapp_notification.php
```

---

## 📁 File Penting

### Script Utama:
- **ganti_nomor_admin.php** - Update nomor admin
- **test_admin_phone.php** - Cek nomor admin
- **test_whatsapp_notification.php** - Test kirim WhatsApp
- **test_peminjaman_flow.php** - Test full flow peminjaman
- **verify_peminjaman.php** - Verifikasi data peminjaman

### Kode Aplikasi:
- **app/Services/WhatsAppService.php** - Service Fonnte API
- **app/Http/Controllers/Logistik/UserLogistikController.php** - Controller dengan notifikasi
- **config/services.php** - Konfigurasi Fonnte
- **database/migrations/2026_01_10_000000_add_phone_to_users_table.php** - Migration phone

### Dokumentasi:
- **README_WHATSAPP.md** - Quick reference (file ini)
- **CARA_UPDATE_NOMOR_ADMIN.md** - Panduan lengkap update nomor
- **WHATSAPP_NOTIFICATION_SETUP.md** - Setup guide detail
- **QUICK_START.md** - Quick start guide
- **IMPLEMENTATION_SUMMARY.md** - Summary implementasi

---

## ⚙️ Konfigurasi

### Environment Variables (.env):
```env
FONNTE_API_URL=https://api.fonnte.com/send
FONNTE_API_TOKEN=7BGkY1QrtVve76U9ertV
```

### Admin Logistik:
- Email: `adminlogistik@pln.co.id`
- Phone: Harus diisi manual (tidak ada default)

---

## 📱 Format Pesan

```
*NOTIFIKASI PEMINJAMAN MATERIAL BARU*

📋 *ID Peminjaman:* 1
👤 *Peminjam:* User Logistik
📧 *Email:* userlogistik@pln.co.id
📅 *Tanggal:* 10 Jan 2026 00:00
📊 *Status:* Pending

*Material yang Dipinjam:*
- Kabel NYY 4x16mm: 2 Meter
- Trafo 250 kVA: 1 Unit

Silakan cek sistem untuk menyetujui atau menolak peminjaman ini.
```

---

## 🔧 Cara Kerja

1. User logistik mengajukan peminjaman via browser
2. System menyimpan data peminjaman ke database
3. System otomatis kirim notifikasi WhatsApp ke semua admin logistik
4. Admin menerima pesan di WhatsApp
5. Admin bisa approve/reject di sistem

---

## 📝 Commands

```bash
# Setup nomor admin (edit file dulu)
php ganti_nomor_admin.php

# Cek nomor admin
php test_admin_phone.php

# Test WhatsApp
php test_whatsapp_notification.php

# Test full flow
php test_peminjaman_flow.php

# Verifikasi data
php verify_peminjaman.php
```

---

## ⚠️ Troubleshooting

### Nomor tidak berubah?
```bash
php artisan cache:clear
php test_admin_phone.php
```

### WhatsApp tidak terkirim?
1. Cek nomor admin sudah diisi
2. Cek Fonnte device connected
3. Cek log: `storage/logs/laravel.log`

### Device disconnected?
Login ke https://fonnte.com dan scan QR code

---

## 📚 Dokumentasi Lengkap

- **Setup Detail**: `WHATSAPP_NOTIFICATION_SETUP.md`
- **Update Nomor**: `CARA_UPDATE_NOMOR_ADMIN.md`
- **Implementation**: `IMPLEMENTATION_SUMMARY.md`

---

## ✅ Status

- ✅ Backend implementation complete
- ✅ WhatsApp integration working
- ✅ Testing scripts available
- ✅ Documentation complete
- ✅ Production ready

---

## 🔒 Keamanan

- ✅ Tidak ada nomor hardcoded
- ✅ Admin harus setup nomor sendiri
- ✅ Token disimpan di .env (tidak di git)
- ✅ Error handling lengkap

---

## 📞 Support

Jika ada masalah:
1. Cek `storage/logs/laravel.log`
2. Jalankan `php test_admin_phone.php`
3. Baca dokumentasi di `CARA_UPDATE_NOMOR_ADMIN.md`
