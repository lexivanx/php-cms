<?php

function getDB() {
    $db_host = "localhost";
    $db_name = "php_cms_db";
    $db_user = "svacc_cms";
    $db_pass = "unRV_vDAIpW*0g90";

    $db_connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (mysqli_connect_error()) {
        echo mysqli_connect_error();
        exit;
    }

    return $db_connection;
}

?>