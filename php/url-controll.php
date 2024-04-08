<?php
include "config.php";

if ($conn) {
    $full_url = mysqli_real_escape_string($conn, $_POST['full_url']);

    if (!empty($full_url) && filter_var($full_url, FILTER_VALIDATE_URL)) {

        $ran_url = substr(md5(microtime()), rand(0, 26), 5);
        $check_duplicate = mysqli_query($conn, "SELECT * FROM url WHERE shorten_url = '{$ran_url}'");

        if (mysqli_num_rows($check_duplicate) > 0) {
            $ran_url = substr(md5(microtime()), rand(0, 26), 5);
        }
        $insert_query = mysqli_query($conn, "INSERT INTO url (full_url, shorten_url, clicks) 
                                         VALUES ('{$full_url}', '{$ran_url}', '0')");

        if ($insert_query) {
            echo $ran_url;
        } else {
            echo "Error: Unable to insert into database!";
        }

    } else {
        echo "Error: Invalid URL!";
    }
} else {
    echo "Error: Unable to connect to database!";
}