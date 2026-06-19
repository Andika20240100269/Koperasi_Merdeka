<?php
session_start();

if (!isset($_SESSION['login_anggota'])) {
    header("Location: login_anggota.php");
    exit;
}

require 'functions.php';

$no_anggota = $_SESSION['no_anggota'];

$simpanan = query("
    SELECT *
    FROM simpanan
    WHERE no_anggota = '$no_anggota'
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Simpanan Saya</title>
</head>
<body>

<h2>Data Simpanan Saya</h2>

<a href="dashboard_anggota.php">Kembali</a>

<br><br>

<table border="1" cellpadding="10" cellspacing="0">

<tr>
    <th>No</th>
    <th>Jenis Simpanan</th>
    <th>Jumlah</th>
    <th>Tanggal</th>
</tr>

<?php if(count($simpanan) > 0): ?>

    <?php $i=1; ?>

    <?php foreach($simpanan as $s): ?>

    <tr>
        <td><?= $i++; ?></td>
        <td><?= $s['jenis_simpanan']; ?></td>
        <td>
            Rp <?= number_format($s['jumlah'],0,',','.'); ?>
        </td>
        <td><?= $s['tanggal']; ?></td>
    </tr>

    <?php endforeach; ?>

<?php else: ?>

<tr>
    <td colspan="4">
        Belum ada data simpanan.
    </td>
</tr>

<?php endif; ?>

</table>

</body>
</html>