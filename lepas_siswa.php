<?php
require "init.php";

$user = new User();
$user->cekUserSession();

if (empty(Input::get('id'))) {
    die('Maaf halaman ini tidak bisa diakses langsung');
}


$kelas = new Kelas();
$kelas->generate(Input::get('id'));


if (!empty($_POST)) {
    $kelas->deleteFromClass(Input::get('id'));
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
                            <p>Apakah anda yakin akan mengeluarkan
                                <b><?= $kelas->getItem('nama') ?></b>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <a href="dashboard.php" class="btn btn-secondary">Tidak</a>
                            <form method="post">
                                <input type="hidden" name="id_barang"
                                    value="<?= $kelas->getItem($categories); ?>">
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
