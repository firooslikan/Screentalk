<?php
    session_start();
    include("config.php");

    if (!isset($_SESSION['username'])) {
        header('Location: index.php?status=not_logged_in');
        exit;
    }

    $username = $_SESSION['username'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Screentalk</title>
    <link rel="stylesheet" type="text/css" href="favorite.css">
</head>
<body>
    <div class="header">
        <a href="welcome.php" class="back-button">Back to Home Page</a>
        <h1>Your Favorite Movies/TV Series</h1>
    </div>
    <div class="movie-posters">
    <?php
                $fav_sql = "SELECT moviereview.id_review, movie.judul_film, movie.poster_film 
                    FROM moviereview
                    JOIN movie ON moviereview.id_movie = movie.id_movie
                    JOIN favorite ON favorite.id_movie = movie.id_movie
                    WHERE favorite.username = '$username'";
                $fav_result = pg_query($connection, $fav_sql);

                if ($fav_result && pg_num_rows($fav_result) > 0) {
                    while ($fav_row = pg_fetch_assoc($fav_result)) {
                            $favReviewID = $fav_row['id_review'];
                            $favMovieTitle = $fav_row['judul_film'];
                            $favMoviePoster = $fav_row['poster_film'];

                            echo "<div class='favorite-movie'>";
                            echo "<a href='movie_review.php?id_review=$favReviewID'>";
                            echo "<img src='$favMoviePoster' alt='$favMovieTitle' width='150' height='220'>";
                            echo "</a></div>";
                    }
                    } else {
                        echo "<div class='no-favorite'>No favorite movies found.</div>";
                }
            ?>
    </div>
</body>
</html>
