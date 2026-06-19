<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

// Cek parameter id
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

// Ambil data anggota
$data = query("SELECT * FROM anggota WHERE id_anggota = $id");

if (empty($data)) {
    echo "<h3>Data anggota tidak ditemukan!</h3>";
    exit;
}

$anggota = $data[0];

// Nomor anggota otomatis
$no_anggota = !empty($anggota['no_anggota'])
    ? $anggota['no_anggota']
    : "AGT" . str_pad($anggota['id_anggota'], 4, "0", STR_PAD_LEFT);

// Foto default
$foto = !empty($anggota['foto'])
    ? $anggota['foto']
    : 'nophoto.jpg';

// Total Simpanan
$totalSimpanan = query("
    SELECT SUM(jumlah) AS total
    FROM simpanan
    WHERE no_anggota = '$no_anggota'
");

$total = 0;

if (!empty($totalSimpanan) && $totalSimpanan[0]['total'] != null) {
    $total = $totalSimpanan[0]['total'];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kartu Anggota Koperasi</title>

<style>

body{
    font-family: Arial, sans-serif;
    background:#f4f4f4;
}

.kartu{
    width:8.5cm;
    min-height:5.4cm;
    margin:20px auto;
    border-radius:12px;
    overflow:hidden;
    border:2px solid #0d6efd;
    background:#fff;
    box-shadow:0 2px 10px rgba(0,0,0,.2);
}

.header{
    background:#0d6efd;
    color:white;
    text-align:center;
    padding:8px;
}

.header h3{
    margin:0;
    font-size:14px;
}

.isi{
    display:flex;
    padding:8px;
}

.foto{
    width:90px;
    text-align:center;
}

.foto img{
    width:70px;
    height:85px;
    object-fit:cover;
    border:1px solid #ccc;
}

.data{
    flex:1;
    font-size:11px;
    padding-left:8px;
}

.data p{
    margin:4px 0;
}

.footer{
    text-align:center;
    font-size:10px;
    background:#f1f1f1;
    padding:4px;
}

.btn{
    text-align:center;
    margin-top:20px;
}

.btn button{
    padding:8px 15px;
    margin:5px;
    cursor:pointer;
}

@media print{

    .btn{
        display:none;
    }

    body{
        background:white;
    }

    .kartu{
        margin:0;
        box-shadow:none;
    }
}

</style>

</head>

<body>

<div class="kartu">

    <div class="header">
        <h3>KARTU ANGGOTA KOPERASI</h3>
    </div>

    <div class="isi">

        <div class="foto">
            <img src="img/<?= htmlspecialchars($foto); ?>" alt="Foto Anggota">
        </div>

        <div class="data">

            <p>
                <b>No Anggota</b><br>
                <?= htmlspecialchars($no_anggota); ?>
            </p>

            <p>
                <b>Nama</b><br>
                <?= htmlspecialchars($anggota['nama']); ?>
            </p>

            <p>
                <b>No HP</b><br>
                <?= htmlspecialchars($anggota['no_hp']); ?>
            </p>

            <p>
                <b>Pekerjaan</b><br>
                <?= htmlspecialchars($anggota['pekerjaan']); ?>
            </p>

            <p>
                <b>Status</b><br>
                <?= htmlspecialchars($anggota['status_anggota']); ?>
            </p>

            <p>
                <b>Total Simpanan</b><br>
                Rp <?= number_format($total, 0, ',', '.'); ?>
            </p>

        </div>

    </div>

    <div class="footer">
        Berlaku Selama Menjadi Anggota Koperasi
    </div>

</div>

<div class="btn">

    <button onclick="window.print()">
        🖨 Cetak Kartu
    </button>

    <a href="data_simpanan.php?no_anggota=<?= $no_anggota; ?>">
        <button type="button">
            Data Simpanan
        </button>
    </a>

    <a href="index.php">
        <button type="button">
            Kembali
        </button>
    </a>

</div>

</body>
</html>