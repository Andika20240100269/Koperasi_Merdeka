<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

// Ambil pinjaman yang belum lunas
$pinjaman = query("
    SELECT *
    FROM pinjaman
    WHERE status = 'Belum Lunas'
    ORDER BY id DESC
");

if (isset($_POST['simpan'])) {

    if (tambahAngsuran($_POST) > 0) {

        echo "
        <script>
            alert('Data angsuran berhasil ditambahkan');
            document.location.href='data_angsuran.php';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Data angsuran gagal ditambahkan');
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Angsuran</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            margin:20px;
        }

        form{
            width:400px;
        }

        input,
        select{
            width:100%;
            padding:8px;
            margin-top:5px;
        }

        button{
            padding:8px 15px;
            margin-top:10px;
        }
    </style>
</head>

<body>

<h2>Tambah Angsuran</h2>

<form action="" method="post">

    <p>
        Pinjaman
        <br>

        <select name="id_pinjaman" required>

            <option value="">
                -- Pilih Pinjaman --
            </option>

            <?php foreach ($pinjaman as $p) : ?>

            <option value="<?= $p['id']; ?>">
                <?= $p['no_anggota']; ?>
                -
                Rp <?= number_format($p['jumlah_pinjaman'],0,',','.'); ?>
            </option>

            <?php endforeach; ?>

        </select>

    </p>

    <p>
        Tanggal Bayar
        <br>

        <input
            type="date"
            name="tanggal_bayar"
            value="<?= date('Y-m-d'); ?>"
            required>

    </p>

    <p>
        Jumlah Bayar
        <br>

        <input
            type="number"
            name="jumlah_bayar"
            min="1000"
            required>

    </p>

    <button type="submit" name="simpan">
        Simpan
    </button>

    <a href="data_angsuran.php">
        <button type="button">
            Kembali
        </button>
    </a>

</form>

</body>
</html>