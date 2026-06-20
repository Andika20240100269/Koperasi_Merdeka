# Sistem Informasi Koperasi Simpan Pinjam (Si-KSP)

Aplikasi manajemen Koperasi Simpan Pinjam berbasis web sederhana yang dikembangkan dengan menggunakan **PHP Native** dan database **MySQL/MariaDB**. Sistem ini memiliki dua peran utama, yaitu **Admin** (Pengelola Koperasi) dan **Anggota** (Nasabah Koperasi).

---

## 🚀 Fitur Utama

### 1. Panel Admin (Pengelola)
* **Manajemen Anggota (CRUD)**:
  * Menambah anggota baru disertai upload foto profil.
  * *Registrasi Akun Anggota Otomatis*: Setiap kali anggota baru didaftarkan, sistem akan otomatis membuatkan akun login di tabel `user_anggota` dengan format Username `AGTXXXX` (contoh: `AGT0001`) dan Password default `12345`.
  * Memperbarui informasi anggota dan menghapus anggota (otomatis menghapus foto lama di direktori).
  * Pencarian data anggota secara cepat.
  * Detail profil lengkap anggota.
* **Manajemen Simpanan**:
  * Pencatatan transaksi simpanan anggota (Pokok, Wajib, Sukarela, dll.).
  * Kalkulasi otomatis total simpanan per anggota serta total simpanan keseluruhan koperasi di dashboard utama.
* **Manajemen Pinjaman**:
  * Pencatatan pinjaman anggota beserta durasi angsuran (bulan) dan persentase bunga.
  * Kalkulasi otomatis sisa pinjaman yang harus dibayar (Pinjaman Pokok + Bunga).
* **Manajemen Angsuran (Pembayaran)**:
  * Pencatatan angsuran pembayaran pinjaman anggota.
  * Pembaruan status pinjaman secara otomatis menjadi **Lunas** ketika jumlah pembayaran angsuran telah memenuhi total pinjaman.
* **Laporan Koperasi**:
  * Fitur cetak laporan data anggota langsung melalui browser (`window.print()`).

### 2. Panel Anggota (Nasabah)
* **Dashboard Anggota**:
  * Halaman ringkasan profil nasabah.
  * Informasi total simpanan pribadi.
  * Informasi pinjaman aktif serta sisa tagihan/angsuran yang harus dibayarkan.
* **Riwayat Simpanan**:
  * Melihat daftar lengkap riwayat simpanan yang pernah disetor.
* **Riwayat Pinjaman**:
  * Melihat daftar riwayat pinjaman beserta status pelunasannya.

---

## 🛠️ Tech Stack & Persyaratan Sistem
* **Bahasa Pemrograman**: PHP (Direkomendasikan PHP 7.4 - 8.2)
* **Database**: MySQL / MariaDB
* **Web Server**: Apache (melalui bundel XAMPP/Laragon)
* **Styling**: Vanilla CSS (CSS Kustom)
* **Scripting Tambahan**: JavaScript (untuk AJAX pencarian dinamis & fungsi cetak)

---

## 📂 Struktur Folder Proyek

