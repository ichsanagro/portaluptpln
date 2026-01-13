# TODO: Tambah Spesifikasi dan Foto ke Material

## Progress Tracking

### 1. Database Changes
- [x] ~~Create migration to add spesifikasi and foto columns~~ (Kolom sudah ada di database)

### 2. Model Updates
- [x] Update Material model fillable array

### 3. Controller Updates
- [x] Add show() method for viewing material details
- [x] Update store() method to handle foto upload and spesifikasi
- [x] Update update() method to handle foto upload and spesifikasi
- [x] Update destroy() method to delete foto file

### 4. View Updates
- [x] Update material.blade.php - Add "Lihat" button
- [x] Update material.blade.php - Add detail modal
- [x] Update material.blade.php - Add spesifikasi and foto fields to add modal
- [x] Update material.blade.php - Add JavaScript for viewMaterial function
- [x] Update edit_material.blade.php - Add spesifikasi and foto fields

### 5. Storage Setup
- [x] ~~Run migration~~ (Tidak diperlukan, kolom sudah ada)
- [x] Create storage link (Sudah ada)

### 6. Testing
- [ ] Test adding material with spesifikasi and foto
- [ ] Test viewing material details
- [ ] Test editing material
- [ ] Test deleting material

## Summary

Semua implementasi kode telah selesai! Fitur yang ditambahkan:

1. **Field Spesifikasi dan Foto**: Ditambahkan ke form tambah dan edit material
2. **Tombol "Lihat"**: Ditambahkan di tabel daftar material untuk melihat detail
3. **Modal Detail**: Menampilkan semua informasi material termasuk spesifikasi dan foto
4. **Upload Foto**: Mendukung upload foto dengan validasi (JPG, PNG, GIF, max 2MB)
5. **Tampilan Foto**: Foto dapat dilihat di modal detail dan halaman edit
6. **Hapus Foto**: Foto otomatis terhapus saat material dihapus

Silakan lakukan testing untuk memastikan semua fitur berjalan dengan baik!
