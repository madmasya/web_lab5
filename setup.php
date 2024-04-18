<?php
    $server = "localhost";
    $user = "root";
    $password = "";
    $DB = "record_store";

    $link = mysqli_connect($server, $user, $password);

    if (!$link) {
        die("Error when try db connect" . mysql_error());
    }
    
    $db_selected = mysqli_select_db($link, $DB);
    if (!$db_selected) {
        die ("Error when db choose: record_store" . mysql_error());
    }
    mysqli_query($link, "SET NAMES utf8");
?>