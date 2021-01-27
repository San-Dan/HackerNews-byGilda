<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we register a new user.

if (isset($_POST['email'], $_POST['password'], $_POST['name'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);

    if (strlen(trim($_POST["password"])) < 6) {
        $_SESSION['error_message'] = "Password must have atleast 5 characters.";
        redirect('/register.php');
    } else {
        $password = trim($_POST["password"]);
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    $statement = $database->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);
    $statement->bindParam(':name', $name, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['message'] = 'Yippie! Your account has been created, please log in below.';
    redirect('/login.php');
}



redirect('/');
