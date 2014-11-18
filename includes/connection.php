<?php require_once("constants.php"); ?>
<?php
    $connection = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
    if(!$connection){
        echo mysql_error();
    }
    
    $db_select = mysql_select_db(DB_NAME);
    if(!$db_select){
        echo mysql_error();
    }
?>