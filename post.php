<?php require __DIR__ . '/header.php'; ?>

<?php


$post_id = $_GET['id'];

$statement = $database->prepare('SELECT posts.*, users.email
FROM posts
INNER JOIN users
ON posts.user_id = users.id
WHERE posts.id = :post_id LIMIT 1');


$statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
$statement->execute();
$post = $statement->fetch();

