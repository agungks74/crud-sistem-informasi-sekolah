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
    $user->delete(Input::get('id'), $categories);
    header("Location: dashboard.php");
}

include "template/header.php";
?>

<div class="container">
    <div class="row">
        <div class="col-6 mx-auto">
            <div id="modalHapus">
                <div class="modal-dialog modal-confirm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Konfirmasi</h4>
                        </div>
                        <div class="modal-body">
                            <p>Apakah anda yakin akan menghapus
                                <b><?= $user->getItem('nama') ?></b>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <a href="dashboard.php" class="btn btn-secondary">Tidak</a>
                            <form method="post">
                                <input type="hidden" name="id_barang"
                                    value="<?= $user->getItem($categories); ?>">
                                <input type="submit" value="Ya" class="btn btn-danger">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "template/footer.php";
