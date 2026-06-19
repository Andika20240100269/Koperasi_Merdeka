<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

$anggota = query("SELECT * FROM anggota");

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Data Anggota</title>

<style>

body{
    font-family:Arial, sans-serif;
    margin:20px;
}

h2{
    text-align:center;
}

table{
    width:100%;
    border-collapse:collapse;
}

table, th, td{
    border:1px solid black;
}

th{
    background:#f2f2f2;
}

th, td{
    padding:8px;
    text-align:center;
}

.btn{
    padding:10px 15px;
    background:#0d6efd;
    color:white;
    text-decoration:none;
    border:none;
    cursor:pointer;
    border-radius:5px;
}

@media print{
    .no-print{
        display:none;
    }
}

</style>

</head>
<body>

<h2>LAPORAN DATA ANGGOTA KOPERASI</h2>

<div class="no-print">

    <button onclick="window.print()" class="btn">
        Cetak Laporan
    </button>

    <a href="index.php" class="btn">
        Kembali
    </a>

</div>

<br><br>

<table>

<tr>
    <th>No</th>
    <th>No Anggota</th>
    <th>Nama</th>
    <th>Alamat</th>
    <th>No HP</th>
    <th>Pekerjaan</th>
    <th>Status</th>
</tr>

<?php $no = 1; ?>

<?php foreach($anggota as $a) : ?>

<tr>
    <td><?= $no++; ?></td>
    <td><?= $a['no_anggota']; ?></td>
    <td><?= $a['nama']; ?></td>
    <td><?= $a['alamat']; ?></td>
    <td><?= $a['no_hp']; ?></td>
    <td><?= $a['pekerjaan']; ?></td>
    <td><?= $a['status_anggota']; ?></td>
</tr>

<?php endforeach; ?>

</table>

<br><br>

<center>
    <small>
        Sistem Informasi Koperasi © 2026
    </small>
</center>

</body>
</html>