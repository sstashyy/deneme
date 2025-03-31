<?php 
use sstashy\ZFunctions;

require_once "functions.php";
$commandId = 41;
$arguments = [
    'nick' => 'OwnerMehmz',
    'sebep' => '31'
];

$output = executeCommand($commandId, $arguments);
echo $output;
?>