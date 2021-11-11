<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we delete everything related to a user in the database.

if (!isset($_SESSION["user"]) || $_SESSION["authenticated"] !== true) {
    redirect("/login.php");
    exit;
}
else {
    $id = $_GET['id'];
    // $id = $_SESSION['user']['id'];

    $statement = $database->prepare('DELETE FROM posts WHERE user_id = :id');
    $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
    $statement->execute();

    $statement = $database->prepare('DELETE FROM comments WHERE user_id = :id');
    $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
    $statement->execute();

    $statement = $database->prepare('DELETE FROM users WHERE id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $statement = $database->prepare('DELETE FROM votes WHERE user_id = :id');
    $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
    $statement->execute();



    $_SESSION['message'] = 'You have deleted your account and all related data.';
    redirect('/index.php');
}

