<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  die("Brak dostępu.");
}

$postId = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("DELETE FROM comments WHERE post_id = :id");
$stmt->execute(['id' => $postId]);

$stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
$stmt->execute(['id' => $postId]);

header("Location: admin_panel.php");
exit;
