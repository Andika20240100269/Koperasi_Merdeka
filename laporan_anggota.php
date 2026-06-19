<?php
require 'functions.php';

$anggota = query("SELECT * FROM anggota");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Anggota</title>

    <style>
    body{
        font-family:Arial, sans-serif;
    }

    table{
        width:100%;
        border-collapse:collapse;
    }

    table, th, td{
        border:1px solid black;
    }

    th, td{
        padding:8px;
        text-align:center;
    }
    </style>
</head>
<body>

<h2 align="center">Laporan Data Anggota Koperasi</h2>

<button onclick="window.print()">
    Cetak Laporan
</button>

<br><br>

<table>
<tr>
    <th>No</th>
    <th>No Anggota</th>
    <th>Nama</th>
    <th>Alamat</th>
    <th>No HP</th>
    <th>Pekerjaan</th>
</tr>

<?php $no=1; ?>
<?php foreach($anggota as $a): ?>

<tr>
    <td><?= $no++; ?></td>
    <td><?= $a['no_anggota']; ?></td>
    <td><?= $a['nama']; ?></td>
    <td><?= $a['alamat']; ?></td>
    <td><?= $a['no_hp']; ?></td>
    <td><?= $a['pekerjaan']; ?></td>
</tr>

<?php endforeach; ?>

</table>

</body>
</html>