# Sistem Informasi Koperasi Simpan Pinjam (Si-KSP) - Koperasi Merdeka

Aplikasi manajemen Koperasi Simpan Pinjam berbasis web yang dikembangkan menggunakan **PHP Native** dan database **MySQL/MariaDB**. Aplikasi ini dirancang untuk mendigitalisasi operasional koperasi, mencakup pencatatan anggota, pengelolaan simpanan, serta pengajuan dan pelunasan pinjaman secara sistematis.

---

## 📌 Latar Belakang Masalah

Koperasi Simpan Pinjam (KSP) konvensional sering menghadapi kendala operasional akibat pencatatan data transaksi yang masih manual (menggunakan buku besar kertas atau file spreadsheet terpisah). Beberapa masalah utama yang sering muncul meliputi:

1. **Ketidakakuratan Perhitungan**: Risiko tinggi terjadinya kesalahan manusia (_human error_) dalam menghitung bunga pinjaman, total akumulasi simpanan wajib, atau sisa saldo tagihan anggota.
2. **Keterbatasan Akses Anggota**: Anggota koperasi tidak dapat memantau status simpanan atau sisa pinjaman mereka secara langsung tanpa mendatangi kantor atau menghubungi pengelola secara manual.
3. **Penyusunan Laporan yang Lambat**: Pembuatan rekapitulasi data anggota dan laporan keuangan bulanan/tahunan membutuhkan waktu lama karena data harus dicari dan dihitung secara manual satu per satu.

**Solusi Proyek**: Aplikasi **Si-KSP** ini mengotomatisasi perhitungan keuangan (simpanan, bunga pinjaman, sisa tagihan angsuran) serta menyediakan portal mandiri bagi **Anggota** untuk masuk dan memantau akun keuangan mereka secara real-time, sekaligus mempermudah **Admin** dalam mengelola data anggota, transaksi, dan mencetak laporan secara instan.

---

## 🚀 Fitur Utama

### 1. Panel Admin (Pengelola)

- **Manajemen Anggota (CRUD)**:
  - Menambah anggota baru disertai upload foto profil.
  - _Registrasi Akun Anggota Otomatis_: Setiap kali anggota baru didaftarkan, sistem akan otomatis membuatkan akun login di tabel `user_anggota` dengan format Username `AGTXXXX` (contoh: `AGT0001`) dan Password default `12345`.
  - Memperbarui informasi anggota dan menghapus anggota (otomatis menghapus foto lama di direktori).
  - Pencarian data anggota secara cepat.
  - Detail profil lengkap anggota.
- **Manajemen Simpanan**:
  - Pencatatan transaksi simpanan anggota (Pokok, Wajib, Sukarela, dll.).
  - Kalkulasi otomatis total simpanan per anggota serta total simpanan keseluruhan koperasi di dashboard utama.
- **Manajemen Pinjaman**:
  - Pencatatan pinjaman anggota beserta durasi angsuran (bulan) dan persentase bunga.
  - Kalkulasi otomatis sisa pinjaman yang harus dibayar (Pinjaman Pokok + Bunga).
- **Manajemen Angsuran (Pembayaran)**:
  - Pencatatan angsuran pembayaran pinjaman anggota.
  - Pembaruan status pinjaman secara otomatis menjadi **Lunas** ketika jumlah pembayaran angsuran telah memenuhi total pinjaman.
- **Laporan Koperasi**:
  - Fitur cetak laporan data anggota langsung melalui browser (`window.print()`).

### 2. Panel Anggota (Nasabah)

- **Dashboard Anggota**:
  - Halaman ringkasan profil nasabah.
  - Informasi total simpanan pribadi.
  - Informasi pinjaman aktif serta sisa tagihan/angsuran yang harus dibayarkan.
- **Riwayat Simpanan & Pinjaman**:
  - Melihat daftar lengkap transaksi simpanan dan pinjaman pribadi secara transparan.

---

## 📐 Rancangan Database (Database Design)

Database bernama `db_koperasi` terdiri atas 6 tabel utama yang terintegrasi dengan struktur berikut:

### 1. Struktur Tabel

