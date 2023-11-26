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

    $sql = "SELECT moviereview.id_review, moviereview.id_movie, movie.judul_film, movie.tahun_rilis, movie.genre_film, movie.sutradara, movie.durasi_film, moviereview.tanggal_nonton, moviereview.rating, moviereview.isi_review, movie.poster_film
            FROM moviereview
            JOIN movie ON moviereview.id_movie = movie.id_movie
            WHERE moviereview.id_review = '$id_review' AND moviereview.username = '$username'";

    $result = pg_query($connection, $sql);

    if (!$result) {
        die("Error in SQL query: " . pg_last_error());
    }

    if (pg_num_rows($result) == 1) {
        $row = pg_fetch_assoc($result);
    } else {
        header('Location: review_list.php?status=review_not_found');
        exit;
    }
} else {
    header('Location: review_list.php?status=invalid_review_id');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Screentalk</title>
    <link rel="stylesheet" type="text/css" href="edit_review.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <script src="script.js"></script>
</head>
<body>
    <div class="container">
        <div class="review-container">
            <form action="editprocess.php" method="post" enctype="multipart/form-data">
            <div class="review-field">
                <input type="hidden" name="id_review" value="<?php echo $row['id_review']; ?>">
                    <div class="poster-rating">
                        <div class="rating">
                            <input type="radio" id="star5" name="rating" value="5" <?php echo $row['rating'] == 5 ? 'checked' : ''; ?>>
                            <label for="star5"></label>
                            <input type="radio" id="star4" name="rating" value="4" <?php echo $row['rating'] == 4 ? 'checked' : ''; ?>>
                            <label for="star4"></label>
                            <input type="radio" id="star3" name="rating" value="3" <?php echo $row['rating'] == 3 ? 'checked' : ''; ?>>
                            <label for="star3"></label>
                            <input type="radio" id="star2" name="rating" value="2" <?php echo $row['rating'] == 2 ? 'checked' : ''; ?>>
                            <label for="star2"></label>
                            <input type="radio" id="star1" name="rating" value="1" <?php echo $row['rating'] == 1 ? 'checked' : ''; ?>>
                            <label for="star1"></label>
                        </div>

                        <div class="poster" style="background-image: url('<?php echo $row['poster_film']; ?>');">
                            <label for="poster_film"></label>
                            <input type="file" id="poster_film" name="poster_film" accept="image/*"><br><br>
                        </div>
                    </div>

                    <div class="review-box">
                        <div class="judul">
                            <input type="text" id="judul_film" name="judul_film" value="<?php echo $row['judul_film']; ?>" required placeholder="Movie/TV Series Name"><br><br>
                        </div>

                        <div class="genre-durasi-tahun">
                            <input type="text" id="genre_film" name="genre_film" value="<?php echo $row['genre_film']; ?>" required placeholder="Genre">
                            <input type="number" id="durasi_film" name="durasi_film" value="<?php echo $row['durasi_film']; ?>" required placeholder="Duration (Minute)">
                            <input type="number" id="tahun_rilis" name="tahun_rilis" value="<?php echo $row['tahun_rilis']; ?>" required placeholder="Release Year">
                        </div>

                        <div class="sutradara-tanggal">
                            <input type="text" id="sutradara" name="sutradara" value="<?php echo $row['sutradara']; ?>" required placeholder="Sutradara">
                            <input type="text" id="tanggal_nonton" name="tanggal_nonton" value="<?php echo $row['tanggal_nonton']; ?>" required placeholder="Date Watched" class="datepicker">
                        </div>

                        <div class="isi">
                            <textarea id="isi_review" name="isi_review" required placeholder="Your Review Here!"><?php echo $row['isi_review']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="button-container">
                    <a href="movie_review.php?id_review=<?php echo $row['id_review']; ?>">Cancel Editing</a>
                    <button type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
