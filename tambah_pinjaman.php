<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

require 'functions.php';

$anggota = query("SELECT * FROM anggota");

if(isset($_POST['simpan'])){

    if(tambahPinjaman($_POST) > 0){

        echo "
        <script>
            alert('Pinjaman berhasil ditambahkan');
            document.location.href='data_pinjaman.php';
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pinjaman</title>
</head>
<body>

<h2>Tambah Pinjaman</h2>

<form method="post">

<p>
Anggota
<br>

<select name="no_anggota" required>

<?php foreach($anggota as $a) : ?>

<option value="<?= $a['no_anggota']; ?>">
<?= $a['no_anggota']; ?> - <?= $a['nama']; ?>
</option>

<?php endforeach; ?>

</select>

</p>

<p>
Jumlah Pinjaman
<br>
<input type="number"
name="jumlah_pinjaman"
required>
</p>

<p>
Lama Angsuran (bulan)
<br>
<input type="number"
name="lama_angsuran"
required>
</p>

<p>
Bunga (%)
<br>
<input type="number"
name="bunga"
value="2"
step="0.01"
readonly>
</p>

<p>
Tanggal Pinjaman
<br>
<input type="date"
name="tanggal_pinjaman"
value="<?= date('Y-m-d'); ?>"
required>
</p>

<p>
Status
<br>

<select name="status">
<option value="Belum Lunas">Belum Lunas</option>
<option value="Lunas">Lunas</option>
</select>

</p>

<button type="submit" name="simpan">
Simpan
</button>

</form>

</body>
</html>