<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// Check if email and password exists in the POST request.
if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Prepare, bind email parameter and execute the database query.
    $statement = $database->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();

    // Fetch the user as an associative array.
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // If we couldn't find the user in the database, redirect back to the login
    if (!$user) {
        redirect('/login.php');
    }

    // If we found the user in the database, compare the given password from the
    // request with the one in the database using the password_verify function.
    if (
        isset($user['password']) &&
        password_verify($_POST['password'], $user['password'])
        ) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'biography' => $user['biography'],
                'image' => $user['image'],
            ];
            $_SESSION['authenticated'] = true;
            redirect('/');
        } else {
            $_SESSION['error_message'] = "Invalid. Please try again.";
            redirect('/login.php');

        }
    }