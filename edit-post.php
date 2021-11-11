<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php
if (!isset($_SESSION["user"]) || $_SESSION["authenticated"] !== true) {
    redirect("/login.php");
}

$post_id = $_GET['id'];
$statement = $database->prepare('SELECT * FROM posts WHERE id = :post_id LIMIT 1');
$statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
$statement->execute();

$post = $statement->fetch();
?>

<article>
    <h1>Edit Your Post</h1>
    <form action="app/posts/update.php?id=<?= $post['id']; ?>" method="post">
    <div class="form-group">
        <label for="title">Title</label>
        <input class="form-control" type="title" name="title" id ="title" value="<?= $post['title']; ?>">
    </div>

    <div class="form-group">
        <label for="url">URL</label>
        <input class="form-control" type="url" name="url" id ="url" value="<?= $post['url']; ?>">
    </div>

    <div class="form-group">
        <label for="description">Comment</label> 
        <textarea class="form-control" rows="10" cols="5" type="text" name="description" id ="description" value="<?= $post['description']; ?>"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>