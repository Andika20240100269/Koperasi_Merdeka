<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

require 'functions.php';

$angsuran = query("
SELECT
a.*,
p.no_anggota
FROM angsuran a
JOIN pinjaman p
ON a.id_pinjaman = p.id
ORDER BY a.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Angsuran</title>
</head>

<body>

<h2>Data Angsuran</h2>

<a href="tambah_angsuran.php">
<button>Tambah Angsuran</button>
</a>

<br><br>

<table border="1" cellpadding="10">

<tr>
<th>No</th>
<th>No Anggota</th>
<th>Tanggal Bayar</th>
<th>Jumlah Bayar</th>
</tr>

<?php $i=1; ?>

<?php foreach($angsuran as $a) : ?>

<tr>

<td><?= $i++; ?></td>

<td><?= $a['no_anggota']; ?></td>

<td><?= $a['tanggal_bayar']; ?></td>

<td>
Rp <?= number_format($a['jumlah_bayar'],0,',','.'); ?>
</td>

</tr>

<?php endforeach; ?>

</table>

</body>
</html>