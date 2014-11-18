<?php require_once("initialize.php"); ?>
<?php

$token = "none";

$username = 'rajitha';

$user = find_user_for_token($username);
if($user && isset($user['token'])) {
	$token = $user['token'];
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Password Reset Email</title>
  </head>
  <body>
	
    <p>This page is a simulation of what a password reset token email might look like.</p>
		<hr />
		<p>
			FROM: emailer@sample_app<br />
			TO: <?php echo $username ?>@somewhere.com<br />
			SUBJECT: Reset Password Request
		</p>
		
    <p>You can use the link below to reset your password.</p>
		
		<p>
			<?php $url = "reset_password.php?token=" . u($token); ?>
			<a href="<?php echo $url; ?>"><?php echo $url; ?></a>
		</p>

		<p>If you did not make this request, you do not need to take any action. Your password cannot be changed without clicking the above link to verify the request.</p>
		
		<hr />
  </body>
</html>
