<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'viento_php');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
/* $mysqli=new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME); */

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$gmailid = 'ad@gmail.com'; // YOUR gmail email
$gmailpassword = 'bugra159123'; // YOUR gmail password
$gmailusername = 'bogie'; // YOUR gmail User name

?>