<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $number = isset($_POST['number']) ? $_POST['number'] : '';

    if (!ctype_digit($number) || (int)$number < 1) {
        echo "Podana wartość musi być dodatnią liczbą całkowitą.";
        exit;
    }
    $number = (int)$number;

    function isPrime($n, &$iterations) {
        $iterations = 0;

        if ($n <= 1) {
            return false;
        }
        if ($n <= 3) {
            return true;
        }
        if ($n % 2 == 0 || $n % 3 == 0) {
            return false;
        }

        $i = 5;
        while ($i * $i <= $n) {
            $iterations++; 
            if ($n % $i == 0 || $n % ($i + 2) == 0) {
                return false;
            }
            $i += 6;
        }
        return true;
    }

    $iterations = 0;
    $prime = isPrime($number, $iterations);
    ?>
    <!DOCTYPE html>
    <html lang="pl">
    <head>
      <meta charset="UTF-8">
      <title>Wynik sprawdzenia</title>
      <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
      </style>
    </head>
    <body>
      <h2>Wynik sprawdzenia liczby <?php echo $number; ?></h2>
      <p>
        <?php 
          echo $prime ? "Liczba jest pierwsza." : "Liczba nie jest pierwsza.";
        ?>
      </p>
    </body>
    </html>
    <?php
} else {
    echo "Błąd: Formularz nie został wysłany metodą POST.";
}
?>
