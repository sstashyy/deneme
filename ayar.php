<?php
date_default_timezone_set('Europe/Istanbul');
$baseurl = "http://blockcypher.live/";
$panelAdi = "";

$dataHost = "localhost";
$dataName = "u384784769_sstashypriv1";
$dataUser = "u384784769_sstashypriv1";
$dataPassword = "Ae175424";

try {
	$db = new PDO("mysql:host=$dataHost;port=3307;dbname=$dataName;charset=utf8", $dataUser, $dataPassword);

} catch (PDOException $e) {

    die("Veritabanına bağlanırken bir hata oluştu.");
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "functions.php";

ob_start();
?>
