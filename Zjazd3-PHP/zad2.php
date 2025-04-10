<?php
if (isset($_GET['n']) && is_numeric($_GET['n'])) {
    $n = intval($_GET['n']);

    function fibRecursive($n) {
        if ($n < 2) {
            return $n;
        }
        return fibRecursive($n - 1) + fibRecursive($n - 2);
    }

    function fibIterative($n) {
        if ($n < 2) {
            return $n;
        }
        $a = 0;
        $b = 1;
        for ($i = 2; $i <= $n; $i++) {
            $temp = $a + $b;
            $a = $b;
            $b = $temp;
        }
        return $b;
    }

    $startRecursive = microtime(true);
    $resultRecursive = fibRecursive($n);
    $timeRecursive = microtime(true) - $startRecursive;

    $startIterative = microtime(true);
    $resultIterative = fibIterative($n);
    $timeIterative = microtime(true) - $startIterative;

    echo "<h2>Porównanie wydajności ciągu Fibonacciego dla n = {$n}</h2>";
    echo "<p><strong>Rekurencyjny:</strong> {$resultRecursive}</p>";
    echo "<p><strong>Iteracyjny:</strong> {$resultIterative}</p>";
    echo "<p><strong>Rekurencyjny czas wykonania funkcji:</strong> {$timeRecursive} seconds</p>";
    echo "<p><strong>Iteracyjny czas wykonania funkcji:</strong> {$timeIterative} seconds</p>";

    if ($timeRecursive < $timeIterative) {
        $difference = $timeIterative - $timeRecursive;
        echo "<p>Funckja <strong>rekurencyjna</strong> była szybsza o {$difference} sekund.</p>";
    } elseif ($timeIterative < $timeRecursive) {
        $difference = $timeRecursive - $timeIterative;
        echo "<p>Funckja <strong>iteracyjna</strong> była szybsza o {$difference} sekund.</p>";
    } else {
        echo "<p>Obie funkcje działały tak samo długo.</p>";
    }

} else {
    echo "Podano nie prawidłowy index.";
}
?>
