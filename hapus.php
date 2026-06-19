<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

require 'functions.php';

//jika id tidak ada di URL
if (!isset($_GET['id'])) {
  header("location: index.php");
  exit;
}

//mengambil id dari url
$id = $_GET['id'];

//cek apaah tombol hapus sudah di klik
if (hapus($id) > 0) {
  echo "<script>
          alert ('data berhasil dihapus');
          document.location.href='index.php';
          </script>";
}
