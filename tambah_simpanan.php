<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

// Ambil data anggota untuk dropdown
$anggota = query("SELECT * FROM anggota ORDER BY nama ASC");

if (isset($_POST['simpan'])) {

    if (tambahSimpanan($_POST) > 0) {

        echo "
        <script>
            alert('Data simpanan berhasil ditambahkan');
            document.location.href='data_simpanan.php';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Data simpanan gagal ditambahkan');
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Simpanan</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            margin:20px;
        }

        form{
            width:400px;
        }

        input, select{
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

<h2>Tambah Simpanan Anggota</h2>

<form action="" method="post">

    <p>
        No Anggota / Nama
        <br>

        <select name="no_anggota" required>

            <option value="">-- Pilih Anggota --</option>

            <?php foreach($anggota as $a) : ?>

            <option value="<?= $a['no_anggota']; ?>">
                <?= $a['no_anggota']; ?> - <?= $a['nama']; ?>
            </option>

            <?php endforeach; ?>

        </select>

    </p>

    <p>
        Jenis Simpanan
        <br>

        <select name="jenis_simpanan" required>
            <option value="Pokok">Pokok</option>
            <option value="Wajib">Wajib</option>
            <option value="Sukarela">Sukarela</option>
        </select>

    </p>

    <p>
        Jumlah
        <br>

        <input
            type="number"
            name="jumlah"
            min="1000"
            required>

    </p>

    <p>
        Tanggal
        <br>

        <input
            type="date"
            name="tanggal"
            value="<?= date('Y-m-d'); ?>"
            required>

    </p>

    <button type="submit" name="simpan">
        Simpan
    </button>

    <a href="data_simpanan.php">
        <button type="button">
            Kembali
        </button>
    </a>

</form>

</body>
</html>