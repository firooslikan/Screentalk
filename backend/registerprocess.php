<?php
include("config.php");

if (isset($_POST['username']) && isset($_POST['display_name']) && isset($_POST['email']) && isset($_POST['password'])) {
    $username = pg_escape_string($connection, $_POST['username']);
    $display_name = pg_escape_string($connection, $_POST['display_name']);
    $email = pg_escape_string($connection, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, display_name, email, password_hash) VALUES ('$username', '$display_name', '$email', '$password')";
    
    $result = pg_query($connection, $sql);

    if ($result) {
        $_SESSION['username'] = $username;
        $_SESSION['display_name'] = $display_name;
        header('Location: index.php?status=success');
        exit;
    } else {
        header('Location: register.php?status=failed');
        exit;
    }
} else {
    die("Akses dilarang...");
}
?>