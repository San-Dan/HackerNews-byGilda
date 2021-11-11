<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php
if (!isset($_SESSION["user"]) || $_SESSION["authenticated"] !== true) {
    $_SESSION['error_message'] = 'You have to be logged in to submit posts.';
    redirect("/login.php");
}

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

?>


<main>

    <!-- ALERT -->
    <div>
        <?php if ($message !== '') : ?>
            <div class="alert alert success">
                <?= $message; ?>
            </div>
        <?php endif; ?>
    </div>

    <section class="create-post">
        <hi>CREATE A NEW POST</hi>

        <?php if (isset($_SESSION['user'])) : ?>
            <form action="app/posts/store.php" method="post">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control save" type="title" name="title" id="title" placeholder="Enter title" required>
                </div>

                <div class="form-group">
                    <label for="url">URL</label>
                    <input class="form-control" type="url" name="url" id="url" placeholder="Enter URL" required>
                </div>

                <div class="form-group">
                    <label for="description">Comment <small class="text-muted"><i> - - Optional</i></small></label>
                    <textarea class="form-control" rows="10" cols="5" type="text" name="description" id="description" placeholder="Enter description"></textarea>
                </div>

                <button type="submit" class="btn">SUBMIT</button>
            </form>
        <?php endif; ?>
    </section>


</main>





<?php require __DIR__ . '/views/footer.php'; ?>