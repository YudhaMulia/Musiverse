# 📸 Panduan Upload Gambar Cagar Budaya

## 🎯 Cara Menggunakan Sistem Upload Gambar

### 1. Akses Halaman Admin Upload
```
http://127.0.0.1:8000/admin/cagar-budaya
```

### 2. Upload Gambar
- Lihat daftar semua cagar budaya
- Untuk setiap situs, pilih gambar dari komputer Anda
- Klik tombol **"Upload"**
- Gambar akan disimpan di server lokal

### 3. Informasi Penting
✓ Format gambar: **JPEG, PNG, GIF**
✓ Ukuran maksimal: **5MB**
✓ Lokasi penyimpanan: `storage/app/public/cagar-budaya/`
✓ URL publik: `/storage/cagar-budaya/nama-file.jpg`

---

## 📁 Struktur Folder Penyimpanan Gambar

```
storage/
└── app/
    └── public/
        └── cagar-budaya/
            ├── menara-air-palembang_1234567890.jpg
            ├── benteng-kuto-besak_1234567890.jpg
            ├── museum-smb-ii_1234567890.jpg
            └── ... (gambar lainnya)
```

---

## 🖼️ Cara Menambah Gambar Sendiri

### Opsi 1: Upload Via Admin Panel (Termudah)
1. Buka: `http://127.0.0.1:8000/admin/cagar-budaya`
2. Cari cagar budaya yang ingin ditambah gambar
3. Pilih file gambar dari komputer
4. Klik "Upload"
5. Selesai! Gambar akan muncul di home page & detail page

### Opsi 2: Salin File Gambar Langsung Ke Folder
1. Siapkan gambar Anda (JPEG/PNG/GIF)
2. Buat folder: `storage/app/public/cagar-budaya/` (jika belum ada)
3. Salin gambar ke folder tersebut
4. Edit database langsung atau gunakan admin panel

### Opsi 3: Update Database Manual (Jika File Sudah Ada)
```bash
# Buka Tinker
php artisan tinker

# Contoh update gambar untuk Menara Air Palembang
$site = App\Models\CagarBudaya::where('slug', 'menara-air-palembang')->first();
$site->update([
    'local_image_path' => 'cagar-budaya/menara-air-palembang.jpg',
    'image_url' => '/storage/cagar-budaya/menara-air-palembang.jpg',
]);
```

---

## 🎨 Tips Memilih & Mengambil Gambar

### Kualitas Gambar Ideal
✓ **Resolusi**: Minimal 1200x800 px
✓ **Pencahayaan**: Terang, detail terlihat jelas
✓ **Komposisi**: Situs terlihat dengan baik
✓ **Format**: JPEG untuk foto, PNG untuk gambar dengan background transparan
✓ **Ukuran File**: 500KB - 2MB (optimal)

### Contoh Gambar yang Baik
- 📸 Foto depan bangunan bersejarah
- 🏛️ Detail arsitektur yang menarik
- 🌅 Pemandangan lokasi situs
- 📍 Area sekitar cagar budaya
- 🖼️ Plakat/penanda informasi di lokasi

### Hindari
❌ Foto blur atau gelap
❌ Foto dengan orang yang mengaburkan view
❌ Gambar yang dipotong tidak sempurna
❌ File yang terlalu besar (>5MB)

---

## 🔍 Cara Mengganti/Update Gambar

### Jika Sudah Ada Gambar Lama
1. Upload gambar baru untuk situs yang sama
2. Gambar lama akan **otomatis dihapus**
3. Gambar baru menggantikan posisinya
4. Semua halaman (home & detail) akan menampilkan gambar terbaru

### Jika Ingin Menghapus Gambar
1. Buka admin panel: `/admin/cagar-budaya`
2. Klik tombol **"Hapus"** (merah)
3. Gambar akan dihapus dari server
4. Situs akan menampilkan placeholder (ikon gambar)

---

## 📍 Lihat Hasil Gambar

### Di Home Page
```
http://127.0.0.1:8000/
```
- Gambar ditampilkan di featured sites section
- Gambar juga di "Sorotan Cagar Budaya Pilihan"

### Di Listing Page
```
http://127.0.0.1:8000/cagar-budaya
```
- Grid view dengan preview gambar setiap situs
- Hover untuk lihat efek zoom

### Di Detail Page
```
http://127.0.0.1:8000/cagar-budaya/menara-air-palembang
```
- Gambar besar di bagian hero (top)
- Informasi lengkap di bawah gambar

---

## ⚙️ Troubleshooting

### Gambar Tidak Tampil
**Solusi:**
1. Pastikan folder `storage/app/public/` exists
2. Jalankan: `php artisan storage:link`
3. Cek permissions folder (harus writable)

### Upload Gagal - File Terlalu Besar
**Solusi:**
- Kompres gambar terlebih dahulu
- Gunakan tool: TinyPNG, ImageOptimizer
- Maksimal size: 5MB

### Gambar Tidak Muncul di Admin
**Solusi:**
1. Refresh halaman (Ctrl+F5)
2. Clear cache: `php artisan cache:clear`
3. Cek console browser (F12) untuk error

---

## 📊 Contoh Data yang Sudah Ada

Saat ini ada 6 cagar budaya siap untuk ditambah gambar:

| No | Nama | Lokasi | Status Gambar |
|----|------|--------|---------------|
| 1 | Menara Air Palembang | Jl. Merdeka | Siap upload |
| 2 | Benteng Kuto Besak | Jl. Sultan Mahmud | Siap upload |
| 3 | Museum SMB II | Jl. Merdeka | Siap upload |
| 4 | Masjid Agung Palembang | Jl. Sudirman | Siap upload |
| 5 | Bukit Siguntang | Jl. Diponegoro | Siap upload |
| 6 | Kampung Kapitan | Jl. Kapitan Mustofa | Siap upload |

---

## 🚀 Langkah Selanjutnya

1. **Siapkan gambar asli** dari lokasi cagar budaya di Palembang
2. **Akses admin panel**: `http://127.0.0.1:8000/admin/cagar-budaya`
3. **Upload gambar** untuk setiap situs
4. **Verifikasi** di home page & detail page
5. **Selesai!** Aplikasi siap dengan gambar asli

---

## 💡 Tips Penting

✓ Upload gambar berkualitas tinggi untuk dokumentasi warisan budaya
✓ Gunakan foto asli, bukan rendering/ilustrasi
✓ Konsisten dengan naming file dan folder organization
✓ Backup gambar penting di tempat lain
✓ Pertimbangkan ukuran file vs kualitas visual

---

## 📞 Bantuan Lebih Lanjut

Jika ada pertanyaan:
- Periksa folder: `storage/app/public/cagar-budaya/`
- Jalankan: `php artisan storage:link`
- Clear cache: `php artisan cache:clear`
- Restart server: `php artisan serve`

Selamat mengupload gambar! 🎉
