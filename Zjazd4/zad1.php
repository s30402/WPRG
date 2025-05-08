<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['file']['tmp_name'];
        $lines = file($tmpName, FILE_IGNORE_NEW_LINES);
        if ($lines === false) {
            echo "Błąd odczytu pliku.";
            exit;
        }
        $reversed = array_reverse($lines);
        header('Content-Type: text/plain; charset=UTF-8');
        header('Content-Disposition: attachment; filename="reversed_' . basename($_FILES['file']['name']) . '"');
        foreach ($reversed as $line) {
            echo $line . "\n";
        }
        exit;
    } else {
        echo "Błąd: Nie przesłano pliku lub wystąpił inny błąd.";
    }

} else {
    echo "Błąd: Formularz nie został wysłany metodą POST.";
}
?>