<?php 

$host = "localhost";
$user = "root";
$pass = "";
$db = "url";
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
$conn = mysqli_connect($host, $user, $pass, $db);

if(!$conn){
    echo "Database connection error".mysqli_connect_error();
}