<?php

function koneksi()
{
    return mysqli_connect('localhost', 'root', '', 'db_koperasi');
}

function query($query)
{
    $conn = koneksi();
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query Error : " . mysqli_error($conn));
    }

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

// ======================
// UPLOAD FOTO
// ======================

function upload()
{
    $nama_file = $_FILES['foto']['name'];
    $ukuran_file = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmp_file = $_FILES['foto']['tmp_name'];

    if ($error == 4) {
        return 'nophoto.jpg';
    }

    $ekstensi_valid = ['jpg', 'jpeg', 'png'];
    $ekstensi = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    if (!in_array($ekstensi, $ekstensi_valid)) {
        echo "<script>alert('File harus JPG, JPEG, atau PNG');</script>";
        return false;
    }

    if ($ukuran_file > 5000000) {
        echo "<script>alert('Ukuran file maksimal 5 MB');</script>";
        return false;
    }

    $nama_baru = uniqid();
    $nama_baru .= '.';
    $nama_baru .= $ekstensi;

    move_uploaded_file($tmp_file, 'img/' . $nama_baru);

    return $nama_baru;
}

// ======================
// CRUD ANGGOTA
// ======================

function tambah($data)
{
    $conn = koneksi();

    $nama = htmlspecialchars($data['nama']);
    $alamat = htmlspecialchars($data['alamat']);
    $no_hp = htmlspecialchars($data['no_hp']);
    $pekerjaan = htmlspecialchars($data['pekerjaan']);
    $tanggal_daftar = htmlspecialchars($data['tanggal_daftar']);
    $status_anggota = htmlspecialchars($data['status_anggota']);

    $foto = upload();

    if (!$foto) {
        return false;
    }

    mysqli_query($conn, "
        INSERT INTO anggota
        (
            nama,
            alamat,
            no_hp,
            pekerjaan,
            tanggal_daftar,
            status_anggota,
            foto
        )
        VALUES
        (
            '$nama',
            '$alamat',
            '$no_hp',
            '$pekerjaan',
            '$tanggal_daftar',
            '$status_anggota',
            '$foto'
        )
    ");

    $id_anggota = mysqli_insert_id($conn);

    $no_anggota = 'AGT' . str_pad($id_anggota, 4, '0', STR_PAD_LEFT);
    $password_default = password_hash('12345', PASSWORD_DEFAULT);

    mysqli_query($conn,"
    INSERT INTO user_anggota
    (
        no_anggota,
        password
    )
    VALUES
    (
        '$no_anggota',
        '$password_default'
    )
");

    mysqli_query($conn, "
        UPDATE anggota
        SET no_anggota = '$no_anggota'
        WHERE id_anggota = '$id_anggota'
    ");

    return mysqli_affected_rows($conn);
}

function hapus($id)
{
    $conn = koneksi();

    $anggota = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT * FROM anggota WHERE id_anggota = $id")
    );

    if (
    $anggota &&
    $anggota['foto'] != 'nophoto.jpg' &&
    file_exists('img/' . $anggota['foto'])
    ) {
    unlink('img/' . $anggota['foto']);
    }

    mysqli_query($conn, "DELETE FROM anggota WHERE id_anggota = $id");

    return mysqli_affected_rows($conn);
}

function ubah($data)
{
    $conn = koneksi();

    $id = $data['id_anggota'];
    $nama = htmlspecialchars($data['nama']);
    $alamat = htmlspecialchars($data['alamat']);
    $no_hp = htmlspecialchars($data['no_hp']);
    $pekerjaan = htmlspecialchars($data['pekerjaan']);
    $tanggal_daftar = htmlspecialchars($data['tanggal_daftar']);
    $status_anggota = htmlspecialchars($data['status_anggota']);

    $foto_lama = $data['foto_lama'];

    $foto = upload();

    if (!$foto) {
        return false;
    }

    if ($foto == 'nophoto.jpg') {
        $foto = $foto_lama;
    }

    if (
    $foto != $foto_lama &&
    $foto_lama != 'nophoto.jpg' &&
    file_exists('img/' . $foto_lama)
    ) {
    unlink('img/' . $foto_lama);
    }

    mysqli_query($conn, "
        UPDATE anggota SET
            nama = '$nama',
            alamat = '$alamat',
            no_hp = '$no_hp',
            pekerjaan = '$pekerjaan',
            tanggal_daftar = '$tanggal_daftar',
            status_anggota = '$status_anggota',
            foto = '$foto'
        WHERE id_anggota = '$id'
    ");

    return mysqli_affected_rows($conn);
}

function cari($keyword)
{
    $conn = koneksi();

    $result = mysqli_query($conn, "
        SELECT *
        FROM anggota
        WHERE nama LIKE '%$keyword%'
        OR no_anggota LIKE '%$keyword%'
        OR alamat LIKE '%$keyword%'
    ");

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

// ======================
// LOGIN
// ======================

function login($data)
{
    $conn = koneksi();

    $username = mysqli_real_escape_string(
        $conn,
        $data['username']
    );

    $password = $data['password'];

    $result = mysqli_query(
        $conn,
        "SELECT * FROM user WHERE username='$username'"
    );

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {

            $_SESSION['login'] = true;
            $_SESSION['username'] = $user['username'];

            header("Location: index.php");
            exit;
        }
    }

    return [
        'error' => true,
        'pesan' => 'Username atau Password salah!'
    ];
}

// ======================
// REGISTRASI
// ======================

function registrasi($data)
{
    $conn = koneksi();

    $username = strtolower(trim($data['username']));
    $password1 = $data['password1'];
    $password2 = $data['password2'];

    if (
        empty($username) ||
        empty($password1) ||
        empty($password2)
    ) {
        return false;
    }

    $cek = mysqli_query(
        $conn,
        "SELECT * FROM user WHERE username='$username'"
    );

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah terdaftar!');</script>";
        return false;
    }

    if ($password1 != $password2) {
        echo "<script>alert('Konfirmasi password tidak sesuai!');</script>";
        return false;
    }

    if (strlen($password1) < 4) {
        echo "<script>alert('Password minimal 4 karakter!');</script>";
        return false;
    }

    $password_hash = password_hash(
        $password1,
        PASSWORD_DEFAULT
    );

    mysqli_query($conn, "
        INSERT INTO user
        (
            username,
            password
        )
        VALUES
        (
            '$username',
            '$password_hash'
        )
    ");

    return mysqli_affected_rows($conn);
}

// ======================
// SIMPANAN
// ======================

function tambahSimpanan($data)
{
    $conn = koneksi();

    $no_anggota = htmlspecialchars($data['no_anggota']);
    $jenis_simpanan = htmlspecialchars($data['jenis_simpanan']);
    $jumlah = htmlspecialchars($data['jumlah']);
    $tanggal = htmlspecialchars($data['tanggal']);

    mysqli_query($conn, "
        INSERT INTO simpanan
        (
            no_anggota,
            jenis_simpanan,
            jumlah,
            tanggal
        )
        VALUES
        (
            '$no_anggota',
            '$jenis_simpanan',
            '$jumlah',
            '$tanggal'
        )
    ");

    return mysqli_affected_rows($conn);
}

function hapusSimpanan($id)
{
    $conn = koneksi();

    mysqli_query(
        $conn,
        "DELETE FROM simpanan WHERE id = $id"
    );

    return mysqli_affected_rows($conn);
}

function ubahSimpanan($data)
{
    $conn = koneksi();

    $id = $data['id'];
    $no_anggota = htmlspecialchars($data['no_anggota']);
    $jenis_simpanan = htmlspecialchars($data['jenis_simpanan']);
    $jumlah = htmlspecialchars($data['jumlah']);
    $tanggal = htmlspecialchars($data['tanggal']);

    mysqli_query($conn, "
        UPDATE simpanan SET
            no_anggota = '$no_anggota',
            jenis_simpanan = '$jenis_simpanan',
            jumlah = '$jumlah',
            tanggal = '$tanggal'
        WHERE id = '$id'
    ");

    return mysqli_affected_rows($conn);
}

function cariSimpanan($keyword)
{
    $conn = koneksi();

    $result = mysqli_query($conn, "
        SELECT *
        FROM simpanan
        WHERE no_anggota LIKE '%$keyword%'
        OR jenis_simpanan LIKE '%$keyword%'
    ");

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function totalSimpanan($no_anggota)
{
    $conn = koneksi();

    $result = mysqli_query($conn, "
        SELECT SUM(jumlah) AS total
        FROM simpanan
        WHERE no_anggota = '$no_anggota'
    ");

    return mysqli_fetch_assoc($result);
}

function jumlahAnggota()
{
    $data = query("
        SELECT COUNT(*) AS total
        FROM anggota
    ");

    return $data[0]['total'] ?? 0;
}

function totalSimpananKeseluruhan()
{
    $data = query("
        SELECT SUM(jumlah) AS total
        FROM simpanan
    ");

    return $data[0]['total'] ?? 0;
}

function totalPinjamanKeseluruhan()
{
    $data = query("
        SELECT SUM(jumlah_pinjaman) AS total
        FROM pinjaman
    ");

    return $data[0]['total'] ?? 0;
}

function tambahPinjaman($data)
{
    $conn = koneksi();

    $no_anggota = htmlspecialchars($data['no_anggota']);
    $jumlah_pinjaman = htmlspecialchars($data['jumlah_pinjaman']);
    $lama_angsuran = htmlspecialchars($data['lama_angsuran']);
    $bunga = htmlspecialchars($data['bunga']);
    $tanggal_pinjaman = htmlspecialchars($data['tanggal_pinjaman']);
    $status = htmlspecialchars($data['status']);

    mysqli_query($conn,"
        INSERT INTO pinjaman
        (
            no_anggota,
            jumlah_pinjaman,
            lama_angsuran,
            bunga,
            tanggal_pinjaman,
            status
        )
        VALUES
        (
            '$no_anggota',
            '$jumlah_pinjaman',
            '$lama_angsuran',
            '$bunga',
            '$tanggal_pinjaman',
            '$status'
        )
    ");

    return mysqli_affected_rows($conn);
}

// ======================
// ANGSURAN
// ======================

function tambahAngsuran($data)
{
    $conn = koneksi();

    $id_pinjaman   = htmlspecialchars($data['id_pinjaman']);
    $tanggal_bayar = htmlspecialchars($data['tanggal_bayar']);
    $jumlah_bayar  = htmlspecialchars($data['jumlah_bayar']);

    mysqli_query($conn,"
        INSERT INTO angsuran
        (
            id_pinjaman,
            tanggal_bayar,
            jumlah_bayar
        )
        VALUES
        (
            '$id_pinjaman',
            '$tanggal_bayar',
            '$jumlah_bayar'
        )
    ");

    $pinjaman = query("
        SELECT jumlah_pinjaman
        FROM pinjaman
        WHERE id = '$id_pinjaman'
    ");

    $jumlahPinjaman = $pinjaman[0]['jumlah_pinjaman'];

    $totalBayar = query("
        SELECT SUM(jumlah_bayar) AS total
        FROM angsuran
        WHERE id_pinjaman = '$id_pinjaman'
    ");

    $sudahBayar = $totalBayar[0]['total'] ?? 0;

    if ($sudahBayar >= $jumlahPinjaman) {

        mysqli_query($conn,"
            UPDATE pinjaman
            SET status = 'Lunas'
            WHERE id = '$id_pinjaman'
        ");
    }

    return 1;
}

function sisaPinjaman($id_pinjaman)
{
    $pinjaman = query("
        SELECT jumlah_pinjaman,
               bunga,
               lama_angsuran
        FROM pinjaman
        WHERE id = '$id_pinjaman'
    ");

    if (empty($pinjaman)) {
        return 0;
    }

    $jumlahPinjaman = $pinjaman[0]['jumlah_pinjaman'];
    $bunga = $pinjaman[0]['bunga'];
    $lama = $pinjaman[0]['lama_angsuran'];

    // Hitung total pinjaman + bunga
    $totalPinjaman =
        $jumlahPinjaman +
        (($jumlahPinjaman * $bunga / 100) * $lama);

    $angsuran = query("
        SELECT SUM(jumlah_bayar) AS total
        FROM angsuran
        WHERE id_pinjaman = '$id_pinjaman'
    ");

    $totalBayar = $angsuran[0]['total'] ?? 0;

    return $totalPinjaman - $totalBayar;
}

function totalAngsuranKeseluruhan()
{
    $data = query("
        SELECT SUM(jumlah_bayar) AS total
        FROM angsuran
    ");

    return $data[0]['total'] ?? 0;
}

function totalBayarPinjaman($id_pinjaman)
{
    $data = query("
        SELECT SUM(jumlah_bayar) AS total
        FROM angsuran
        WHERE id_pinjaman = '$id_pinjaman'
    ");

    return $data[0]['total'] ?? 0;
}

function loginAnggota($data)
{
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }

    $conn = koneksi();

    $no_anggota = mysqli_real_escape_string(
        $conn,
        $data['no_anggota']
    );

    $password = $data['password'];

    $result = mysqli_query(
        $conn,
        "SELECT * FROM user_anggota
        WHERE no_anggota='$no_anggota'"
    );

    if(mysqli_num_rows($result) == 1){

        $user = mysqli_fetch_assoc($result);

        if(password_verify(
            $password,
            $user['password']
        )){

            $_SESSION['login_anggota'] = true;
            $_SESSION['no_anggota'] = $user['no_anggota'];

            header("Location: dashboard_anggota.php");
            exit;
        }
    }

    return false;
}
