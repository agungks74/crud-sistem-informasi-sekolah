<?php
require "init.php";

$kelas = new Kelas();
$DB = DB::getInstance();

if (!empty($_POST)) {
    $daftarSiswa = array_keys($_POST, "on");
    $idKelas = $_POST['kelas'];
    // Dah ngantuk besok aja buat validasinya
    // $pesanError = $kelas->validasi($_POST, $selectOption);

    foreach ($daftarSiswa as $siswa) {
        $kelas->insertToClass($idKelas, $siswa);
    }
}

$tabelKelas = $DB->get('kelas');
$DB->select('siswa.nis, siswa.nama');
$tabelSiswa = $DB->get('siswa', 'LEFT JOIN kelas_siswa ON kelas_siswa.nis = siswa.nis WHERE kelas_siswa.idk IS NULL');


// echo isset($tabelSiswa[0]->kelas)?"as":"skjd";
// die;
// $tabelKelas = $tabelTemp;
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
            <div class="col-12 py-4">
                <h1 class="h2 text-info">Atur Kelas Siswa</h1><br>
                <form method="post">
                    <div class="form-group w-25">
                        <label for="kelas">Pilih Kelas Siswa : </label>
                        <select class="form-control" name="kelas" id="kelas">
                            <?php
                                foreach ($tabelKelas as $kelas) {
                                    echo "<option value=\"{$kelas->idk}\">{$kelas->nama}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <h5 class="text-center">Daftar Siswa Belum Terdaftar:</h5><br>
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>NIS</th>
                                <th>Nama Siswa</th>

                                <th>Masukkan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                    foreach ($tabelSiswa as $siswa) {
                                        echo "<tr class='text-center'>";
                                        echo "<th>{$siswa->nis}</th>";
                                        echo "<td>{$siswa->nama}</td>";
                         
                                        echo "<td>";
                                        echo "<input type=\"checkbox\" name=\"{$siswa->nis}\">";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                ?>
                        </tbody>
                    </table>

                    <input type="submit" value="Masukkan" class="btn btn-info">
                    <a href="dashboard.php" class="btn btn-danger">Selesai</a>

                </form>


            </div>
        </div>
    </div>
    <?php include "template/footer.php";