- **`user`** (Penyimpanan akun login Administrator/Pengelola Koperasi):
  - `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
  - `username` (VARCHAR)
  - `password` (VARCHAR, Hashed)
- **`anggota`** (Penyimpanan data profil anggota koperasi):
  - `id_anggota` (INT, AUTO_INCREMENT, PRIMARY KEY)
  - `no_anggota` (VARCHAR, UNIQUE)
  - `nama` (VARCHAR)
  - `alamat` (TEXT)
  - `no_hp` (VARCHAR)
  - `pekerjaan` (VARCHAR)
  - `tanggal_daftar` (DATE)
  - `status_anggota` (VARCHAR)
  - `foto` (VARCHAR, Nama berkas gambar profil)
- **`user_anggota`** (Penyimpanan kredensial login untuk portal Anggota):
  - `no_anggota` (VARCHAR, PRIMARY KEY, FOREIGN KEY ke `anggota.no_anggota`)
  - `password` (VARCHAR, Hashed)
- **`simpanan`** (Catatan transaksi simpanan anggota):
  - `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
  - `no_anggota` (VARCHAR, FOREIGN KEY)
  - `jenis_simpanan` (VARCHAR, e.g. Pokok, Wajib, Sukarela)
  - `jumlah` (INT, Nominal transaksi)
  - `tanggal` (DATE)
- **`pinjaman`** (Catatan pengajuan dan saldo pinjaman aktif):
  - `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
  - `no_anggota` (VARCHAR, FOREIGN KEY)
  - `jumlah_pinjaman` (INT, Pokok pinjaman)
  - `lama_angsuran` (INT, Tenor bulan)
  - `bunga` (FLOAT, Persentase bunga)
  - `tanggal_pinjaman` (DATE)
  - `status` (VARCHAR, 'Belum Lunas' / 'Lunas')
- **`angsuran`** (Catatan cicilan pengembalian dana):
  - `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
  - `id_pinjaman` (INT, FOREIGN KEY ke `pinjaman.id`)
  - `tanggal_bayar` (DATE)
  - `jumlah_bayar` (INT, Nominal bayar)

### 2. Hubungan Relasi (Kardinalitas)

- **`anggota` (1) ─── (1) `user_anggota`**: Relasi _one-to-one_. Setiap anggota terdaftar mempunyai tepat satu baris data login.
- **`anggota` (1) ─── (N) `simpanan`**: Relasi _one-to-many_. Anggota koperasi dapat menyetorkan simpanan berkali-kali.
- **`anggota` (1) ─── (N) `pinjaman`**: Relasi _one-to-many_. Anggota diperbolehkan mengajukan pinjaman beberapa kali seiring waktu.
- **`pinjaman` (1) ─── (N) `angsuran`**: Relasi _one-to-many_. Satu data transaksi pinjaman dilunasi melalui beberapa cicilan transaksi angsuran.

---

## 🌀 Alur Sistem (DFD Level 0 / Diagram Konteks)

Sistem memproses interaksi aliran data dari dua entitas utama sebagai berikut:

1. **Entitas Admin**:
   - **Input ke Sistem**: Menginput data anggota baru, meregistrasi transaksi simpanan baru, menginput data pinjaman baru, serta memperbarui setoran angsuran anggota.
   - **Output dari Sistem**: Menerima laporan rekap data anggota, rekap total dana simpanan masuk, rekap total pinjaman keluar, serta detail status pembayaran angsuran.
2. **Entitas Anggota**:
   - **Input ke Sistem**: Memasukkan nomor anggota dan password untuk login ke portal anggota.
   - **Output dari Sistem**: Menerima informasi profil pribadi, akumulasi total saldo simpanan miliknya, status pinjaman aktif, serta rincian sisa tagihan bulanan yang harus dibayarkan.

---

## 💻 Implementasi Kode Pemrograman Utama

