<?php
session_start();
include("config.php");

if (isset($_GET['id_review'])) {
    $id_review = pg_escape_string($connection, $_GET['id_review']);

    $sql = "SELECT movie.*, moviereview.*
            FROM movie
            LEFT JOIN moviereview ON movie.id_movie = moviereview.id_movie
            WHERE moviereview.id_review = '$id_review'";
    $result = pg_query($connection, $sql);

    if (!$result || pg_num_rows($result) !== 1) {
        header('Location: welcome.php?status=review_not_found');
        exit;
    }

    $movie = pg_fetch_assoc($result);
} else {
    header('Location: welcome.php?status=invalid_review_id');
    exit;
}

if (isset($_GET['id_review'])) {

    $id_movie = $movie['id_movie']; 

    $checkFavoriteQuery = "SELECT id_favorite FROM favorite WHERE id_movie = '$id_movie' AND username = '{$_SESSION['username']}'";
    $checkFavoriteResult = pg_query($connection, $checkFavoriteQuery);

    $isFavorite = (pg_num_rows($checkFavoriteResult) > 0);

    if ($isFavorite) {
        $favorite_row = pg_fetch_assoc($checkFavoriteResult);
        $favorite_id = $favorite_row['id_favorite'];
    }
} else {
    header('Location: welcome.php?status=invalid_review_id');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Screentalk</title>
    <link rel="stylesheet" type="text/css" href="movie_review.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</head>
<body>
    <div class="container">
        <div class="review-container">
            <div class="review-field">
                <div class="poster-rating">
                    <div class="rating">
                        <?php
                            if ($movie && isset($movie['rating'])) {
                                $ratingValue = $movie['rating'];
                                    for ($i = 5; $i >= 1; $i--) {
                                        $starImage = $ratingValue >= $i ? 'star.png' : 'star-empty.png';
                                        echo '<img src="' . $starImage . '" alt="Star">';
                                    }
                            }
                        ?>
                    </div>

                    <div class="poster">
                        <img src="<?php echo $movie['poster_film']; ?>" alt="Movie Poster">
                    </div>
                </div>

                <div class="review-box">
                    <div class="judul">
                        <p><?php echo $movie['judul_film']; ?></p>
                    </div>

                    <div class="genre-durasi-tahun">
                        <p>Genre: <?php echo $movie['genre_film']; ?></p>
                        <p>Duration: <?php echo $movie['durasi_film']; ?> Minute</p>
                        <p>Release Year: <?php echo $movie['tahun_rilis']; ?></p>
                    </div>

                    <div class="sutradara-tanggal">
                        <p>Director: <?php echo $movie['sutradara']; ?></p>
                        <p>Date Watched: <?php echo $movie['tanggal_nonton']; ?></p>
                    </div>

                    <div class="isi">
                        <p><?php echo $movie['isi_review']; ?></p>
                    </div>
                </div>
            </div>
                <div class="button-container">
                    <a href="welcome.php">Back to Home Page</a>
                    <button id="deleteButton" onclick="deleteReview('<?php echo $movie['id_review']; ?>')">Delete Review</button>
                    <?php
                        if ($isFavorite) {
                            echo '<form action="delete_favorite.php" method="GET">';
                            echo '<input type="hidden" name="id_favorite" value="' . $favorite_id . '">';
                            echo '<button type="submit" name="remove_from_favorite" class="favorite-button">Remove from Favorite</button>';
                            echo '</form>';
                        } else {
                            echo '<form action="favoriteprocess.php" method="GET">';
                            echo '<input type="hidden" name="id_movie" value="' . $movie['id_movie'] . '">';
                            echo '<button type="submit" name="add_to_favorite" class="favorite-button">Add to Favorite</button>';
                            echo '</form>';
                        }
                    ?>
                    <a href="edit_review.php?id_review=<?php echo $movie['id_review']; ?>&id_movie=<?php echo $movie['id_movie']; ?>">Edit Review</a>
                </div>
        </div>
    </div>
</body>
</html>