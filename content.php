<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/header.php"); ?>
<?php
	if(isset($_GET['train_no'])){
            $train = mysql_fetch_array(train_details($_GET['train_no']));
            $station = NULL;
        } elseif(isset($_GET['station_no'])){
            $station = mysql_fetch_array(station_details_id($_GET['station_no']));
            $train = NULL;
        } else{
            redirect_to("index.php");
        }
?>
<td id="navigation">
    <a href="login.php">Staff Area</a>
        &nbsp;
</td>

<td id="page">
    <?php if(!is_null($train)){?>
        <h2><?php 
        echo $train['name'];
        ?></h2>
    <?php } elseif(!is_null($station)){ ?>
        <h2><?php 
        echo $station['name'];
        ?></h2>
    <?php } else{echo "nothing"; }?>
        <br/>
        <a href="index.php">back to home</a>
</td>
<?php require_once("includes/footer.php"); ?>