<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$_SESSION['error_message'] = '';

if (isset($_SESSION['user']['id'])) {
    if (isset($_POST)) {
        $post_id = $_GET['id'];
        $user_id = $_SESSION['user']['id'];

        // looks if there's a upvote
        $statement = $database->prepare(('SELECT * FROM upvotes WHERE post_id = :post_id AND user_id = :user_id'));
        $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();

        $upvote = $statement->fetch();

        // if upvote is not, then add to it
        if ($upvote === false) {
            $statement = $database->prepare('INSERT INTO upvotes (post_id, user_id) VALUES(:post_id, :user_id)');
            $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $statement->execute();
        } else { // if upvote is, then remove it
            $statement = $database->prepare(('DELETE FROM upvotes WHERE post_id = :post_id AND user_id = :user_id'));
            $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $statement->execute();
        }

        // sends the number of upvote-s
        $upvotes = countUpvotes($database, $post_id);

        echo json_encode($upvotes);
    }
}
