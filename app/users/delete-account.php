<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we delete everything related to a user in the database.

if (isset($_POST['user-id'])) {
    $user_id = (int)filter_var($_POST['user-id'], FILTER_SANITIZE_NUMBER_INT);

    // select all comments by user
    $statement = $database->prepare('SELECT * FROM comments WHERE user_id = :user_id');
    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();
    $usersComments = $statement->fetchAll(PDO::FETCH_ASSOC);

    // delete all upvotes from user's comments
    foreach ($usersComments as $usersComment) {
        $statement = $database->prepare('DELETE FROM com_upvotes WHERE comment_id = :comment_id');
        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }
        $statement->bindParam(':comment_id', $usersComment['id'], PDO::PARAM_INT);
        $statement->execute();
    }

    // delete user's comments
    $statement = $database->prepare('DELETE FROM comments WHERE user_id = :user_id');
    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();

    // select all of user's posts
    $statement = $database->prepare('SELECT * FROM posts WHERE user_id = :user_id');
    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();
    $usersPosts = $statement->fetchAll(PDO::FETCH_ASSOC);

    // delete all comments from posts
    foreach ($usersPosts as $usersPost) {
        $statement = $database->prepare('DELETE FROM comments WHERE post_id = :post_id');
        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }
        $statement->bindParam(':post_id', $usersPost['id'], PDO::PARAM_INT);
        $statement->execute();
    }

    // delete all upvotes from posts
    foreach ($usersPosts as $usersPost) {
        $statement = $database->prepare('DELETE FROM upvotes WHERE post_id = :post_id');
        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }
        $statement->bindParam(':post_id', $usersPost['id'], PDO::PARAM_INT);
        $statement->execute();
    }

    // delete user's upvotes (comments + posts)
    $statement = $database->prepare('DELETE FROM upvotes WHERE user_id = :user_id');
    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();

    $statement = $database->prepare('DELETE FROM com_upvotes WHERE user_id = :user_id');
    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();


    // delete user's posts
    $statement = $database->prepare('DELETE FROM posts WHERE user_id = :user_id');
    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();

    // delete user's info
    $statement = $database->prepare('DELETE FROM users WHERE id = :id');
    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':id', $user_id, PDO::PARAM_INT);
    $statement->execute();

    unset($_SESSION['user']);
}

$_SESSION['message'] = 'You have deleted your account and all related data.';
redirect('/index.php');
