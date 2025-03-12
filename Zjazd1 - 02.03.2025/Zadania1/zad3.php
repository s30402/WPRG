<?php

$n = 20;
$arr = [0, 1];

for ($i = 2; $i < $n; $i++) {
    $arr[$i] = $arr[$i-1] + $arr[$i-2];
}

$l = 0;
foreach ($arr as $value) {
    if ($value % 2 != 0) {
        echo ++$l . ". " . $value . "\n";
    }
}