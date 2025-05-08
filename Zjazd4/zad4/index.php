<?php

$filename = 'ips.txt';
if (!file_exists($filename)) {
    die('Brak pliku z zaufanymi adresami IP.');
}
$trusted_ips = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);


$user_ip = $_SERVER['REMOTE_ADDR'];

if (in_array($user_ip, $trusted_ips)) {
    define('SPECIAL_PAGE', true);
    include 'special.php';
} else {
    define('SPECIAL_PAGE', true);
    include 'default.php';
}
?>