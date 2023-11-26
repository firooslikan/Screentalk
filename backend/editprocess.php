<?php
session_start();
include("config.php");

if (!isset($_SESSION['username'])) {
    header('Location: index.php?status=not_logged_in');
    exit;
}

if (isset($_POST['id_review'])) {
    $id_review = pg_escape_string($connection, $_POST['id_review']);
    $username = $_SESSION['username'];

    $judul_film = pg_escape_string($connection, $_POST['judul_film']);
    $tahun_rilis = (int)$_POST['tahun_rilis'];
    $genre_film = pg_escape_string($connection, $_POST['genre_film']);
    $sutradara = pg_escape_string($connection, $_POST['sutradara']);
    $durasi_film = (int)$_POST['durasi_film'];
    $tanggal_nonton = $_POST['tanggal_nonton'];
    $rating = (int)$_POST['rating'];
    $isi_review = pg_escape_string($connection, $_POST['isi_review']);

    if (!empty($_FILES["poster_film"]["name"])) {
        $targetDir = "posters/";
        $targetFile = $targetDir . basename($_FILES["poster_film"]["name"]);

        if (move_uploaded_file($_FILES["poster_film"]["tmp_name"], $targetFile)) {
            $poster_path = $targetFile;
        } else {
            $poster_path = 'posters/noimage.png';
        }
    } else {
        $sql_get_existing_poster = "SELECT poster_film FROM movie WHERE id_movie = (SELECT id_movie FROM moviereview WHERE id_review = '$id_review' AND username = '$username')";
        $result_get_existing_poster = pg_query($connection, $sql_get_existing_poster);

        if (!$result_get_existing_poster) {
            die("Error in SQL query: " . pg_last_error());
        }

        $row_get_existing_poster = pg_fetch_assoc($result_get_existing_poster);
        $poster_path = $row_get_existing_poster['poster_film'];
    }

    $sql_update_review = "UPDATE moviereview
                         SET tanggal_nonton = '$tanggal_nonton',
                             rating = $rating,
                             isi_review = '$isi_review'
                         WHERE id_review = '$id_review' AND username = '$username'";

    $sql_update_movie = "UPDATE movie
                        SET judul_film = '$judul_film',
                            tahun_rilis = $tahun_rilis,
                            genre_film = '$genre_film',
                            sutradara = '$sutradara',
                            durasi_film = $durasi_film,
                            poster_film = '$poster_path'
                        WHERE id_movie = (SELECT id_movie FROM moviereview WHERE id_review = '$id_review' AND username = '$username')";

    $result_update_review = pg_query($connection, $sql_update_review);
    $result_update_movie = pg_query($connection, $sql_update_movie);

    if ($result_update_review && $result_update_movie) {
        header('Location: movie_review.php?id_review=' . $id_review . '&status=edit_success');
    } else {
        header('Location: movie_review.php?id_review=' . $id_review . '&status=edit_failed');
    }
} else {
    header('Location: review_list.php?status=invalid_review_id');
}
?>
