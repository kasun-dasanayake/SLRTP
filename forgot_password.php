<?php require_once("initialize.php"); ?>
<?php require_once('functions/header.php');?>

<?php

block_blacklisted_ips();

$username = "";
$message = "";

if(request_is_post() && request_is_same_domain()) {
    if(!csrf_token_is_valid() || !csrf_token_is_recent()) {
        $message = "Sorry, request was not valid.";
    } else {
        $username = $_POST['username'];
        if(has_presence($username)) {
            $sqlsafe_username = sql_prep($username);
            $user = find_user_for_token($username);
            if($user) {
                create_reset_token($username);
		email_reset_token($username);
	    } else {
	    }
        $message = "A link to reset your password has been sent to the email address on file.";	
	} else {
            $message = "Please enter a username.";
	}
  }
}

?>

<article>
    <div>
    
    <?php
      if($message != "") {
        echo '<p>' . h($message) . '</p>';
      }
    ?>
    
    <p>Enter your username to reset your password.</p>
    
        <form action="forgot_password.php" method="POST" accept-charset="utf-8">
        <?php echo csrf_token_tag(); ?>
            <table>
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" value="<?php echo h($username); ?>" /></td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" value="Submit" /></td>
                </tr>
            </table>
        </form>
    </div>

</article>

<aside class="about">
    <p> Login </p>
    <section>
        <p><a href="index.php">Home</a> </p>
    </section>
    
</aside>
<?php require_once('functions/footer.php');?>