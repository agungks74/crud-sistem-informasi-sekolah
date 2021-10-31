<div class="container">
    <div class="row">
        <div class="col-12">
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
                            if ($kategori_user == 'guru') {
                                echo "<td class=\"text-center\">";
                                echo "<a href=\"edit_user.php?id={$siswa->nis}\" class=\"btn btn-info\" disabled>Edit</a> ";
                                echo "<a href=\"hapus_user.php?id={$siswa->nis}\" class=\"btn btn-danger\">Hapus</a>";
                                echo "</td>";
                            } elseif ($siswa->email == $_SESSION['email']) {
                                echo "<td class='text-danger'><b>Sedang Login<b></td>";
                            } else {
                                echo "<td class=\"text-center\">-</td>";
                            }
                            echo "</tr>";
                        }
                     ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
        <?php if ($kategori_user != 'siswa'): ?>
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
                            if ($kategori_user == 'guru') {
                                if ($guru->email == $_SESSION['email']) {
                                    echo "<td class='text-danger'><b>Sedang Login<b></td>";
                                } else {
                                    echo "<td class=\"text-center\">";
                                    echo "<a href=\"edit_user.php?id={$guru->nig}\" class=\"btn btn-info\" disabled>Edit</a> ";
                                    echo "<a href=\"hapus_user.php?id={$guru->nig}\" class=\"btn btn-danger\">Hapus</a>";
                                    echo "</td>";
                                }
                            } else {
                                echo "<td class=\"text-center\">-</td>";
                            }
                            echo "</tr>";
                        }
                     ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>