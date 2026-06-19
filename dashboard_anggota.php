<?php
session_start();

if (!isset($_SESSION['login_anggota'])) {
    header("Location: login_anggota.php");
    exit;
}

require 'functions.php';

$no_anggota = $_SESSION['no_anggota'];

/* DATA ANGGOTA */
$anggota = query("
    SELECT *
    FROM anggota
    WHERE no_anggota = '$no_anggota'
");

if (empty($anggota)) {
    echo "Data anggota tidak ditemukan!";
    exit;
}

$anggota = $anggota[0];

/* DATA SIMPANAN */
$simpanan = query("
    SELECT *
    FROM simpanan
    WHERE no_anggota = '$no_anggota'
");

/* DATA PINJAMAN */
$pinjaman = query("
    SELECT *
    FROM pinjaman
    WHERE no_anggota = '$no_anggota'
");

/* HITUNG TOTAL SIMPANAN */
$total_simpanan = 0;

foreach ($simpanan as $s) {
    $total_simpanan += $s['jumlah'];
}

/* HITUNG TOTAL PINJAMAN */
$total_pinjaman = 0;

foreach ($pinjaman as $p) {
    $total_pinjaman += $p['jumlah_pinjaman'];
}

/* JUMLAH DATA */
$jumlah_simpanan = count($simpanan);
$jumlah_pinjaman = count($pinjaman);

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Anggota</title>

<style>

body{
    font-family: Arial, sans-serif;
    margin:20px;
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

table{
    border-collapse:collapse;
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

.menu a{
    display:inline-block;
    padding:10px 15px;
    margin-right:10px;
    background:#0d6efd;
    color:white;
    text-decoration:none;
    border-radius:5px;
}

.logout{
    background:red !important;
}

</style>

</head>
<body>

<h2>Dashboard Anggota</h2>

<p>
    Selamat datang,
    <b><?= $anggota['nama']; ?></b>
</p>

<p>
    Tanggal : <?= date('d-m-Y'); ?> |
    Jam : <?= date('H:i:s'); ?>
</p>

<!-- DASHBOARD RINGKASAN -->

<div class="dashboard">

    <div class="card">
        <h2>
            Rp <?= number_format($total_simpanan,0,',','.'); ?>
        </h2>
        <p>Total Simpanan</p>
    </div>

    <div class="card">
        <h2>
            Rp <?= number_format($total_pinjaman,0,',','.'); ?>
        </h2>
        <p>Total Pinjaman</p>
    </div>

    <div class="card">
        <h2><?= $jumlah_simpanan; ?></h2>
        <p>Transaksi Simpanan</p>
    </div>

    <div class="card">
        <h2><?= $jumlah_pinjaman; ?></h2>
        <p>Data Pinjaman</p>
    </div>

    <div class="card">
        <h2><?= $anggota['status_anggota']; ?></h2>
        <p>Status Anggota</p>
    </div>

</div>

<hr>

<div style="margin-bottom:20px;">
    <img src="img/<?= $anggota['foto']; ?>"
         width="120"
         style="border-radius:10px;">
</div>

<h3>Data Anggota</h3>

<ul>
    <li>No Anggota : <?= $anggota['no_anggota']; ?></li>
    <li>Alamat : <?= $anggota['alamat']; ?></li>
    <li>No HP : <?= $anggota['no_hp']; ?></li>
    <li>Pekerjaan : <?= $anggota['pekerjaan']; ?></li>
    <li>
Status :
<span style="color:green;font-weight:bold;">
    <?= $anggota['status_anggota']; ?>
</span>
</li>

</ul>

<hr>

<h3>Data Simpanan Saya</h3>

<?php if (!empty($simpanan)) : ?>

<table>

    <tr>
        <th>No</th>
        <th>Jumlah Simpanan</th>
        <th>Tanggal</th>
    </tr>

    <?php $no = 1; ?>
    <?php foreach ($simpanan as $s) : ?>

    <tr>
        <td><?= $no++; ?></td>
        <td>
            Rp <?= number_format($s['jumlah'],0,',','.'); ?>
        </td>
        <td><?= $s['tanggal']; ?></td>
    </tr>

    <?php endforeach; ?>

</table>

<?php else : ?>

<p><i>Belum ada data simpanan</i></p>

<?php endif; ?>

<hr>

<h3>Data Pinjaman Saya</h3>

<?php if (!empty($pinjaman)) : ?>

<table>

    <tr>
        <th>No</th>
        <th>Jumlah Pinjaman</th>
        <th>Lama Angsuran</th>
        <th>Tanggal Pinjaman</th>
        <th>Status</th>
    </tr>

    <?php $no = 1; ?>
    <?php foreach ($pinjaman as $p) : ?>

    <tr>
        <td><?= $no++; ?></td>
        <td>
            Rp <?= number_format($p['jumlah_pinjaman'],0,',','.'); ?>
        </td>
        <td><?= $p['lama_angsuran']; ?> Bulan</td>
        <td><?= $p['tanggal_pinjaman']; ?></td>
        <td><?= $p['status']; ?></td>
    </tr>

    <?php endforeach; ?>

</table>

<?php else : ?>

<p><i>Belum ada data pinjaman</i></p>

<?php endif; ?>

<hr>

<h3>Menu</h3>

<div class="menu">
    <a href="simpanan_anggota.php">Detail Simpanan</a>

    <a href="pinjaman_anggota.php">Detail Pinjaman</a>

    <a href="angsuran_anggota.php">Data Angsuran</a>

    <a href="logout_anggota.php" class="logout">Logout</a>
<hr>

<center>
    <small>
        Sistem Informasi Koperasi Berbasis Web © 2026<br>
        Dibuat oleh Andika Saputra
    </small>
</center>