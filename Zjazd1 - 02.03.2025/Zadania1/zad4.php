<?php

$text = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
$arr = explode(" ", $text);
$arr2 = array();
$znaki = array('.', ',', '!', '?', ':', ';', '-', '(', ')', '[', ']', '{', '}');

foreach ($arr as $value) {
    $v = 0;
    for ($i = 0; $i < strlen($value); $i++) {
        foreach ($znaki as $znak) {
            if ($value[$i] == $znak) {
                $v++;
            }
        }
    }
    if ($v == 0) {
        array_push($arr2, $value);
    }
}

$assoc = array();
for ($i = 0; $i < count($arr2); $i += 2) {
    if (isset($arr2[$i + 1])) {
        $assoc[$arr2[$i]] = $arr2[$i + 1];
    }
}

foreach ($assoc as $key => $value) {
    echo "$key => $value\n";
}