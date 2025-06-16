<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $postId = (int)($_POST['post_id'] ?? 0);
  $authorName = trim($_POST['author_name'] ?? '');
  $content = trim($_POST['content'] ?? '');

  if ($postId && $authorName && $content) {
    $stmt = $pdo->prepare("INSERT INTO comments (post_id, author_name, content) 
                               VALUES (:post_id, :author_name, :content)");
    $stmt->execute([
      'post_id' => $postId,
      'author_name' => $authorName,
      'content' => $content
    ]);
  }
  header("Location: post.php?id=$postId");
  exit;
} else {
  die("Nieprawidłowe żądanie.");
}
