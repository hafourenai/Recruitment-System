# Recruitment System

Sistem pendaftaran dan seleksi (hanya sebagai media pembelajaran)

---

## Panduan Penggunaan 

Ikuti langkah-langkah berikut untuk menjalankan project di lingkungan lokal:

1. **Clone Project**
   Pastikan Anda memiliki salinan kode sumber di lokal.

2. **Install Dependensi**
   Gunakan Composer untuk menginstal library yang dibutuhkan:
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**
   Buat file `.env` dari contoh yang tersedia:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Buka file `.env` dan sesuaikan pengaturan database (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

4. **Migrasi & Seeder Database**
   Jalankan perintah berikut untuk membuat tabel dan mengisi data awal (user admin/dosen):
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```
   Akses melalui browser di: `http://localhost:8000`

---

## Fitur 

### 1. Sistem Multi-Role
*   **Pendaftar**:
    *   Registrasi akun mandiri.
    *   Upload berkas pendaftaran (CV, Transkrip, KRS, Sertifikat) dalam format PDF.
    *   Pemantauan status seleksi secara langsung melalui timeline dashboard.
    *   Update/Hapus berkas sebelum proses seleksi dikunci.
*   **Dosen**:
    *   Melihat daftar pendaftar yang tersedia.
    *   Mereview berkas PDF pendaftar secara langsung tanpa perlu mendownload manual.
*   **Admin**:
    *   Dashboard manajemen pendaftar yang komprehensif.
    *   Filter pendaftar berdasarkan posisi (Asisten/Programmer).
    *   Pembaruan status seleksi (Seleksi Berkas, Ujian, Wawancara, hingga Kelulusan).

### 2. Manajemen Berkas Aman
*   File tidak disimpan di folder publik yang dapat diakses langsung oleh URL.
*   Akses file melalui route controller yang memvalidasi hak akses role sebelum menampilkan PDF.

### 3. Keamanan & Validasi
*   Pembatasan jumlah percobaan login dan registrasi (Rate Limiting).
*   Validasi tipe file (minimal PDF) dan ukuran file maksimal.
*   Sistem otentikasi role-based yang ketat.

---

## Pengembangan 
Aplikasi ini dirancang dengan struktur yang mudah untuk dikembangkan lebih lanjut:

1.  **Sistem Notifikasi**: Integrasi email atau WhatsApp API untuk memberitahu pendaftar secara otomatis saat status seleksi berubah.
2.  **Penjadwalan Terintegrasi**: Modul untuk mengatur jadwal ujian dan wawancara langsung dari dashboard admin yang sinkron dengan kalender pendaftar.
3.  **Sistem Penilaian (Scoring System)**: Fitur bagi dosen/admin untuk memberikan skor pada tiap tahap seleksi guna menghasilkan rangking pendaftar secara otomatis.
4.  **Ekspor Laporan**: Fitur untuk mendownload laporan hasil seleksi final ke dalam format Excel atau PDF.
5.  **Dashboard Statistik**: Visualisasi data pendaftar tahunan dalam bentuk grafik untuk kebutuhan evaluasi laboratorium.

---

## 🔑 Akun Default (Login)

| Role | Email | Password |
|---|---|---|
| **Admin** | `admin@lab.com` | `password` |
| **Dosen** | `dosen@lab.com` | `password` |
