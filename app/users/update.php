<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


/******** IMAGE *********/
if (isset($_FILES['image'])) {
    $unprocessedfile = $_FILES['image'];
    $file = $unprocessedfile['name'];
    $new_file_name = date('ymd') . '-' . $file;
    $uploads_dir = '/images/';
    $destination = __DIR__ . $uploads_dir . $new_file_name;
    $id = $_SESSION['user']['id'];

    if ($unprocessedfile['type'] !== 'image/png') {
        $_SESSION['error_message'] = 'The chosen file type is not allowed';
        redirect('/profile.php');
    } else {
        $statement = $database->prepare('UPDATE users SET image = :image WHERE id = :id');
        $statement->bindParam(':image', $new_file_name, PDO::PARAM_STR);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        $statement = $database->prepare('SELECT * FROM users WHERE id = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_STR);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        move_uploaded_file($unprocessedfile['tmp_name'], $destination);
        $_SESSION['message'] = "Woohoo! Your image has been updated.";
        $_SESSION['image'] = $new_file_name;

        if ($_SESSION['authenticated']) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'biography' => $user['biography'],
                'image' => $user['image'],
            ];
        }
        redirect('/profile.php');
    }
}


/******* BIOGRAPHY ********/
if (isset($_POST['biography'])) {
    $biography = filter_var($_POST['biography'], FILTER_SANITIZE_STRING);
    $id = $_SESSION['user']['id'];

    $statement = $database->prepare('UPDATE users SET biography = :biography WHERE id = :id');
    $statement->bindParam(':biography', $biography, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);

    $statement->execute();

    $statement = $database->prepare('SELECT * FROM users WHERE id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);


    if ($_SESSION['authenticated']) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'biography' => $user['biography'],
            'image' => $user['image'],
        ];
        $_SESSION['message'] = 'Your biography has been saved!';
    } else {
        $_SESSION['error_message'] = 'Hoppsan, something went wrong. Try again.';
    };


    redirect('/profile.php');
}


/******** EMAIL *********/
if (isset($_POST['email'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $id = $_SESSION['user']['id'];

    $statement = $database->prepare('UPDATE users SET email = :email WHERE id = :id');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);

    $statement->execute();

    $statement = $database->prepare('SELECT * FROM users WHERE id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);


    if ($_SESSION['authenticated']) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'biography' => $user['biography'],
            'image' => $user['image'],
        ];
        $_SESSION['message'] = 'Your email has been updated!';
    } else {
        $_SESSION['error_message'] = 'Something went wrong. Try again.';
    };

    redirect('/profile.php');
}


/********* PASSWORD *********/
if (isset($_POST['new_password'])) {
    $id = $_SESSION['user']['id'];

    $new_password = $confirm_password = "";


    if (strlen(trim($_POST["new_password"])) < 4) {
        $_SESSION['error_message'] = "Password must have atleast 4 characters.";
        redirect('/profile.php');
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    $confirm_password = trim($_POST["confirm_password"]);

    if (empty($_SESSION['error_message']) && ($new_password != $confirm_password)) {
        $_SESSION['error_message'] = "Password is incorrect.";
        redirect('/profile.php');
    }

    if (empty($_SESSION['error_message'])) {
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $statement = $database->prepare('UPDATE users SET password = :password WHERE id = :id');
        $statement->bindParam(':password', $new_password, PDO::PARAM_STR);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        $_SESSION['message'] = 'Your password has been updated!';

        redirect('/profile.php');
    }
}
