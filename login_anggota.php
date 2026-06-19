<?php
session_start();
require 'functions.php';

$error = false;

if (isset($_POST['login'])) {

    if (!loginAnggota($_POST)) {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Anggota</title>
</head>
<body>

<h2>Login Anggota Koperasi</h2>

<?php if ($error) : ?>
<p style="color:red;">
    No Anggota atau Password Salah!
</p>
<?php endif; ?>

<form method="post">

    <p>
        No Anggota <br>
        <input
            type="text"
            name="no_anggota"
            required>
    </p>

    <p>
        Password <br>
        <input
            type="password"
            name="password"
            required>
    </p>

    <button
        type="submit"
        name="login">
        Login
    </button>

</form>

</body>
</html>