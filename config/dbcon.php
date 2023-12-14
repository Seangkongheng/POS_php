<?php
    define('DB_SEVER',"localhost");
    define('DB_USERNAME',"root");
    define('DB_PASSWORD',"");
    define('DB_DATABASE',"post_systme_php");



    $conn =mysqli_connect(DB_SEVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

    // if databas connection fale
    if(!$conn){
        die("conection fail".mysqli_connect_error());
    }
?>