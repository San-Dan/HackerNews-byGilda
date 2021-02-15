<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php
if (!isset($_SESSION["user"]) || $_SESSION["authenticated"] !== true) {
    redirect("/login.php");
    exit;
}

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['error_message']);

$fileName = 'app/users/images' . $_SESSION['user']['id'] . '.png';
?>



<article class="user-profile">
    <!-- ALERT -->
    <div>
        <?php if ($message !== '') : ?>
            <div class="alert alert success">
                <?= $message; ?>
            </div>
        <?php endif; ?>
        <?php if ($error_message !== '') : ?>
            <div class="alert alert-danger">
                <?= $error_message; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="user-info">
        <?php if (is_file($fileName) && file_exists($fileName)) : ?>
            <img src="<?= $fileName ?>" class="profile-img" alt="profile image of <?= $_SESSION['user']['id'] ?>" />
        <?php else : ?>
            <img src="/app/users/images/picture.png" class="profile-img" />
        <?php endif; ?>

        <div class="user-info-text">
            <h1>Username: 
                <?= $_SESSION['user']['name']; ?>
            </h1>
            <p>Biography: 
                <?= $_SESSION['user']['biography']; ?>
            </p>
        </div>
    </div>

<hr>

<!------- UPDATE PROFILE ------->

    <section class="update-profile">
        <form action="app/users/update.php" method="post" enctype="multipart/form-data">
            <div class="formsection">
                <label for="image">Upload profile picture</label>
                <input class="form-control" type="file" name="image" id="image" accepts=".png" />
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <form action="app/users/update.php" method="post">
            <div class="formsection">
                <label for="biography">Update your bio</label>
                <textarea class="form-control" rows="5" cols="5" type="text" name="biography" id="biography" placeholder="write anything about yourself"><?= $_SESSION['user']['biography']; ?></textarea>
                
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <form action="app/users/update.php" method="post">
            <div class="formsection">
                <label for="email">Change email address</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="<?= $_SESSION['user']['email']; ?>" />
               
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <form action="app/users/update.php" method="post">
            <div class="formsection">
                <label for="password">Update password</label>
                <input class="form-control" type="password" name="new_password" id="new_password" placeholder="your new password"/>
                
            </div>
            <div class="form-group">
                <label for="password">Confirm new password</label>
                <input class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="your new password again" />
                
            </div>

            <button type="submit" class="btn btn-primary">Save</button>

        </form>
    </section>

    <div class="user-links">
        <a href="/submitted.php?id=<?= $_SESSION['user']['id']; ?>">
            Your Submissions
        </a> |
        <a href="/delete-account.php?id=<?= $_SESSION['user']['id']; ?>">
            Delete account
        </a>
    </div>

</article>

<?php require __DIR__ . '/views/footer.php'; ?>
