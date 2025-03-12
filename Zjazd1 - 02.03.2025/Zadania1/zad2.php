<?php

$n1 = readline("Enter MIN number: ");
$n2 = readline("Enter MAX number: ");
$arr = array();

for ($i = $n1; $i <= $n2; $i++) {
    $c = 0;
    for ($j = 2; $j < $i; $j++) {
        if ($i % $j == 0) {
            $c++;
        }
    }
    if ($c == 0) {
        array_push($arr, $i);
    }
}

foreach ($arr as $value) {
    echo $value . "\n" ;
}
