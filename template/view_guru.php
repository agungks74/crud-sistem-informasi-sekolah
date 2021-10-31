<?php

$email_user = $_SESSION['email'];
$guru = $DB->getWhereOnce('guru', ['email','=',$email_user]);
$kelas = $DB->getWhereOnce('kelas', ['nig','=',$guru->nig]);

$tabelSiswa = [];
if ($kelas) {
    $DB->select('siswa.*');
    $tabelSiswa = $DB->get('kelas_siswa', 'INNER JOIN siswa ON siswa.nis = kelas_siswa.nis WHERE idk=?', [$kelas->idk]);
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
                    Daftar siswa :
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
                        <th>Action</th>
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
                            echo "<td class=\"text-center\">";
                            echo "<a href=\"edit_user.php?categories=siswa&id={$siswa->nis}\" class=\"btn btn-info\">Edit</a> ";
                            echo "<a href=\"lepas_siswa.php?id={$siswa->nis}\" class=\"btn btn-danger\">Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                     ?>
                </tbody>
            </table>
            <?php else: ?>
            <h3 class="text-center py-3">Tidak ada data siswa, hubungi admin !</h3>
            <?php endif; ?>
            <p><b>Kelas : (<?= $kelas->nama?? 'Belum ada kelas yang di asuh'; ?>)</b>
            </p>

        </div>
    </div>
</div>