<?php require_once("initialize.php"); ?>
<?php require_once('functions/header.php');?>
<?php

block_blacklisted_ips();

$message = "";
$token = $_GET['token'];

$user = find_user_by_token($token);
if(!isset($user)) {
	redirect_to('forgot_password.php');
}

if(request_is_post() && request_is_same_domain()) {
    if(!csrf_token_is_valid() || !csrf_token_is_recent()) {
  	$message = "Sorry, request was not valid.";
    } else {
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
    
        if(!has_presence($password) || !has_presence($password_confirm)) {
            $message = "Password and Confirm Password are required fields.";
        } //elseif(!has_length($password, array('min' => 8))) {
            //$message = "Password must be at least 8 characters long.";
        //} elseif(!has_format_matching($password, '/[^A-Za-z0-9]/')) {
           // $message = "Password must contain at least one character which is not a letter or a number.";
        //} 
        elseif($password !== $password_confirm) {
            $message = "Password confirmation does not match password.";
        } else {
            $hashed_password = sha1($password);
            update_user_password($user['id'], $hashed_password);
            delete_reset_token($user['username']);
            redirect_to('login.php');
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

    <p>Set your new password.</p>
    
    <?php $url = "reset_password.php?token=" . u($token); ?>
    <form action="<?php echo $url; ?>" method="POST" accept-charset="utf-8">
        <?php echo csrf_token_tag(); ?>
        <table>
            <tr>
                <td>Password: </td>
                <td><input type="password" name="password" value="" /></td>
            </tr>
            <tr>
                <td>Confirm Password: </td>
                <td><input type="password" name="password_confirm" value="" /></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="Set password" /></td>
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