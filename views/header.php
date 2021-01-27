<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Hacker News</title>
</head>

<body>

<nav>
    <a class="navbar-brand" href="/"><b>HΛCKER ИEWS</b></a>
        <svg height="512" viewBox="0 -53 384 384" width="512" xmlns="http://www.w3.org/2000/svg" class="menu-btn">
            <path d="M368 154.668H16c-8.832 0-16-7.168-16-16s7.168-16 16-16h352c8.832 0 16 7.168 16 16s-7.168 16-16 16zm0 0M368 32H16C7.168 32 0 24.832 0 16S7.168 0 16 0h352c8.832 0 16 7.168 16 16s-7.168 16-16 16zm0 0M368 277.332H16c-8.832 0-16-7.168-16-16s7.168-16 16-16h352c8.832 0 16 7.168 16 16s-7.168 16-16 16zm0 0" />
        </svg>
</nav> 
<section class="menu-list">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 409.806 409.806" class="close-btn">
            <path d="M228.929 205.01L404.596 29.343c6.78-6.548 6.968-17.352.42-24.132-6.548-6.78-17.352-6.968-24.132-.42-.142.137-.282.277-.42.42L204.796 180.878 29.129 5.21c-6.78-6.548-17.584-6.36-24.132.42-6.388 6.614-6.388 17.099 0 23.713L180.664 205.01 4.997 380.677c-6.663 6.664-6.663 17.468 0 24.132 6.664 6.662 17.468 6.662 24.132 0l175.667-175.667 175.667 175.667c6.78 6.548 17.584 6.36 24.132-.42 6.387-6.614 6.387-17.099 0-23.712L228.929 205.01z" />
        </svg>

        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/index.php' ? 'active' : ''; ?>" href="/index.php">Home</a>
        </li><!-- /nav-item -->

        <li class="nav-item">
            <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/submit.php' ? 'active' : ''; ?>" href="/submit.php">Submit</a>
        </li><!-- /nav-item -->

       
        <li class="nav-item">
            <?php if (isset($_SESSION['user'])) : ?>
                <a class="nav-link" href="/profile.php">My profile</a></li>
                

                <li class="nav-item">
                <a class="nav-link" href="/app/users/logout.php">Logout</a>

            <?php else : ?>
                <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/login.php' ? 'active' : ''; ?>" href="login.php">Login/Create account</a>
            <?php endif; ?>
        </li><!-- /nav-item -->
    </ul><!-- /navbar-nav -->
</nav><!-- /navbar -->

</section>

<section class="post-list">

</section>


<div class="container">