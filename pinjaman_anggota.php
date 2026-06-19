<?php
session_start();

if (!isset($_SESSION['login_anggota'])) {
    header("Location: login_anggota.php");
    exit;
}

require 'functions.php';

$no_anggota = trim($_SESSION['no_anggota']);

/* ambil pinjaman khusus anggota ini */
$pinjaman = query("
    SELECT *
    FROM pinjaman
    WHERE no_anggota = '$no_anggota'
");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pinjaman Anggota</title>
</head>
<body>

<h2>Data Pinjaman Saya</h2>

<p>No Anggota: <b><?= $no_anggota; ?></b></p>

<hr>

<?php if (!empty($pinjaman)) : ?>
<table border="1" cellpadding="8">
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
        <td><?= $p['jumlah_pinjaman']; ?></td>
        <td><?= $p['lama_angsuran']; ?></td>
        <td><?= $p['tanggal_pinjaman']; ?></td>
        <td><?= $p['status']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else : ?>
<p><i>Belum ada data pinjaman</i></p>
<?php endif; ?>

<br>

<a href="dashboard_anggota.php">Kembali</a>

</body>
</html>