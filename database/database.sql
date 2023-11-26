CREATE DATABASE screentalk;

CREATE TABLE Users (
Username VARCHAR(60) NOT NULL,
Display_name VARCHAR(60) NOT NULL,
Email VARCHAR(255) NOT NULL,
Password_hash VARCHAR(255) NOT NULL,
CONSTRAINT Users_Username_PK PRIMARY KEY (Username)
);

CREATE TABLE Movie (
id_movie VARCHAR(255) NOT NULL,
judul_film VARCHAR(255) NOT NULL,
tahun_rilis INT NOT NULL,
genre_film VARCHAR(60) NOT NULL,
sutradara VARCHAR(255) NOT NULL,
durasi_film INT NOT NULL,
poster_film VARCHAR(255),
CONSTRAINT Movie_id_movie_PK PRIMARY KEY (id_movie)
);

CREATE TABLE MovieReview (
id_review VARCHAR(255) NOT NULL,
id_movie VARCHAR(255),
Username VARCHAR(60),
tanggal_nonton DATE,
tanggal_review DATE,
rating INT NOT NULL,
isi_review TEXT,
CONSTRAINT MovieReview_id_review_PK PRIMARY KEY (id_review),
CONSTRAINT MovieReview_id_movie_FK FOREIGN KEY (id_movie) REFERENCES Movie (id_movie),
CONSTRAINT MovieReview_Username_FK FOREIGN KEY (Username) REFERENCES Users (Username)
);

CREATE TABLE Favorite (
id_favorite VARCHAR(255) NOT NULL,
Username VARCHAR(60) NOT NULL,
id_movie VARCHAR(255) NOT NULL,
CONSTRAINT Favorite_id_favorite_PK PRIMARY KEY(id_favorite),
CONSTRAINT Favorite_Username_FK FOREIGN KEY(Username) REFERENCES Users(Username),
CONSTRAINT Favorite_id_movie_FK FOREIGN KEY(id_movie) REFERENCES Movie(id_movie)
);
