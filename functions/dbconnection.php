<?php

    require_once("constants.php");

    $connection = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
    if(!$connection){
        die("Database connection failed: " . mysql_error());
    }
    
    $db_select = mysql_select_db(DB_NAME);
    if(!$db_select){
        die("Database connection failed: " . mysql_error());
    }
?>
