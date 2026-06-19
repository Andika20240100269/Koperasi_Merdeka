<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

// Cek ID
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Ambil data anggota
$anggota = query("SELECT * FROM anggota WHERE id_anggota = $id");

if (!$anggota) {
    echo "Data tidak ditemukan!";
    exit;
}

$anggota = $anggota[0];

// Proses ubah data
if (isset($_POST['ubah'])) {

    if (ubah($_POST) > 0) {

        echo "
        <script>
            alert('Data berhasil diubah!');
            document.location.href='index.php';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Data gagal diubah!');
            document.location.href='index.php';
        </script>
        ";
    }
}

$foto = !empty($anggota['foto'])
    ? $anggota['foto']
    : 'nophoto.jpg';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Data Anggota</title>
</head>
<body>

<h1>Ubah Data Anggota</h1>

<form action="" method="post" enctype="multipart/form-data">

    <input type="hidden"
           name="id_anggota"
           value="<?= $anggota['id_anggota']; ?>">

    <input type="hidden"
           name="foto_lama"
           value="<?= $foto; ?>">

    <ul>
        <li>
            <label>Nama</label><br>
            <input type="text"
                   name="nama"
                   required
                   value="<?= $anggota['nama']; ?>">
        </li>

        <li>
            <label>Alamat</label><br>
            <textarea name="alamat" required><?= $anggota['alamat']; ?></textarea>
        </li>

        <li>
            <label>No HP</label><br>
            <input type="text"
                   name="no_hp"
                   required
                   value="<?= $anggota['no_hp']; ?>">
        </li>

        <li>
            <label>Pekerjaan</label><br>
            <input type="text"
                   name="pekerjaan"
                   required
                   value="<?= $anggota['pekerjaan']; ?>">
        </li>

        <li>
            <label>Tanggal Daftar</label><br>
            <input type="date"
                   name="tanggal_daftar"
                   required
                   value="<?= $anggota['tanggal_daftar']; ?>">
        </li>

        <li>
            <label>Status Anggota</label><br>
            <select name="status_anggota">
                <option value="Aktif"
                    <?= ($anggota['status_anggota'] == 'Aktif') ? 'selected' : ''; ?>>
                    Aktif
                </option>

                <option value="Tidak Aktif"
                    <?= ($anggota['status_anggota'] == 'Tidak Aktif') ? 'selected' : ''; ?>>
                    Tidak Aktif
                </option>
            </select>
        </li>

        <li>
            <img src="img/<?= $foto; ?>" width="120">
        </li>

        <li>
            <label>Foto Baru</label><br>
            <input type="file" name="foto">
        </li>

        <li>
            <button type="submit" name="ubah">
                Simpan Perubahan
            </button>
        </li>
    </ul>

</form>

</body>
</html>