Logika perhitungan sisa kewajiban pinjaman anggota diimplementasikan melalui fungsi **`sisaPinjaman()`** pada berkas [functions.php](file:///C:/xampp/htdocs/db_koperasi/functions.php):

```php
function sisaPinjaman($id_pinjaman)
{
    $pinjaman = query("
        SELECT jumlah_pinjaman, bunga, lama_angsuran
        FROM pinjaman
        WHERE id = '$id_pinjaman'
    ");

    if (empty($pinjaman)) {
        return 0;
    }

    $jumlahPinjaman = $pinjaman[0]['jumlah_pinjaman'];
    $bunga = $pinjaman[0]['bunga'];
    $lama = $pinjaman[0]['lama_angsuran'];

    // Hitung total pinjaman + bunga
    $totalPinjaman = $jumlahPinjaman + (($jumlahPinjaman * $bunga / 100) * $lama);

    $angsuran = query("
        SELECT SUM(jumlah_bayar) AS total
        FROM angsuran
        WHERE id_pinjaman = '$id_pinjaman'
    ");

    $totalBayar = $angsuran[0]['total'] ?? 0;

    return $totalPinjaman - $totalBayar;
}
```

- **Cara Kerja**: Fungsi mengambil rincian pinjaman berdasarkan ID pinjaman, menghitung total pinjaman (pokok + bunga akumulasi masa angsuran), menjumlahkan total angsuran yang telah dibayarkan oleh anggota via query agregat `SUM(jumlah_bayar)`, lalu mengembalikan nilai sisa kewajiban anggota yang belum terbayar.

---

## 🛠️ Tech Stack & Persyaratan Sistem

- **Bahasa Pemrograman**: PHP (Direkomendasikan PHP 7.4 - 8.2)
- **Database**: MySQL / MariaDB
- **Web Server**: Apache (melalui bundel XAMPP/Laragon)
- **Styling**: Vanilla CSS (CSS Kustom)
- **Scripting**: JavaScript (AJAX pencarian dinamis & browser print)

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
   - **Windows**: `C:\xampp\htdocs\db_koperasi`
   - **Linux**: `/opt/lampp/htdocs/db_koperasi`
   - **macOS**: `/Applications/XAMPP/xamppfiles/htdocs/db_koperasi`

### Langkah 2: Setup Database MySQL

1. Buka aplikasi **XAMPP Control Panel** dan aktifkan modul **Apache** dan **MySQL**.
2. Buka browser Anda dan akses halaman admin database di: `http://localhost/phpmyadmin/`.
3. Buat database baru dengan nama **`db_koperasi`**:
   - Klik menu **New/Baru** di phpMyAdmin.
   - Masukkan nama database: `db_koperasi`, lalu klik **Create/Buat**.
4. Impor file SQL proyek:
   - Pilih database `db_koperasi` yang baru saja dibuat.
   - Klik tab **Import/Impor** di menu bagian atas.
   - Klik tombol **Choose File** dan pilih file [db_koperasi.sql](file:///C:/xampp/htdocs/db_koperasi/db_koperasi.sql) yang berada di dalam folder proyek Anda.
   - Gulir ke bawah lalu klik **Import / Go**. Tunggu hingga semua tabel berhasil diimpor.

### Langkah 3: Menjalankan Aplikasi di Browser

Setelah database berhasil diimpor, Anda dapat langsung menggunakan sistem melalui browser Anda:

- **Halaman Admin**: Akses URL `http://localhost/db_koperasi/login.php` (Gunakan username: **`admin`** dengan password: **`admin`**)
- **Halaman Anggota**: Akses URL `http://localhost/db_koperasi/login_anggota.php` (Gunakan No. Anggota: **`AGT0001`** dengan password: **`12345`**)

---

## 🔐 Kredensial Akun Demo (Uji Coba)

Gunakan akun berikut untuk masuk ke sistem:

### A. Akun Administrator (Akses Penuh Pengelola)

| Username    | Password | Keterangan                                 |
| :---------- | :------- | :----------------------------------------- |
| **`admin`** | `admin`  | Hak akses penuh sebagai pengelola koperasi |

### B. Akun Anggota (Akses Nasabah Koperasi)

| No. Anggota   | Password | Keterangan                                |
| :------------ | :------- | :---------------------------------------- |
| **`AGT0001`** | `12345`  | Akun anggota demo bawaan (Andika Pratama) |

> 📌 **Catatan Keamanan**:
> Untuk mengganti password bawaan, Anda dapat menggunakan utilitas [buat_hash.php](file:///C:/xampp/htdocs/db_koperasi/buat_hash.php) untuk mencetak string hash baru kemudian mengupdatenya langsung di tabel database (`user` atau `user_anggota`).
