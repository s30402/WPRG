<?php
require_once 'db.php';

function insertPost(string $title, string $content, ?string $imageFilename, int $authorId): bool
{
  global $pdo;

  $sql = "INSERT INTO posts (title, content, image, author_id) VALUES (:title, :content, :image, :author_id)";
  $stmt = $pdo->prepare($sql);

  return $stmt->execute([
    'title' => $title,
    'content' => $content,
    'image' => $imageFilename,
    'author_id' => $authorId
  ]);
}
