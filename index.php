<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

// Dashboard
$jumlahAnggota = jumlahAnggota();

$totalSimpanan = totalSimpananKeseluruhan();
if ($totalSimpanan == null) {
    $totalSimpanan = 0;
}

$totalPinjaman = totalPinjamanKeseluruhan();
if ($totalPinjaman == null) {
    $totalPinjaman = 0;
}

// Ambil data anggota
$anggota = query("
    SELECT *
    FROM anggota
    ORDER BY id_anggota ASC
");

// Pencarian
if (isset($_POST['cari'])) {
    $anggota = cari($_POST['keyword']);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Anggota Koperasi</title>

<style>

body{
    font-family: Arial, sans-serif;
    margin:20px;
}

h1{
    margin-bottom:5px;
}

table{
    border-collapse: collapse;
    width:100%;
}

table, th, td{
    border:1px solid #000;
}

th{
    background:#f2f2f2;
}

th, td{
    padding:10px;
    text-align:center;
}

img{
    border-radius:5px;
}

.btn{
    padding:8px 15px;
    text-decoration:none;
    color:white;
    border-radius:4px;
    margin-right:5px;
}

.tambah{
    background:green;
}

.logout{
    background:red;
}

.simpanan{
    background:#0d6efd;
}

.dashboard{
    display:flex;
    flex-wrap:wrap;
    gap:20px;
    margin:20px 0;
}

.card{
    width:220px;
    padding:20px;
    background:#f8f9fa;
    border-radius:10px;
    box-shadow:0 2px 5px rgba(0,0,0,.2);
    text-align:center;
}

.card h2{
    margin:0;
    color:#0d6efd;
}

.card p{
    margin-top:10px;
    font-weight:bold;
}

form{
    margin:15px 0;
}

input[type=text]{
    padding:8px;
    width:250px;
}

button{
    padding:8px 12px;
    cursor:pointer;
}

</style>

</head>

<body>

<h1>Data Anggota Koperasi</h1>

<p>
    Selamat datang,
    <b><?= $_SESSION['username']; ?></b>
</p>

<div class="dashboard">

    <div class="card">
        <h2><?= $jumlahAnggota; ?></h2>
        <p>Jumlah Anggota</p>
    </div>

    <div class="card">
        <h2>
            Rp <?= number_format($totalSimpanan, 0, ',', '.'); ?>
        </h2>
        <p>Total Simpanan</p>
    </div>

    <div class="card">
        <h2>
            Rp <?= number_format($totalPinjaman, 0, ',', '.'); ?>
        </h2>
        <p>Total Pinjaman</p>
    </div>

</div>

<a href="tambah.php" class="btn tambah">
    Tambah Anggota
</a>

<a href="data_simpanan.php" class="btn simpanan">
    Data Simpanan
</a>

<a href="data_pinjaman.php" class="btn simpanan">
    Data Pinjaman
</a>

<a href="logout.php"
   class="btn logout"
   onclick="return confirm('Yakin logout?')">
    Logout
</a>

<a href="tambah.php" class="btn tambah">
    Tambah Anggota
</a>

<a href="data_simpanan.php" class="btn simpanan">
    Data Simpanan
</a>

<a href="data_pinjaman.php" class="btn simpanan">
    Data Pinjaman
</a>

<a href="laporan_anggota.php" class="btn simpanan">
    Laporan Anggota
</a>

<a href="logout.php" class="btn logout">
    Logout
</a>

<br><br>

<form action="" method="post">

    <input
        type="text"
        name="keyword"
        placeholder="Cari nama, no anggota, alamat..."
        autocomplete="off">

    <button type="submit" name="cari">
        Cari
    </button>

</form>

<table>

    <tr>
        <th>No</th>
        <th>Foto</th>
        <th>No Anggota</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>No HP</th>
        <th>Pekerjaan</th>
        <th>Tanggal Daftar</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php $no = 1; ?>

    <?php foreach ($anggota as $a) : ?>

    <?php
    $foto = !empty($a['foto'])
        ? $a['foto']
        : 'nophoto.jpg';
    ?>

    <tr>

        <td><?= $no++; ?></td>

        <td>
            <img
                src="img/<?= htmlspecialchars($foto); ?>"
                width="80">
        </td>

        <td><?= htmlspecialchars($a['no_anggota']); ?></td>

        <td><?= htmlspecialchars($a['nama']); ?></td>

        <td><?= htmlspecialchars($a['alamat']); ?></td>

        <td><?= htmlspecialchars($a['no_hp']); ?></td>

        <td><?= htmlspecialchars($a['pekerjaan']); ?></td>

        <td><?= htmlspecialchars($a['tanggal_daftar']); ?></td>

        <td><?= htmlspecialchars($a['status_anggota']); ?></td>

        <td>

            <a href="detail.php?id=<?= $a['id_anggota']; ?>">
                Detail
            </a>

            |

            <a href="ubah.php?id=<?= $a['id_anggota']; ?>">
                Ubah
            </a>

            |

            <a
                href="hapus.php?id=<?= $a['id_anggota']; ?>"
                onclick="return confirm('Yakin hapus data?')">
                Hapus
            </a>

            <a href="data_angsuran.php" class="btn simpanan">
                Data Angsuran
            </a>

        </td>

    </tr>

    <?php endforeach; ?>

</table>

</body>
</html>