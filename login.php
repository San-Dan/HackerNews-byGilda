<?php
require __DIR__ . '/header.php'; ?>

<article>

    <h1>Login</h1>

    <form action="login.php" method="post">
    <div class="formsection">
    <label for="email">YOUR EMAIL</label>
    <input type="email" name="email" id="email" required>
    </div>

    <div class="formsection">
    <label for ="password">YOUR PASSWORD</label>
    <input type="password" name="password" id="password" required>
    </div>

    <button type="submit" class="btn" id="log-in-btn">Login</button>

    <p class="create-account">Or sign up <a href="/register.php">here</a></p>
    </form>
    
</article>

<?php require __DIR__ . '/footer.php'; ?>