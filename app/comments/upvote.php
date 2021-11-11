<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$_SESSION['error_message'] = '';

if (isset($_SESSION['user']['id'])) {
    if (isset($_POST['comment-id'])) {
        $comment_id = $_POST['comment']['id']; // hur få in värde från data-url?
        die(var_dump($comment_id));
        $user_id = $_SESSION['user']['id'];

        // looks if there is an upvote
        $statement = $database->prepare(('SELECT * FROM com_upvotes WHERE comment_id = :comment_id AND user_id = :user_id'));
        $statement->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();

        $upvote = $statement->fetch();

        // if upvote is not, then add one to db table
        if ($upvote === false) {
            $statement = $database->prepare('INSERT INTO com_upvotes (comment_id, user_id) VALUES(:post_id, :user_id)');
            $statement->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
            $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $statement->execute();
        } else { // if upvote is, then remove it
            $statement = $database->prepare(('DELETE FROM com_upvotes WHERE comment_id = :comment_id AND user_id = :user_id'));
            $statement->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
            $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $statement->execute();
        }

        // sends the number of upvote-s
        // $upvotes = countUpvotes($database, $post_id);
        // echo json_encode($upvotes);
    }
}
