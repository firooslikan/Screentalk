<?php
session_start();
include("config.php");

if (!isset($_SESSION['username'])) {
    header('Location: index.php?status=not_logged_in');
    exit;
}

$movie_id = uniqid(); 
$review_id = uniqid();

$movie_name = $_POST['judul_film'];
$release_year = $_POST['tahun_rilis'];
$genre = $_POST['genre_film'];
$director = $_POST['sutradara'];
$duration = !empty($_POST['durasi_film']) ? $_POST['durasi_film'] : 0;

$date_watched = $_POST['tanggal_nonton'];
$rating = $_POST['rating'];
$review = $_POST['isi_review'];

$date_reviewed = date("Y-m-d");

$username = $_SESSION['username'];

$targetDir = "posters/";
$targetFile = $targetDir . basename($_FILES["poster_film"]["name"]);

if (move_uploaded_file($_FILES["poster_film"]["tmp_name"], $targetFile)) {
    $poster_path = $targetFile;
} else {
    $poster_path = 'posters/noimage.png';
}

$movie_query = pg_query("INSERT INTO movie (id_movie, judul_film, tahun_rilis, genre_film, sutradara, durasi_film, poster_film) VALUES ('$movie_id', '$movie_name', '$release_year', '$genre', '$director', '$duration', '$poster_path')");

if (!$movie_query) {
    die("Movie query failed: " . pg_last_error());
}

$review_query = pg_query("INSERT INTO moviereview (id_review, id_movie, username, tanggal_nonton, tanggal_review, rating, isi_review) VALUES ('$review_id', '$movie_id', '$username', '$date_watched', '$date_reviewed', '$rating', '$review')");

if (!$review_query) {
    die("Review query failed: " . pg_last_error());
}

if ($movie_query && $review_query) {
    header('Location: welcome.php?status=success');
} else {
    header('Location: welcome.php?status=failed');
}
?>
