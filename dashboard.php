<?php
require "init.php";

$user = new User();

$user->cekUserSession();

$DB= DB::getInstance();
$kategori_user = $_SESSION['categories'];

include "template/header.php";
?>

<?php
if ($kategori_user == 'siswa') {
    include 'template/view_siswa.php';
} elseif ($kategori_user == 'guru') {
    include 'template/view_guru.php';
} elseif ($kategori_user == 'admin') {
    include 'template/view_admin.php';
}

?>


<?php
include "template/footer.php";
