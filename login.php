<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<article>

    <h1>Login</h1>

    <form action="login.php" method="post">
    <div class="formsection">
    <label for="email">YOUR EMAIL</label>
    <input type="email" name="email" id="email" placeholder="your email.." required>
    </div>

    <div class="formsection">
    <label for ="password">YOUR PASSWORD</label>
    <input type="password" name="password" id="password" placeholder="your password.." required>

    </div>

    <button type="submit" class="btn" id="log-in-btn">Login</button>

    <p class="smalltext">If you don't already have an account, sign up below</p>
    </form>



    <h1>Create new account</h1>
<form action="/register.php" method="post">
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