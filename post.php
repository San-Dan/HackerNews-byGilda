<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

$post_id = $_GET['id'];

// GET POST
$statement = $database->prepare('SELECT posts.*, users.name
FROM posts
INNER JOIN users
ON posts.user_id = users.id
WHERE posts.id = :post_id LIMIT 1');

$statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
$statement->execute();
$post = $statement->fetch();

// GET COMMENTS
$statement = $database->prepare('SELECT comments.*, users.name
FROM comments
INNER JOIN users
ON comments.user_id = users.id
WHERE comments.post_id = :post_id
ORDER BY comments.id ASC');

$statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
$statement->execute();
$comments = $statement->fetchAll(PDO::FETCH_ASSOC);

// GET SESSION USER'S POST UPVOTE
if (isset($_SESSION['user'])) {
    $post_id = $post['id'];
    $user_id = $_SESSION['user']['id'];

    $statement = $database->prepare('SELECT * FROM upvotes WHERE post_id = :post_id AND user_id = :user_id');
    $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();
    $upvote = $statement->fetch();
}

// GET COMMENTS UPVOTES (påbörjad copy från dne ovan men blir nog ej rätt)
// if (isset($_SESSION['user'])) {
//     $comment_id = $comment['id'];
//     $user_id = $_SESSION['user']['id'];

//     $statement = $database->prepare('SELECT * FROM upvotes WHERE post_id = :post_id AND user_id = :user_id');
//     $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
//     $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
//     $statement->execute();
//     $upvote = $statement->fetch();
// }

// GET SESSION USER'S COMMENT UPVOTE 

$time = $post['published'];

?>

<!---- POST ---->
<article class="single-post">

    <div class="post-info">
    <p><?php if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                } ?></p>
        <div>
            <?php if (isset($_SESSION['user'])) : ?>
                <button data-url="<?= $post['id']; ?>" class="upvote-btn
                    <?php if (isset($_SESSION['user'])) : ?>
                        <?php if ($upvote !== false) : ?>
                            upvote-btn-darker
                        <?php endif; ?>
                    <?php endif; ?>">
                    <i class="fa fa-heart" aria-hidden="true"></i>
                </button>
            <?php endif; ?>
            <a target="_blank" href="<?= trim($post['url']); ?>">
                <h3>
                    <?= trim($post['title']); ?>
                </h3>
            </a>
        </div>
        <p>
            <?= $post['description']; ?>
        </p>

    </div>

    <!---- UPVOTES AND COMMENTS  ---->
    <div class="subtext">
        <?php $upvotes = countUpvotes($database, $post['id']); ?>
        <?php $numberOfComments = countComments($database, $post['id']); ?>

        <div>
            <?php if ($upvotes == 1) : ?>
                <span class="number-of-votes" data-url="<?= $post['id']; ?>">
                    <?= $upvotes; ?> vote
                </span>
            <?php else : ?>
                <span class="number-of-votes" data-url="<?= $post['id']; ?>">
                    <?= $upvotes; ?> votes
                </span>
            <?php endif; ?>
            <?php if ($numberOfComments == 1) : ?>
                <span>
                    <?= $numberOfComments; ?> comment
                </span>
            <?php else : ?>
                <span>
                    <?= $numberOfComments; ?> comments
                </span>
            <?php endif; ?>


        </div>
        <p>
            <?= $post['name']; ?>
        </p>
        <p>
            <?= convertTime(strtotime($time)); ?>
            ago
        </p>

    </div>


    <!-------- FORM TO POST COMMENT -------->
    <form action="app/comments/store.php?id=<?= $post['id']; ?>" method="post">
        <div class="form-group">
            <label for="comment">Comment</label>
            <textarea class="form-control" rows="5" cols="5" type="text" name="comment" id="comment"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</article>


<!----------- ALL COMMENTS ---------->
<article class="comments">
    <p>All Comments:</p>
    <?php foreach ($comments as $comment) : ?>
        <?php if (isset($_SESSION['user'])) {
            $statement = $database->prepare('SELECT * FROM comments WHERE id = :id AND user_id = :user_id');
            $statement->bindParam(':id', $comment['id'], PDO::PARAM_INT);
            $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $statement->execute();
            $commentUpvote = $statement->fetch();

            // get all upvotes of comments (from new table?) like statement above
        }
        ?>

        <div class="comment" data-id="<?= $comment['post_id']; ?>" data-commentid="<?= $comment['id']; ?>">
            <div class="post-info">
                <div>
                    <p class="comment-user">Sent by:
                        <?= $comment['name'] . ' ' . convertTime(strtotime($comment['published'])); ?>
                        ago
                    </p>
                </div>
            </div>



            <!---- EDIT/UPVOTE COMMENT ---->
            <?php if (isset($_SESSION['user'])) : ?>
                <form action="/app/comments/upvote.php" method="post">
                    <input type="hidden" name="comment-id" value="<?= $comment['id']; ?>">
                    <input type="hidden" name="post-id" value="<?= $post['id']; ?>">
                    <button class="comment-upvote-btn">UPVOTE</button>
                </form>

                <!-- Edit Pen + Trash Icons -->
                <?php if ($comment['user_id'] === $_SESSION['user']['id']) : ?>
                    <div class="edit-comment-container">
                        <button data-id="<?= $comment['post_id']; ?>" data-commentid="<?= $comment['id']; ?>" class="edit-comment">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </button>
                        <a href="/app/comments/delete-comment.php?comment-id=<?= $comment['id']; ?>&id=<?= $comment['post_id']; ?>" class="delete-comment">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <p class="comment-content" data-id="<?= $comment['post_id']; ?>" data-commentid="<?= $comment['id']; ?>">
                <?= $comment['content']; ?>
            </p>

            <!----- EDIT COMMENT FORM  ----->
            <form action="/app/comments/update-comment.php?id=<?= $comment['post_id']; ?>&comment-id=<?= $comment['id']; ?>" class="comment-form-hidden" data-id="<?= $comment['post_id']; ?>" data-commentid="<?= $comment['id']; ?>" method="post">
                <div class="form-group">
                    <label for="edit">Edit Comment</label>
                    <textarea class="form-control" rows="5" cols="5" type="text" name="edit" id="edit"><?= $comment['content']; ?></textarea>
                </div>
                <button type="submit" class="edit-comment-save">Save</button>
                <a href="/post.php?id=<?= $post_id ?>" class="edit-comment-cancel">Cancel</a>
            </form>


        <?php endforeach; ?>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>