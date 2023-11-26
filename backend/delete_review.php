<?php
session_start();
include("config.php");

if (!isset($_SESSION['username'])) {
    header('Location: index.php?status=not_logged_in');
    exit;
}

if (isset($_GET['id_review'])) {
    $id_review = pg_escape_string($connection, $_GET['id_review']);
    $username = $_SESSION['username'];

    $check_review_query = pg_query($connection, "SELECT id_review FROM moviereview WHERE id_review = '$id_review' AND username = '$username'");

    if (pg_num_rows($check_review_query) > 0) {
        $delete_review_query = pg_query($connection, "DELETE FROM moviereview WHERE id_review = '$id_review'");
        $delete_movie_query = pg_query($connection, "DELETE FROM movie WHERE id_movie = (SELECT id_movie FROM moviereview WHERE id_review = '$id_review' AND username = '$username')");

        if ($delete_review_query && $delete_movie_query) {
            header('Location: review_list.php?status=delete_success');
        } else {
            header('Location: review_list.php?status=delete_failed');
        }
    } else {
        header('Location: review_list.php?status=invalid_review_id');
    }
} else {
    header('Location: review_list.php?status=invalid_review_id');
}
?>
