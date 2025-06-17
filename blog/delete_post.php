<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'author'])) {
    die("Brak dostępu. Tylko administrator lub autor.");
}

$postId = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
$stmt->execute(['id' => $postId]);
$post = $stmt->fetch();

if (!$post) {
    die("Post nie istnieje.");
}

if ($_SESSION['role'] !== 'admin' && $_SESSION['user_id'] != $post['author_id']) {
    die("Brak dostępu. Możesz usuwać tylko swoje posty.");
}

$stmt = $pdo->prepare("DELETE FROM comments WHERE post_id = :id");
$stmt->execute(['id' => $postId]);

$stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
$stmt->execute(['id' => $postId]);

header("Location: admin_panel.php");
exit;
