<?php
mysqli_report(MYSQLI_REPORT_STRICT);

try {
    $mysqli = new mysqli("localhost", "root", "");

    $mysqli->select_db("SISekolah");

    if ($mysqli->error) {
        throw new Exception();
    }

    $query = "SELECT 1 FROM siswa";

    $mysqli->query($query);
    if ($mysqli->error) {
        throw new Exception();
    }

    $query = "SELECT 1 FROM guru";
    $mysqli->query($query);

    if ($mysqli->error) {
        throw new Exception();
    }

    $query = "SELECT 1 FROM kelas";
    $mysqli->query($query);

    if ($mysqli->error) {
        throw new Exception();
    }

    $query = "SELECT 1 FROM kelas";
    $mysqli->query($query);

    if ($mysqli->error) {
        throw new Exception();
    }

    
    $query = "SELECT 1 FROM admin";
    $mysqli->query($query);

    if ($mysqli->error) {
        throw new Exception();
    }
    if (isset($mysqli)) {
        $mysqli->close();
    }

    header("Location: login.php");
} catch (Exception $e) {
}

?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,
    shrink-to-fit=no">
    <title>Sistem Informasi Sekolah</title>
    <link rel="icon" href="img/favicon.png" type="image/png">
    <link rel="stylesheet" href="css/bootstrap.css">
</head>

<body>
    <div class="container" class="py-5">
        <div class="row">
            <div class="col-12 py-4 mx-auto text-center">
                <h3 class="mt-5">
                    Selamat datang di Aplikasi <strong>Sistem Informasi Sekolah</strong>
                </h3>
                <hr class="w-50">
                <p class="lead mt-5">Sistem kami mendeteksi database /
                    tabel belum tersedia, apakah ingin dibuat sekarang?</p>
                <a href="generate_database.php" class="btn btn-info">Ya</a>
                <a href="#" class="btn btn-danger">Tidak</a>
            </div>
        </div>
    </div>

    <?php
include "template/footer.php";
