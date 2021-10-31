<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,
    shrink-to-fit=no">
    <title>Sistem Informasi Sekolah</title>
    <link rel="icon" href="img/favicon.png" type="image/png">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container" class="py-5">
        <div class="row">
            <div class="col-12 py-4 mx-auto text-center">
                <h3 class="mt-5">Proses Generate Database</h3>
                <hr class="w-50">
                <ul style="list-style-type: none;">
                    <?php

//KONFIGURASI DATABASE SERVER DISINI
$host = "localhost";
$user = "root";
$pass = "";

$dsn = "mysql:host=$host";

try {
    $pdo = new PDO($dsn, $user, $pass);

    $query = "DROP DATABASE IF EXISTS SISekolah";

    $result = $pdo->query($query);

    if ($result !== false) {
        echo "<li>Database SISekolah berhasil dihapus ! </li>";
    }

    $query = "CREATE DATABASE SISekolah";

    $result = $pdo->query($query);

    if ($result !== false) {
        echo "<li>Database SISekolah berhasil dibuat ! </li>";
    }

    $pdo->query("USE SISekolah");

    $query = "DROP TABLE IF EXISTS guru";

    $result = $pdo->query($query);

    if ($result !== false) {
        echo "<li>Table guru berhasil dihapus ! </li>";
    }

    $query = <<<EOT
            CREATE TABLE guru (
                nig CHAR(8) PRIMARY KEY,
                nama VARCHAR(50),
                email VARCHAR(50),
                password VARCHAR(100),
                alamat VARCHAR(100)
            );
            EOT;
    
    $result = $pdo->query($query);

    if ($result !== false) {
        echo "<li>Table guru berhasil dibuat ! </li>";
    }

    $query = "DROP TABLE IF EXISTS kelas";

    $result = $pdo->query($query);

    if ($result !== false) {
        echo "<li>Table kelas berhasil dihapus ! </li>";
    }

    $query = <<<EOT
            CREATE TABLE kelas (
                idk CHAR(8) PRIMARY KEY,
                nama VARCHAR(50),
                nig CHAR(8) NOT NULL,
                FOREIGN KEY (nig) REFERENCES guru(nig) ON DELETE CASCADE
            );
            EOT;
    
    $result = $pdo->query($query);

    if ($result !== false) {
        echo "<li>Table kelas berhasil dibuat ! </li>";
    }

    $query = "DROP TABLE IF EXISTS siswa";

    $result = $pdo->query($query);

    if ($result !== false) {
        echo "<li>Table siswa berhasil dihapus ! </li>";
    }

    $query = <<<EOT
            CREATE TABLE siswa (
                nis CHAR(8) PRIMARY KEY,
                nama VARCHAR(50),
                email VARCHAR(50),
                password VARCHAR(100),
                alamat VARCHAR(100)
            );
            EOT;
    
    $result = $pdo->query($query);

    if ($result !== false) {
        echo "<li>Table siswa berhasil dibuat !</li>";
    }

    $query = <<<EOT
            CREATE TABLE kelas_siswa (
                id INT PRIMARY KEY AUTO_INCREMENT,
                nis CHAR(8),
                idk CHAR(8),
                FOREIGN KEY (nis) REFERENCES siswa(nis) ON DELETE CASCADE,
                FOREIGN KEY (idk) REFERENCES kelas(idk) ON DELETE CASCADE
            );
            EOT;
    
    $result = $pdo->query($query);

    if ($result !== false) {
        echo "<li>Table kelas siswa berhasil dibuat !</li>";
    }

    $query = <<<EOT
            CREATE TABLE admin (
                id INT PRIMARY KEY AUTO_INCREMENT,
                nama VARCHAR(50),
                email VARCHAR(50),
                password VARCHAR(100)
            );
            EOT;

    $result = $pdo->query($query);

    if ($result !== false) {
        echo "<li>Table admin berhasil dibuat!</li>";
    }

    $adminPassword = password_hash("admin123", PASSWORD_DEFAULT);

    $query = "INSERT INTO admin VALUES ('','admin','admin@admin.com','$adminPassword')";
    $result = $pdo->query($query);

    if ($result !== false) {
        echo "<li>Data admin berhasil ditambah!</li>";
    } ?>


                </ul>
                <hr class="w-50">
                <p class="lead">Database berhasil dibuat, silahkan <a href="login.php">
                        Login </a>dengan email: <code>admin@admin.com</code>, password: <code>admin123</code>
                    <br>Atau <a href="register.php">Register</a> untuk membuat user baru
                </p>

                <?php
} catch (PDOException $e) {
        die("Query / Koneksi Error: ". $e->getMessage() ." (" . $e->getCode() .")");
    } finally {
        $pdo = null;
    }
?>
            </div>
        </div>
    </div>
    <?php
    include "template/footer.php";
