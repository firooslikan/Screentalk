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
    <title>Your Reviews</title>
    <link rel="stylesheet" type="text/css" href="review_list.css">
</head>
<body>
    <div class="header">
        <a href="welcome.php" class="back-button">Back to Home Page</a>
        <h1>Movies/TV Series Reviewed by You</h1>
    </div>
    <div class="movie-posters">
        <?php
        $username = $_SESSION['username'];
        $sql = "SELECT moviereview.id_review, movie.judul_film, movie.poster_film FROM moviereview
        JOIN movie ON moviereview.id_movie = movie.id_movie
        WHERE moviereview.username = '$username'";
        $result = pg_query($connection, $sql);
 
        if ($result && pg_num_rows($result) > 0) {
            while ($row = pg_fetch_assoc($result)) {
                    echo "<div class='movie-review'>";
                    echo "<a href='movie_review.php?id_review=" . $row['id_review'] . "'>";
                    echo "<img src='" . $row['poster_film'] . "' alt='" . $row['judul_film'] . "' width='150' height='220'>";
                    echo "</a></div>";
            }
        } else {
            echo "<div class='no-review'>No reviewed movies found.</div>";
        }
        ?>
    </div>
</body>
</html>
