<?php
session_start();
if (!isset($_SESSION['51person'])) {
    header('Location: zad1_1.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Zad 1 - Rezerwacja cz.3 – Podsumowanie</title>
</head>
<body>
  <h1>Podsumowanie rezerwacji</h1>
  <p><strong>Numer karty:</strong> <?= htmlspecialchars($_SESSION['51card']) ?></p>
  <p><strong>Zamawiający:</strong> <?= htmlspecialchars($_SESSION['51party']) ?></p>
  <p><strong>Ilość osób:</strong> <?= $_SESSION['51people'] ?></p>

  <h2>Szczegóły osób</h2>
  <ul>
    <?php foreach ($_SESSION['51person'] as $i => $data): ?>
      <li>Osoba <?= $i ?>: <?= htmlspecialchars($data['firstname']) ?> <?= htmlspecialchars($data['secondname']) ?>, <?= htmlspecialchars($data['age']) ?> lat</li>
    <?php endforeach; ?>
  </ul>

  <?php
    session_destroy();
  ?>
</body>
</html>
