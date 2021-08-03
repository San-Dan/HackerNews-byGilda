<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['error_message']);
?>

<article>
    <!-- ALERT -->
    <div>
        <?php if ($message !== '') : ?>
            <div class="alert alert success">
                <?= $message; ?>
            </div>
        <?php endif; ?>
    </div>


    <h1>Login</h1>

    <form action="app/users/login.php" method="post">
        <div class="formsection">
            <label for="email">YOUR EMAIL</label>
            <input type="email" name="email" id="email" placeholder="your email.." required>
        </div>

        <div class="formsection">
            <label for="password">YOUR PASSWORD</label>
            <input type="password" name="password" id="password" placeholder="your password.." required>

        </div>

        <button type="submit" class="btn" id="log-in-btn">Login</button>

        <p class="smalltext">If you don't already have an account, sign up below</p>
    </form>



    <h1>Create new account</h1>
    <form action="app/users/register.php" method="post">
        <div class="formsection">
            <label for="name">NAME</label>
            <input type="name" name="name" id="name" placeholder="your name.." required>
        </div>
        <div class="formsection">
            <label for="email">EMAIL</label>
            <input type="email" name="email" id="email" placeholder="your email.." required>
        </div>
        <div class="formsection">
            <label for="password">PASSWORD</label>
            <input type="password" name="password" id="password" placeholder="your password.." required>
        </div>

        <button type="submit" class="btn" id="log-in-btn">CREATE ACCOUNT</button>

    </form>

</article>

<?php require __DIR__ . '/views/footer.php'; ?>