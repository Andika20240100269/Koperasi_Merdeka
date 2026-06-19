<?php
session_start();

// Jika sudah login, langsung ke index
if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

require 'functions.php';

if (isset($_POST['login'])) {

    $login = login($_POST);

}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Koperasi</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f4f4f4;
        }

        .container{
            width:350px;
            margin:100px auto;
            background:white;
            padding:20px;
            border-radius:8px;
            box-shadow:0 0 10px rgba(0,0,0,.2);
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
            width:100%;
            padding:10px;
            background:#007bff;
            color:white;
            border:none;
            cursor:pointer;
        }

        button:hover{
            background:#0056b3;
        }

        .error{
            color:red;
            margin-bottom:15px;
        }

        .register{
            text-align:center;
            margin-top:15px;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Login Koperasi</h2>

    <?php if(isset($login['error'])) : ?>
        <p class="error">
            <?= $login['pesan']; ?>
        </p>
    <?php endif; ?>

    <form action="" method="POST">

        <label>Username</label>
        <input
            type="text"
            name="username"
            required
            autofocus>

        <label>Password</label>
        <input
            type="password"
            name="password"
            required>

        <button type="submit" name="login">
            Login
        </button>

    </form>

    <div class="register">
        <a href="registrasi.php">
            Tambah User Baru
        </a>
    </div>

</div>

</body>
</html>