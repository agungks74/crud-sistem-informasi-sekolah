<?php


$tabelSiswa = $DB->get('siswa');
$tabelGuru = $DB->get('guru');
$DB->select('idk, kelas.nama AS nama_kelas, guru.nama AS wali_kelas');
$tabelKelas = $DB->get('kelas', 'INNER JOIN guru ON guru.nig = kelas.nig');

// echo "<pre>";
// var_dump($tabelKelas);
// echo "</pre>";
// die;

if (!empty($_GET['add_class']) && $_GET['add_class'] == 'success') {
    echo "<script>alert('Kelas Baru berhasil ditambah !'</script>";
}

?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="py-4 d-flex justify-content-end align-items-center">
                <h1 class="h2 mr-auto text-info">
                    Daftar siswa :
                </h1>
                <a href="atur_kelas.php"
                    class="btn btn-info <?= empty($tabelKelas)?'disabled':''; ?>">Atur
                    Kelas</a>

                <form class="w-25 ml-4" method="get">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari siswa">
                        <div class="input-group-append">
                            <input type="submit" value="Cari" class="btn btn-outline-secondary">
                        </div>
                    </div>
                </form>
            </div>
            <?php if (!empty($tabelSiswa)) : ?>
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
                            echo "<a href=\"delete_user.php?categories=siswa&id={$siswa->nis}\" class=\"btn btn-danger\">Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                     ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
        <div class="col-12">
            <div class="py-4 d-flex justify-content-end align-items-center">
                <h1 class="h2 mr-auto text-info">
                    Daftar guru :
                </h1>

                <form class="w-25 ml-4" method="get">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari guru">
                        <div class="input-group-append">
                            <input type="submit" value="Cari" class="btn btn-outline-secondary">
                        </div>
                    </div>
                </form>
            </div>
            <?php if (!empty($tabelGuru)) : ?>
            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th>NIG</th>
                        <th>Nama Siswa</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($tabelGuru as $guru) {
                            echo "<tr class=\"text-center\">";
                            echo "<th>{$guru->nig}</th>";
                            echo "<td>{$guru->nama}</td>";
                            echo "<td>{$guru->email}</td>";
                            echo "<td>{$guru->alamat}</td>";
                            echo "<td class=\"text-center\">";
                            echo "<a href=\"edit_user.php?categories=guru&id={$guru->nig}\" class=\"btn btn-info\" disabled>Edit</a> ";
                            echo "<a href=\"delete_user.php?categories=guru&id={$guru->nig}\" class=\"btn btn-danger\">Hapus</a>";
                            echo "</td>";
             
                            echo "</tr>";
                        }
                     ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
        <div class="col-12">
            <div class="py-4 d-flex justify-content-end align-items-center">
                <h1 class="h2 mr-auto text-info">
                    Daftar Kelas :
                </h1>

                <a href="register_kelas.php" class="btn btn-info">Tambah Kelas</a>

                <form class="w-25 ml-4" method="get">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari kelas">
                        <div class="input-group-append">
                            <input type="submit" value="Cari" class="btn btn-outline-secondary">
                        </div>
                    </div>
                </form>
            </div>
            <?php if (!empty($tabelKelas)) : ?>
            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th>IDK</th>
                        <th>Nama Kelas</th>
                        <th>Wali Kelas</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($tabelKelas as $kelas) {
                            echo "<tr class=\"text-center\">";
                            echo "<th>{$kelas->idk}</th>";
                            echo "<td>{$kelas->nama_kelas}</td>";
                            echo "<td>{$kelas->wali_kelas}</td>";
                            echo "<td class=\"text-center\">";
                            echo "<a href=\"edit_kelas.php?id={$kelas->idk}\" class=\"btn btn-info\" disabled>Edit</a> ";
                            echo "<a href=\"delete_kelas.php?id={$kelas->idk}\" class=\"btn btn-danger\">Hapus</a>";
                            echo "</td>";
             
                            echo "</tr>";
                        }
                     ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>