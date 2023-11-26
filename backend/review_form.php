<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Screentalk</title>
    <link rel="stylesheet" type="text/css" href="review.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <script src="script.js"></script>
</head>
<body>
    <div class="container">
        <div class="review-container">
            <form action="reviewprocess.php" method="post" enctype="multipart/form-data">
            <div class="review-field">
                <div class="poster-rating">
                    <div class="rating">
                            <input type="radio" id="star5" name="rating" value="5" required>
                            <label for="star5"></label>
                            <input type="radio" id="star4" name="rating" value="4" required>
                            <label for="star4"></label>
                            <input type="radio" id="star3" name="rating" value="3" required>
                            <label for="star3"></label>
                            <input type="radio" id="star2" name="rating" value="2" required>
                            <label for="star2"></label>
                            <input type="radio" id="star1" name="rating" value="1" required>
                            <label for="star1"></label>
                    </div>
                    <div class="poster">
                        <label for="poster_film"></label>
                        <input type="file" id="poster_film" name="poster_film" accept="image/*" autocomplete="off" onchange="previewPoster(event)"><br><br>
                    </div>
                </div>

                <div class="review-box">
                    <div class="judul">
                        <input type="text" id="judul_film" name="judul_film" required autocomplete="off" placeholder="Movie/TV Series Name"><br><br>
                    </div>

                    <div class="genre-durasi-tahun">
                            <input type="text" id="genre_film" name="genre_film" required autocomplete="off" placeholder="Genre">
                            <input type="number" id="durasi_film" name="durasi_film" required autocomplete="off" placeholder="Duration (Minute)">
                            <input type="number" id="tahun_rilis" name="tahun_rilis" required autocomplete="off" placeholder="Release Year">
                    </div>

                    <div class="sutradara-tanggal">
                        <input type="text" id="sutradara" name="sutradara" required autocomplete="off" placeholder="Director's Name">
                        <input type="text" id="tanggal_nonton" name="tanggal_nonton" required autocomplete="off" placeholder="Date Watched" class="datepicker">
                    </div>
                
                    <div class="isi">
                        <textarea id="isi_review" name="isi_review" required autocomplete="off" placeholder="Your Review Here!"></textarea><br><br>
                    </div>

                </div>
            </div>
            <div class="button-container">
                    <a href="welcome.php">Cancel Review</a>
                    <button type="submit">Submit Review</button>
            </div>
            </form>
        </div>      
    </div>
</body>
</html>