```bash
db_koperasi/
├── ajax/                   # Script untuk pencarian dinamis anggota via AJAX
├── db_koperasi/            # Folder tambahan (berisi file cadangan laporan_anggota.php)
├── img/                    # Folder penyimpanan gambar / foto profil anggota
├── js/                     # File Javascript pendukung
├── db_koperasi.sql         # Dump database MySQL proyek
├── functions.php           # Script pusat fungsi PHP, koneksi DB, CRUD, dan logika bisnis
├── index.php               # Halaman utama / Dashboard Admin (setelah login admin)
├── login.php               # Halaman login untuk Admin
├── logout.php              # Proses logout Admin
├── login_anggota.php       # Halaman login untuk Anggota Koperasi
├── logout_anggota.php      # Proses logout Anggota
├── dashboard_anggota.php   # Halaman utama / Dashboard Anggota
├── detail.php              # Halaman detail profil anggota (Admin)
├── tambah.php              # Halaman tambah anggota baru (Admin)
├── ubah.php                # Halaman edit data anggota (Admin)
├── hapus.php               # Proses hapus data anggota (Admin)
├── data_simpanan.php       # Daftar simpanan anggota (Admin)
├── tambah_simpanan.php     # Form penambahan simpanan (Admin)
├── data_pinjaman.php       # Daftar pinjaman anggota (Admin)
├── tambah_pinjaman.php     # Form pengajuan/pencatatan pinjaman (Admin)
├── data_angsuran.php       # Daftar angsuran pinjaman (Admin)
├── tambah_angsuran.php     # Form pencatatan angsuran baru (Admin)
├── simpanan_anggota.php    # Detail simpanan milik anggota yang sedang login
├── pinjaman_anggota.php    # Detail pinjaman milik anggota yang sedang login
├── laporan_anggota.php     # Cetak laporan data anggota (Print layout)
├── buat_hash.php           # Utility untuk membuat hash password (developer)
├── cek_password.php        # Utility untuk verifikasi kecocokan password (developer)
└── generate_password.php   # Utility untuk mencetak hash password default (developer)
```

---

## ⚙️ Petunjuk Instalasi & Menjalankan Aplikasi

### Langkah 1: Persiapan Folder Proyek
1. Pastikan Anda sudah menginstal aplikasi web server seperti **XAMPP**.
2. Salin folder proyek `db_koperasi` ke dalam direktori:
   * **Windows**: `C:\xampp\htdocs\db_koperasi`
   * **Linux**: `/opt/lampp/htdocs/db_koperasi`
   * **macOS**: `/Applications/XAMPP/xamppfiles/htdocs/db_koperasi`

### Langkah 2: Setup Database MySQL
1. Buka aplikasi **XAMPP Control Panel** dan aktifkan modul **Apache** dan **MySQL**.
2. Buka browser Anda dan akses halaman admin database di: `http://localhost/phpmyadmin/`.
3. Buat database baru dengan nama **`db_koperasi`**:
   * Klik menu **New/Baru** di phpMyAdmin.
   * Masukkan nama database: `db_koperasi`, lalu klik **Create/Buat**.
4. Impor file SQL proyek:
   * Pilih database `db_koperasi` yang baru saja dibuat.
   * Klik tab **Import/Impor** di menu bagian atas.
   * Klik tombol **Choose File** dan pilih file [db_koperasi.sql](file:///C:/xampp/htdocs/db_koperasi/db_koperasi.sql) yang berada di dalam folder proyek Anda.
   * Gulir ke bawah lalu klik **Import / Go**. Tunggu hingga semua tabel berhasil diimpor.

### Langkah 3: Menjalankan Aplikasi di Browser
Setelah database berhasil diimpor, Anda dapat langsung menggunakan sistem melalui browser Anda:
* **Halaman Admin**: Akses URL `http://localhost/db_koperasi/login.php`
* **Halaman Anggota**: Akses URL `http://localhost/db_koperasi/login_anggota.php`

---

## 🔐 Kredensial Akun Demo (Uji Coba)

Gunakan akun berikut untuk masuk ke sistem:

### A. Akun Administrator (Akses Penuh Pengelola)
| Username | Password | Keterangan |
| :--- | :--- | :--- |
| **`agung`** | `12345` | Hak akses penuh sebagai pengelola koperasi |
| **`latifah`** | `12345` | Hak akses penuh sebagai pengelola koperasi |

### B. Akun Anggota (Akses Nasabah Koperasi)
| No. Anggota | Password | Keterangan |
| :--- | :--- | :--- |
| **`AGT0001`** | `12345` | Akun anggota demo bawaan (Andika Pratama) |

> 📌 **Catatan Keamanan**:
> Untuk mengganti password bawaan, Anda dapat menggunakan utilitas [buat_hash.php](file:///C:/xampp/htdocs/db_koperasi/buat_hash.php) untuk mencetak string hash baru kemudian mengupdatenya langsung di tabel database (`user` atau `user_anggota`).
