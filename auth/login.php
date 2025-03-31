<?php
use sstashy\System;
include_once('../system/main.php');
use sstashy\JesuLogin;
use sstashy\ZFunctions;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);ob_start();
session_start();

$authKey = isset($_POST['authKey']) ? $_POST['authKey'] : null;
$userName = isset($_POST['userName']) ? $_POST['userName'] : null;

if($authKey && $userName) {
    $alert = JesuLogin::login();
}

if(isset($_SESSION['authKey']) && !empty($_SESSION['authKey']) && isset($_SESSION['userName']) && !empty($_SESSION['userName'])) { 
    header("Location: /");
    

    $avatarImage = ZFunctions::getAvatarImageUrl(ZFunctions::getUserID(ZFunctions::getUserViaSession()['userName']));
    $_SESSION['avatarImage'] = $avatarImage;

    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php include '../inc/head.php'; ?>

</head>

<body>
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

<form method="post">
        <!-- Sign Up Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Türk Sohbet</h3>
                            </a>
                            <h3>Giriş Yap</h3>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="userName" class="form-control" id="floatingText" placeholder="jhondoe">
                            <label for="floatingText">Roblox Username</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" name="authKey" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <a href="">Şifremi Unuttum</a>
                        </div>
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Giriş Yap</button>
                        </form>
                        <p class="text-center mb-0">Hesabın Yok Mu? <a href="/404">O zaman Yarramı Ye</a></p>
                    </div>
                </div>
            </div>
        <!-- Sign Up End -->
    </div>

    <?php include '../inc/purna.php'; ?>

</body>

</html>