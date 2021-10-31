<?php
require "init.php";

$user = new User;

if (!empty($_POST)) {
    $pesanError = $user->validasiLogin($_POST);
    if (empty($pesanError)) {
        $user->login();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="icon" href="img/favicon.png" type="image/png">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container pt-5">
        <?php if (!empty($pesanError)): ?>
        <div class="row">
            <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 mx-auto">
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">
                        <?php
                            foreach ($pesanError as $val) {
                                echo "<li>$val</li>";
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-10 col-sm-8 col-md-6 col-lg-5 col-xl-4 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4>Account Login</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" autocomplete="off">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email"
                                    value="<?php echo $user->getItem('email'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <input type="submit" class="btn btn-info btn-block" value="Login">
                        </form>
                        <p class="mt-2 text-center">
                            <small class="text-center">Belum terdaftar? Silahkan <a href="register.php">register</a>
                                terlebih dahulu</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "template/footer.php";
