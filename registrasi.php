<?php
require 'functions.php';

if (isset($_POST['registrasi'])) {

    if (registrasi($_POST) > 0) {

        echo "
        <script>
            alert('Registrasi berhasil! Silakan login.');
            document.location.href='login.php';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Registrasi gagal!');
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
    <title>Registrasi User Koperasi</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f4f4f4;
        }

        .container{
            width:400px;
            margin:50px auto;
            background:white;
            padding:20px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.2);
        }

        h2{
            text-align:center;
        }

        input{
            width:100%;
            padding:10px;
            margin-top:5px;
            margin-bottom:15px;
            box-sizing:border-box;
        }

        button{
            padding:10px;
            width:100%;
            cursor:pointer;
        }

        .login-link{
            text-align:center;
            margin-top:15px;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Registrasi User Koperasi</h2>

    <form action="" method="POST">

        <label>Username</label>
        <input
            type="text"
            name="username"
            required
            autofocus
            autocomplete="off">

        <label>Password</label>
        <input
            type="password"
            name="password1"
            required>

        <label>Konfirmasi Password</label>
        <input
            type="password"
            name="password2"
            required>

        <button type="submit" name="registrasi">
            Registrasi
        </button>

    </form>

    <div class="login-link">
        Sudah punya akun?
        <a href="login.php">Login di sini</a>
    </div>

</div>

</body>
</html>