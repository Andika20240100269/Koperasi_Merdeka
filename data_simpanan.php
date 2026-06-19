<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

// Ambil data simpanan
$simpanan = query("
    SELECT *
    FROM simpanan
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Simpanan Anggota</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
        }

        .btn {
            padding: 8px 15px;
            text-decoration: none;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #218838;
        }

        h2 {
            text-align: center;
        }
    </style>

</head>

<body>

    <h2>Data Simpanan Anggota</h2>

    <a href="index.php" class="btn">Kembali</a>
    <a href="tambah_simpanan.php" class="btn">Tambah Simpanan</a>

    <br><br>

    <table>

        <tr>
            <th>No</th>
            <th>No Anggota</th>
            <th>Jenis Simpanan</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
        </tr>

        <?php if (count($simpanan) > 0) : ?>
            <?php $i = 1; ?>
            <?php foreach ($simpanan as $row) : ?>

                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= htmlspecialchars($row['no_anggota']); ?></td>
                    <td><?= htmlspecialchars($row['jenis_simpanan']); ?></td>
                    <td>
                        Rp <?= number_format($row['jumlah'], 0, ',', '.'); ?>
                    </td>
                    <td><?= htmlspecialchars($row['tanggal']); ?></td>
                </tr>

            <?php endforeach; ?>

        <?php else : ?>

            <tr>
                <td colspan="5">
                    Data simpanan belum tersedia.
                </td>
            </tr>

        <?php endif; ?>

    </table>

</body>

</html>