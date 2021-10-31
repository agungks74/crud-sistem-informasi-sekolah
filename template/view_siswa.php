<?php
$DB = DB::getInstance();

$email_user = $_SESSION['email'];
$siswa = $DB->getWhereOnce('siswa', ['email','=',$email_user]);

$kelas_siswa = $DB->getWhereOnce('kelas_siswa', ['nis','=',$siswa->nis]);

$tabelSiswa = [];
if ($kelas_siswa) {
    $DB->select('kelas.nama AS nama_kelas, guru.nama AS wali_kelas');
    $kelas = $DB->get('kelas', 'INNER JOIN guru ON kelas.nig = guru.nig WHERE idk=?', [$kelas_siswa->idk])[0];
    
    $DB->select('siswa.*');
    $tabelSiswa = $DB->get('kelas_siswa', 'INNER JOIN siswa ON siswa.nis = kelas_siswa.nis WHERE idk=?', [$kelas_siswa->idk]);
}

if (!empty($_GET)) {
    $tableTemp = [];
    foreach ($tabelSiswa as $siswa) {
        if (preg_match("/". Input::get('search') ."/i", $siswa->nama)) {
            $tabelTemp[] = $siswa;
        }
    }

    $tabelSiswa = $tabelTemp;
}
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <?php if (!empty($tabelSiswa)) : ?>

            <div class="py-4 d-flex justify-content-end align-items-center">
                <h1 class="h2 mr-auto text-info">
                    Kelas <?= $kelas->nama_kelas; ?> :
                </h1>

                <form class="w-25 ml-4" method="get">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari siswa">
                        <div class="input-group-append">
                            <input type="submit" value="Cari" class="btn btn-outline-secondary">
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Email</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($tabelSiswa as $siswa) {
                            echo "<tr >";
                            echo "<th>{$siswa->nis}</th>";
                            echo "<td>{$siswa->nama}</td>";
                            echo "<td>{$siswa->email}</td>";
                            echo "<td>{$siswa->alamat}</td>";
                            echo "</tr>";
                        }
                     ?>
                </tbody>
            </table>
            <?php else: ?>
            <h3 class="text-center py-3">Tidak terdaftar ke kelas, hubungi admin !</h3>
            <?php endif; ?>
            <br>
            <p><b>Wali kelas : (<?= $kelas->wali_kelas?? ''; ?>)</b>
            </p>
        </div>
    </div>
</div>