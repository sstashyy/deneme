<?php
ob_start();
session_start();
include_once('system/main.php');


define('SITEURL', $site_url);
define('MPAGE', 'pages/');
define('INC', 'inc/');

use sstashy\ZFunctions;

$userInfo = ZFunctions::getUserViaSession();

if(!isset($_SESSION['authKey']) || empty($_SESSION['authKey'])) {
    header("Location: /login");
    exit();
}

ZFunctions::roleControl();


ZFunctions::authControl();
$purna = ZFunctions::getUserID("KillerUser623");

?>
<head>
<?php include_once(INC . 'head.php') ?>

</head>
<body>
<?php include_once(INC . 'sidebar.php') ?>
<?php include_once(INC . 'navbar.php') ?>


<?php
if (isset($_GET["sayfa"]) && !empty($_GET["sayfa"])) {
    if (preg_match('/^[a-zA-Z0-9_-]+$/', $_GET['sayfa'])) {
        $dosya_yolu = MPAGE . $_GET['sayfa'] . ".php"; 
        if (file_exists($dosya_yolu) && is_file($dosya_yolu) && strpos($dosya_yolu, MPAGE) === 0) {
            include_once($dosya_yolu);
        } else {
            echo "Dosya yok veya geçersiz dosya adı: " . htmlspecialchars($_GET['sayfa']);
            include_once(MPAGE . "body.php");
        }
    } else {
        echo "Geçersiz dosya adı: " . htmlspecialchars($_GET['sayfa']);
        include_once(MPAGE . "body.php");
    }
} else {
    include_once(MPAGE . "body.php");
}
?>






<?= include_once(INC . 'footer.php') ?>

</body>
</html>