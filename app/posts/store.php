<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we store/insert new posts in the database.

$_SESSION['message'] = '';


if (isset($_SESSION['user'])) {
    if (isset($_POST['title'], $_POST['url'], $_POST['description'])) {
        $title = trim(filter_var($_POST['title'], FILTER_SANITIZE_STRING));
        $url = trim(filter_var($_POST['url'], FILTER_SANITIZE_URL));
        $description = trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING));
        $published = date("Y-m-d H:i:s");
        $id = $_SESSION['user']['id'];


        $statement = $database->prepare('INSERT INTO posts (title, url, description, published, user_id) VALUES (:title, :url, :description, :published, :user_id)');
        $statement->bindParam(':title', $title, PDO::PARAM_STR);
        $statement->bindParam(':url', $url, PDO::PARAM_STR);
        $statement->bindParam(':description', $description, PDO::PARAM_STR);
        $statement->bindParam(':published', $published, PDO::PARAM_STR);
        $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
        $statement->execute();

        $_SESSION['message'] = 'Your post has been submitted!';

        $statement = $database->query('SELECT * FROM posts ORDER BY id DESC LIMIT 1');
        $post = $statement->fetch();
    }
    redirect('/post.php?id=' . $post['id']);
} else {
    $_SESSION['message'] = 'You have to be logged in to post.';
    redirect('/login.php');
}
