<?php
require_once 'db.php';
session_start();

if (isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($username && $password) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['role'] = $user['role'];
      header("Location: index.php");
      exit;
    } else {
      $error = "Nieprawidłowa nazwa użytkownika lub hasło.";
    }
  } else {
    $error = "Uzupełnij wszystkie pola.";
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Logowanie</title>
</head>

<body>
  <h1>Logowanie</h1>

  <?php if ($error): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="post">
    <label>Login:<br><input type="text" name="username" required></label><br><br>
    <label>Hasło:<br><input type="password" name="password" required></label><br><br>
    <button type="submit">Zaloguj się</button>
  </form>
</body>

</html>