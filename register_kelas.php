<?php
require "init.php";

$kelas = new Kelas();


$DB = DB::getInstance();

$tabelGuru = $DB->get('guru');
$DB->select('nig');
$tabelKelas = $DB->get('kelas');

if (!empty($_POST)) {
    $selectOption = "";
    if (!empty($tabelGuru)) {
        for ($i=0;$i<count($tabelGuru)-1;$i++) {
            $selectOption .= $tabelGuru[$i]->nig ."|";
        }
    
        $selectOption .= $tabelGuru[count($tabelGuru)-1]->nig;
    }


    $pesanError = $kelas->validasi($_POST, $selectOption);
    if (empty($pesanError)) {
        $kelas->insert();

        header("Location: dashboard.php?add_class=success");
    }
}

$tabelTemp = [];
foreach ($tabelKelas as $kelas) {
    $tabelTemp[] = $kelas->nig;
}

$tabelKelas = $tabelTemp;
// echo "<pre>";
// var_dump(in_array('74776631', $tabelKelas));
// echo "</pre>";
// die;



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah</title>
    <link rel="icon" href="img/favicon.png" type="image/png">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-6 py-4">
                <h1 class="h2 mr-auto">
                    <a href="register_user.php" class="text-info">Tambah Kelas Baru</a>
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
                        <label for="nama_kelas">Nama Kelas</label>
                        <input type="text" name="nama_kelas" id="nama_kelas" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="wali_kelas">Wali Kelas : </label>
                        <select class="form-control" name="wali_kelas" id="wali_kelas">

                            <?php
                                foreach ($tabelGuru as $guru) {
                                    if (!in_array($guru->nig, $tabelKelas)) {
                                        echo "<option value=\"$guru->nig\">($guru->nig) $guru->nama</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>

                    <input type="submit" value="Tambah" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
    <?php include "template/footer.php";
