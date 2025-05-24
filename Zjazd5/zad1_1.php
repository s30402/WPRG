<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['51card'] = $_POST['card'];
    $_SESSION['51party'] = $_POST['party'];
    $_SESSION['51people'] = (int)$_POST['people'];

    header('Location: zad1_2.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Zad 1 - Rezerwacja</title>
</head>
<body>
  <h1>Dane ogólne</h1>
  <form method="post">
    Numer karty: <input name="card" required><br>
    Zamawiający: <input name="party" required><br>
    Ilość osób: <input name="people" type="number" min="1" required><br>
    <button type="submit">Dalej</button>
  </form>
</body>
</html>
