<?php
require "init.php";

$user = new User();

if (!empty($_POST)) {
    $pesanError = $user->validasiInsert($_POST);

    if (empty($pesanError)) {
        $user->insert();
        header("Location: register_berhasil.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="icon" href="img/favicon.png" type="image/png">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-6 py-4">
                <h1 class="h2 mr-auto">
                    <a href="register_user.php" class="text-info">Register</a>
                </h1>

                <?php if (!empty($pesanError)): ?>
                <div id="divPesanError">
                    <div class="mx-auto">
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                <?php
                                    foreach ($pesanError as $pesan) {
                                        echo "<li>$pesan</li>";
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <form method="post">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <small> (minimal 6 karakter, harus terdapat angka dan huruf)</small>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="ulangi_password">Ulangi Password</label>
                        <input type="password" name="ulangi_password" id="ulangi_password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="categories">Kategori akun : </label>
                        <select class="form-control" name="categories" id="categories">
                            <option>Pilih Kategori : </option>
                            <option value="guru">Guru</option>
                            <option value="siswa">Siswa</option>
                        </select>
                    </div>

                    <input type="submit" value="Daftar" class="btn btn-primary">
                    <a href="login.php" class="btn btn-danger">Batal</a>
                </form>
            </div>
        </div>
    </div>
    <?php include "template/footer.php";
