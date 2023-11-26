<?php
session_start();
include("config.php");

if (!isset($_SESSION['username'])) {
    header('Location: index.php?status=not_logged_in');
    exit;
}

if (isset($_GET['id_favorite'])) {
    $id_favorite = pg_escape_string($connection, $_GET['id_favorite']);
    $username = $_SESSION['username'];

    $sql = "DELETE FROM favorite WHERE id_favorite = '$id_favorite' AND username = '$username'";
    $result = pg_query($connection, $sql);

    if ($result) {
        header('Location: favorite.php?status=remove_success');
        exit;
    }
}

header('Location: favorite.php?status=remove_failed');
?>
