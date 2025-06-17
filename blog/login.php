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
  <link rel="stylesheet" href="./styles/output.css">
</head>

<body>
  
  <div class="relative grid w-full h-dvh">

    <div class="grid place-self-center px-8 py-6 bg-white rounded-lg gap-y-4 drop-shadow-2xl">
      <h1 class="text-3xl font-semibold text-center">Logowanie</h1>

      <?php if ($error): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <form method="post" class="grid gap-y-3">

        <label>
          <p class="mb-1">Login:</p>
          <p><input type="text" name="username" required 
              class="w-64 border-slate-900/20 border-b-1 min-h-7 outline-0"></p>
        </label>

        <label>
          <p class="mb-1">Hasło:</p>
          <p><input type="password" name="password" required
              class="w-64 border-slate-900/20 border-b-1 min-h-7 outline-0"></p>
        </label>

        <p class="mt-4">
          <button type="submit" 
            class="w-full bg-blue-300 px-6 py-2 rounded-sm font-medium drop-shadow-slate-300 cursor-pointer hover:bg-blue-500/60">
            Zaloguj się
          </button>
        </p>
      </form>

      <p class="mt-2 text-center text-slate-600 text-sm">
        Nie masz konta?
        <a href="register.php" class="underline text-blue-600">Zarejestruj się</a>
      </p>

    </div>

  </div>

</body>

</html>