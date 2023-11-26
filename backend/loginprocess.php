<?php
session_start();

include("config.php");

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = pg_escape_string($connection, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = pg_query($connection, $sql);

    if (pg_num_rows($result) == 1) {
        $row = pg_fetch_assoc($result);
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['username'] = $username;
            $_SESSION['display_name'] = $row['display_name'];
            header('Location: welcome.php');
            exit;
        } else {
            header('Location: index.php?status=incorrect_password');
            exit;
        }
    } else {
        header('Location: index.php?status=user_not_found');
        exit;
    }
} else {
    die("Akses dilarang...");
}
?>
