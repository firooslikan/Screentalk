<?php
session_start();
include("config.php");

if (!isset($_SESSION['username'])) {
    header('Location: index.php?status=not_logged_in');
    exit;
}

if (isset($_GET['id_movie'])) {
    $id_movie = pg_escape_string($connection, $_GET['id_movie']);
    $username = $_SESSION['username'];

    
    $check_sql = "SELECT id_favorite FROM Favorite WHERE id_movie = '$id_movie' AND Username = '$username'";
    $check_result = pg_query($connection, $check_sql);

    if (pg_num_rows($check_result) > 0) {
        
        header('Location: review_list.php?status=already_in_favorites');
        exit;
    }

    
    $favorite_id = uniqid();

    
    $add_sql = "INSERT INTO Favorite (id_favorite, Username, id_movie) VALUES ('$favorite_id', '$username', '$id_movie')";
    $add_result = pg_query($connection, $add_sql);

    if ($add_result) {
        header('Location: favorite.php?status=added_to_favorites');
    } else {
        header('Location: favorite.php?status=add_to_favorites_failed');
    }
} else {
    header('Location: review_list.php?status=invalid_movie_id');
}
?>
