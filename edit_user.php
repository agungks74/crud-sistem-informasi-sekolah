<?php
require "init.php";

$user = new User();
$user->cekUserSession();
$categories = Input::get('categories');


if (empty(Input::get('id')) && empty($categories)) {
    die('Maaf halaman ini tidak bisa diakses langsung');
} elseif ($categories != 'guru' && $categories != 'siswa') {
    header("Location: dashboard.php");
}

$id_col = $categories=='guru'?'nig':'nis';

$user = new User();
$user->generate(Input::get('id'), $categories);

if (!empty($_POST)) {
    $pesanError = $user->validasiUpdate($_POST, $categories);
    if (empty($pesanError)) {
        $user->update($categories);
        header("Location: dashboard.php");
    }
}

include "template/header.php";
?>

<div class="container">
    <div class="row">
        <div class="col-6 py-4">
            <h1 class="h2 mr-auto">
                <a href="edit_barang.php" class="text-info">Edit <?= ucfirst($categories); ?>:
                </a>
            </h1>


            <?php if (!empty($pesanError)): ?>
            <div class="divPesanError">
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
                    <label for="<?= $id_col; ?>">Nomor Induk
                        <?= ucfirst($categories); ?></label>
                    <input type="text" name="<?= $id_col; ?>"
                        id="<?= $id_col; ?>" class="form-control"
                        value="<?= $user->getItem($id_col); ?>"
                        disabled>
                    <small class="d-block">*ID <?= ucfirst($categories); ?>
                        tidak bisa diubah</small>
                </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control"
                        value="<?= $user->getItem('nama'); ?>">
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control"
                        value="<?= $user->getItem('alamat'); ?>">
                </div>

                <input type="submit" value="Update" class="btn btn-primary">
                <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php include "template/footer.php";
