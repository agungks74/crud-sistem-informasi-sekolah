<?php
$host = "localhost";
$user = "root";
$pass = "";

$dsn = "mysql:host=$host";

try {
    $pdo = new PDO($dsn, $user, $pass);

    $query = "DROP DATABASE IF EXISTS SISekolah";

    $result = $pdo->query($query);

    if ($result !== false) {
        echo "Database SISekolah berhasil dihapus ! <br>";
    }

    $query = "CREATE DATABASE SISekolah";

    $result = $pdo->query($query);

    if ($result !== false) {
        echo "Database SISekolah berhasil dibuat ! <br>";
    }

    $pdo->query("USE SISekolah");

    $query = "DROP TABLE IF EXISTS guru";

    $result = $pdo->query($query);

    if ($result !== false) {
        echo "Table guru berhasil dihapus ! <br>";
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
        echo "Table guru berhasil dibuat ! <br>";
    }

    $query = "DROP TABLE IF EXISTS kelas";

    $result = $pdo->query($query);

    if ($result !== false) {
        echo "Table kelas berhasil dihapus ! <br>";
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
        echo "Table kelas berhasil dibuat ! <br>";
    }

    $query = "DROP TABLE IF EXISTS siswa";

    $result = $pdo->query($query);

    if ($result !== false) {
        echo "Table siswa berhasil dihapus ! <br>";
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
        echo "Table siswa berhasil dibuat ! <br>";
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
        echo "Table kelas siswa berhasil dibuat ! <br>";
    }
} catch (PDOException $e) {
    die("Query / Koneksi Error: ". $e->getMessage() ." (" . $e->getCode() .")");
} finally {
    $pdo = null;
}


// SELECT siswa.nama AS nama_siswa, kelas.nama AS kelas, guru.nama AS wali_kelas  from kelas_siswa INNER JOIN siswa ON siswa.nis = kelas_siswa.nis INNER JOIN kelas ON kelas.idk = kelas_siswa.idk INNER JOIN guru ON guru.nig = kelas.nig;
