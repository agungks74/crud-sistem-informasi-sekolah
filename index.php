<?php
include "template/header.php";
?>

<div class="container" class="py-5">
    <div class="row">
        <div class="col-12 py-4 mx-auto text-center">
            <h3 class="mt-5">
                Selamat datang di Aplikasi <strong>Ilkoom Stock Manager</strong>
            </h3>
            <hr class="w-50">
            <p class="lead mt-5">Sistem kami mendeteksi database /
                tabel belum tersedia, apakah ingin dibuat sekarang?</p>
            <a href="db_generate_tabel_barang_dan_user.php" class="btn btn-info">Ya</a>
            <a href="#" class="btn btn-danger">Tidak</a>
        </div>
    </div>
</div>

<?php
include "template/footer.php";
