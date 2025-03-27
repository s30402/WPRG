<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $num1 = isset($_POST['num1']) ? (float) $_POST['num1'] : 0;
    $num2 = isset($_POST['num2']) ? (float) $_POST['num2'] : 0;
    $operation = isset($_POST['operation']) ? $_POST['operation'] : '';

    $result = 0;

    switch ($operation) {
        case 'dodawanie':
            $result = $num1 + $num2;
            break;
        case 'odejmowanie':
            $result = $num1 - $num2;
            break;
        case 'mnozenie':
            $result = $num1 * $num2;
            break;
        case 'dzielenie':
            if ($num2 == 0) {
                echo "Błąd: Nie można dzielić przez zero.";
                exit;
            }
            $result = $num1 / $num2;
            break;
        default:
            echo "Nieprawidłowa operacja.";
            exit;
    }

    echo "<h2>Wynik: " . $result . "</h2>";
} else {
    echo "Błąd: Formularz nie został wysłany metodą POST.";
}
?>
