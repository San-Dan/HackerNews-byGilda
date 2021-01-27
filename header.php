<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Hacker News</title>
</head>

<body>

<nav>
<section class="menu-list">
    <a class="navbar-logo" href="/">HΛCKER ИEWS</a>
</nav> 
<ul class="nav-navbar">
    <li class="nav-item
    <?php if ($_SERVER['PHP_SELF'] === '/index.php') : ?>
        active
    <?php elseif ($_SERVER['PHP_SELF'] === '/upvoted.php') : ?>
        active
    <?php endif; ?>">
        <a class="nav-link" href="/index.php">Home</a>
    </li>
    <li class="nav-item
    <?php if ($_SERVER['PHP_SELF'] === '/submit.php') : ?>
        active
    <?php endif; ?>">
        <a class="nav-link" href="/submit.php">Submit</a>
    </li>

<?php if (isset($_SESSION['user'])) : ?>
    <li class="nav-item">
    <div class="dropdown">
<button class="dropbtn
    <?php if ($_SERVER['PHP_SELF'] === '/user.php') : ?>
    active
    <?php elseif ($_SERVER['PHP_SELF'] === '/submitted.php') : ?>
    active
    <?php endif; ?>">
<?= $_SESSION['user']['name']; ?>
</button>
<div class="dropdown-content-hidden">
    <a class="nav-link" href="/user.php?id=<?= $_SESSION['user']['id'] ?>">
    My profile
    </a>
    <a class="nav-link" href="/submitted.php?id=<?= $_SESSION['user']['id']; ?>">
    Submissions
    </a>
</div>
</div>
</li>

<?php else : ?>
<li class="nav-item
        <?php if ($_SERVER['PHP_SELF'] === '/login.php') : ?>
        active
        <?php endif; ?>">
        <a class="nav-link" href="/login.php">Login/Create account</a>
</li>
<?php endif; ?>

</ul>

</section>

<section class="post-list">

</section>


<div class="container">