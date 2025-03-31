<?php
session_start();

$_SESSION = [];

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

setcookie("token", '', time() - 3600, '/');

session_destroy();

session_regenerate_id(true);

header('Location: /login');
exit();
?>
