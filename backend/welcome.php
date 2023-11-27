<?php
    session_start();
    include("config.php");
    if (!isset($_SESSION['username'])) {
        header('Location: index.php?status=not_logged_in');
        exit;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Screentalk</title>
    <link rel="stylesheet" type="text/css" href="welcome.css">
</head>
<body>
        <div class="header">
            <div class="logo-container">
                <img src="screentalks_.png" alt="">
            </div>
            <div class="header-button-container">
                <a href="logout.php" class="logout-button">Logout</a>
            </div>
        </div>
        <div class="container">
            <img src="welcome_.png" alt="">
            <div class="button-container">
                <div class="add-review-container">
                <a href="review_form.php" class="add-review-button">+ Add your review here!</a>
            </div>
        </div>
    
    <div class="reviewed-movies">
        <h2>Movies/TV Series Reviewed by You</h2>
        <div class="movie-posters">
            <?php
            $username = $_SESSION['username'];
            $sql = "SELECT moviereview.id_review, movie.judul_film, movie.poster_film FROM moviereview
            JOIN movie ON moviereview.id_movie = movie.id_movie
            WHERE moviereview.username = '$username'";
            $result = pg_query($connection, $sql);
        
            $limit = 11;
            $count = 0;
            if ($result && pg_num_rows($result) > 0) {
                while ($row = pg_fetch_assoc($result)) {
                    if ($count < $limit) {
                    echo "<div class='movie-review'>";
                    echo "<a href='movie_review.php?id_review=" . $row['id_review'] . "'>";
                    echo "<img src='" . $row['poster_film'] . "' alt='" . $row['judul_film'] . "' width='150' height='220'>";
                    echo "</a></div>";
                    }
                    $count++;
                }
                if ($count > $limit) {
                    echo "<div class='view-all'>";
                    echo "<a href='review_list.php' class='view-all-button'>View All</a>";
                    echo "</div>";
                }
            } else {
                echo "<div class='no-review'>No reviewed movies found.</div>";
            }
            ?>
        </div>
    </div>
    <h2>Your Favorite Movie</h2>
        <div class="favorite-posters">
            <?php
                $fav_sql = "SELECT moviereview.id_review, movie.judul_film, movie.poster_film 
                    FROM moviereview
                    JOIN movie ON moviereview.id_movie = movie.id_movie
                    JOIN favorite ON favorite.id_movie = movie.id_movie
                    WHERE favorite.username = '$username'";
                $fav_result = pg_query($connection, $fav_sql);

                $limit = 11;
                $count = 0;
                if ($fav_result && pg_num_rows($fav_result) > 0) {
                    while ($fav_row = pg_fetch_assoc($fav_result)) {
                        if ($count < $limit) {
                            $favReviewID = $fav_row['id_review'];
                            $favMovieTitle = $fav_row['judul_film'];
                            $favMoviePoster = $fav_row['poster_film'];

                            echo "<div class='favorite-movie'>";
                            echo "<a href='movie_review.php?id_review=$favReviewID'>";
                            echo "<img src='$favMoviePoster' alt='$favMovieTitle' width='150' height='220'>";
                            echo "</a></div>";
                        }
                        $count++;
                    }
                        if ($count > $limit) {
                            echo "<div class='view-all'>";
                            echo "<a href='favorite.php' class='view-all-button'>View All</a>";
                            echo "</div>";
                        }
                    } else {
                        echo "<div class='no-favorite'>No favorite movies found.</div>";
                }
            ?>
        </div>
</div>
</body>
</html>