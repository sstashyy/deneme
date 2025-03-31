<?php
include_once('classes/database.php');
include_once('classes/login.php');
include_once('classes/functions.php');

use sstashy\JesuLogin;
use sstashy\System;
use sstashy\Functions;

$site_bilgi = System::table('settings')->where('id', 1)->first();

$title = htmlspecialchars($site_bilgi->title); 
$site_url = htmlspecialchars($site_bilgi->url); 
