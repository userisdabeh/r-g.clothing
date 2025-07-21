<?php
$servername = "127.0.0.1";
$username = "student3";
$password = "Dlsu1234!";
$dbname = "rg_clothing";
$port = 3307;

$dbconn = mysqli_connect($servername, $username, $password, $dbname, $port);

if (!$dbconn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>