<?php
session_start();

if (!isSet($_SESSION['51people'])) {
    header('Location: zad1_1.php');
    exit;
}

$ilosc = $_SESSION['51people'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    for ($i = 1; $i <= $ilosc; $i++) {
        $_SESSION['51person'][$i] = [
            'firstname' => $_POST["firstname_$i"] ?? '',
            'secondname'=> $_POST["secondname_$i"] ?? '',
            'age' => $_POST["age_$i"] ?? '',
        ];
    }

    if (isSet($_POST['save'])) {
        header('Location: zad1_3.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Zad 1 - Rezerwacja cz.2</title>
</head>
<body>
  <h1>Dane osób</h1>
  <form method="post">
    <?php for ($i = 1; $i <= $ilosc; $i++): ?>
      <fieldset>
        <legend>Osoba <?= $i ?></legend>
        Imię:       <input name="firstname_<?= $i ?>" required><br>
        Nazwisko:   <input name="secondname_<?= $i ?>" required><br>
        Wiek:       <input name="age_<?= $i ?>" type="number" min="0" required><br>
      </fieldset>
    <?php endfor; ?>
    <button name="save" type="submit">Podsumowanie</button>
  </form>
</body>
</html>
