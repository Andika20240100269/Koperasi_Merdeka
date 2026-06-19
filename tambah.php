<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

if (isset($_POST['tambah'])) {

    if (tambah($_POST) > 0) {
        echo "
        <script>
            alert('Data anggota berhasil ditambahkan!');
            document.location.href='index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data anggota gagal ditambahkan!');
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Anggota Koperasi</title>
</head>

<body>

<h1>Form Tambah Data Anggota Koperasi</h1>

<form action="" method="POST" enctype="multipart/form-data">

    <ul>

        <li>
            <label>Nama Anggota :</label><br>
            <input type="text"
                   name="nama"
                   required
                   autofocus>
        </li>

        <br>

        <li>
            <label>No Anggota :</label><br>
            <input type="text"
                   name="no_anggota"
                   placeholder="Contoh: AGT0001"
                   required>
        </li>

        <br>

        <li>
            <label>Alamat :</label><br>
            <textarea name="alamat"
                      rows="4"
                      cols="40"
                      required></textarea>
        </li>

        <br>

        <li>
            <label>No HP :</label><br>
            <input type="text"
                   name="no_hp"
                   required>
        </li>

        <br>

        <li>
            <label>Pekerjaan :</label><br>
            <input type="text"
                   name="pekerjaan"
                   required>
        </li>

        <br>

        <li>
            <label>Tanggal Daftar :</label><br>
            <input type="date"
                   name="tanggal_daftar"
                   value="<?= date('Y-m-d'); ?>"
                   required>
        </li>

        <br>

        <li>
            <label>Status Anggota :</label><br>
            <select name="status_anggota">
                <option value="Aktif" selected>Aktif</option>
                <option value="Nonaktif">Nonaktif</option>
            </select>
        </li>

        <br>

        <li>
            <label>Foto Anggota :</label><br>

            <input type="file"
                   name="foto"
                   accept=".jpg,.jpeg,.png"
                   onchange="previewImage()">

            <br><br>

            <img src="img/nophoto.jpg"
                 width="120"
                 class="img-preview">
        </li>

        <br>

        <li>
            <button type="submit" name="tambah">
                Simpan Data Anggota
            </button>

            <a href="index.php">
                Batal
            </a>
        </li>

    </ul>

</form>

<script src="js/script.js"></script>

</body>
</html>