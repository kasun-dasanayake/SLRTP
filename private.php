<?php require_once("initialize.php"); ?>

<?php
    before_every_protected_page();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Private page</title>
  </head>
  <body>
    <p>Hello <?php echo $_SESSION['username'];?></p>
    <p>This is a private page. It is only accessible when logged in.</p>
    <p>You can <a href="logout.php">log out</a>.
        
        <?php 
            if(accessble(1)){
                echo "<p>access level 1.</p>";
            }
            if(accessble(2)){
                echo "<p>access level 2.</p>";
            }
            
        ?>
  </body>
</html>