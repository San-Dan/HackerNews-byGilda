<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_SESSION['user'])) {
    if (isset($_POST['comment'])) {
        $content = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
        $post_id = $_GET['id'];
        $published = date("Y-m-d H:i:s");
        $id = $_SESSION['user']['id'];

        $statement = $database->prepare('INSERT INTO comments (content, published, post_id, user_id) VALUES (:content, :published, :post_id, :user_id)');
        $statement->bindParam(':content', $content, PDO::PARAM_STR);
        $statement->bindParam(':published', $published, PDO::PARAM_STR);
        $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
        $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $statement->execute();

        redirect('/post.php?id=' . $post_id);
    }
} else {
    $_SESSION['error_message'] = 'Log in to comment';
    redirect('/login.php');
}
