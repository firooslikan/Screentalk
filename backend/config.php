<?php
$host = 'localhost';
$username = 'postgres';
$password = 'admin'; //sesuaikan password di database postgresql
$database = 'screentalk_'; //sesuaikan nama database di database postgresql

$connection = pg_connect("host=$host dbname=$database user=$username password=$password");

if (!$connection) {
    die("Connection failed: " . pg_last_error());
}
?>