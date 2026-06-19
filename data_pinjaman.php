<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

require 'functions.php';

$pinjaman = query("
SELECT *
FROM pinjaman
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Pinjaman</title>

<style>
table{
    border-collapse: collapse;
    width:100%;
}

table,th,td{
    border:1px solid black;
}

th,td{
    padding:10px;
    text-align:center;
}

th{
    background:#f2f2f2;
}
</style>

</head>

<body>

<h2>Data Pinjaman</h2>

<a href="tambah_pinjaman.php">
<button>Tambah Pinjaman</button>
</a>

<br><br>

<table>

<tr>
    <th>No</th>
    <th>No Anggota</th>
    <th>Pinjaman</th>
    <th>Bunga</th>
    <th>Lama Angsuran</th>
    <th>Total Bayar</th>
    <th>Angsuran/Bulan</th>
    <th>Sisa Pinjaman</th>
    <th>Tanggal</th>
    <th>Status</th>
</tr>

<?php $i=1; ?>

<?php foreach($pinjaman as $p) : ?>

<?php

$jumlah = $p['jumlah_pinjaman'];

$bunga = $p['bunga'];

$lama = $p['lama_angsuran'];

$totalBunga =
($jumlah * $bunga / 100) * $lama;

$totalBayar =
$jumlah + $totalBunga;

$angsuranPerBulan =
$totalBayar / $lama;

$sisa = sisaPinjaman($p['id']);

?>

<tr>

<td><?= $i++; ?></td>

<td><?= $p['no_anggota']; ?></td>

<td>
Rp <?= number_format($jumlah,0,',','.'); ?>
</td>

<td>
<?= $bunga; ?>%
</td>

<td>
<?= $lama; ?> Bulan
</td>

<td>
Rp <?= number_format($totalBayar,0,',','.'); ?>
</td>

<td>
Rp <?= number_format($angsuranPerBulan,0,',','.'); ?>
</td>

<td>
Rp <?= number_format($sisa,0,',','.'); ?>
</td>

<td>
<?= $p['tanggal_pinjaman']; ?>
</td>

<td>
<?= $p['status']; ?>
</td>

</tr>

<?php endforeach; ?>

</table>

</body>
</html>