<?php

include "config.php";

$og_url = mysqli_real_escape_string($conn, $_POST['shorten_url']);
$shorten_url = str_replace(' ', '', $og_url);
$hidden_url = mysqli_real_escape_string($conn, $_POST['hidden_url']);

$current_domain = $_SERVER['HTTP_HOST'];

$actual_domain = parse_url($shorten_url, PHP_URL_HOST);

if ($actual_domain !== $current_domain) {
    echo "Invalid URL - You can't edit domain name!";
    exit;
}

if (!empty($shorten_url)) {
    $explodeURL = explode('/', $shorten_url);
    $shortURL = end($explodeURL);
    if ($shortURL != "") {
        $sql = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = '{$shortURL}' && shorten_url != '{$hidden_url}'");
        if (mysqli_num_rows($sql) == 0) {
            $sql2 = mysqli_query($conn, "UPDATE url SET shorten_url = '{$shortURL}' WHERE shorten_url = '{$hidden_url}'");
            if ($sql2) {
                echo "success";
            } else {
                echo "Error - Failed to update link!";
            }
        } else {
            echo "The short url that you've entered already exist. Please enter another one!";
        }
    } else {
        echo "Required - You have to enter short url! ";
    }
} else {
    echo "Error- You have to enter short url!";
}