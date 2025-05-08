<?php

$filename = 'links.txt';

if (!file_exists($filename)) {
    die('Plik z linkami nie istnieje.');
}

$lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zad3 - Lista odnośników</title>
</head>
<body>
    <h1>Lista odnośników</h1>
    <ul>
        <?php foreach ($lines as $line): ?>
            <?php list($url, $desc) = explode(';', $line, 2); ?>
            <li><a href="<?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>" target="_blank"><?php echo htmlspecialchars($desc, ENT_QUOTES, 'UTF-8'); ?></a></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>