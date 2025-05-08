<?php

$filename = 'licznik.txt';

if (!file_exists($filename)) {
    file_put_contents($filename, '0');
}

$count = (int)file_get_contents($filename);
$count++;

file_put_contents($filename, (string)$count);

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zad2 - Licznik odwiedzin</title>
</head>
<body>
    <h1>Liczba odwiedzin: <?php echo $count; ?></h1>
</body>
</html>