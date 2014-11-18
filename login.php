<?php require_once("initialize.php"); ?>
<?php require_once('functions/header.php');?>

<?php

block_blacklisted_ips();

$username = "";
$password = "";
$message = "";

if(request_is_post() && request_is_same_domain()) {
    
    if(!csrf_token_is_valid() || !csrf_token_is_recent()) {
        $message = "Sorry, request was not valid.";
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        if(has_presence($username) && has_presence($password)) {
            
            $throttle_delay = throttle_failed_logins($username);
            if($throttle_delay > 0){
                $message = "To many failed logins. ";
                $message .= "You must wait {$throttle_delay} minutes before you can attempt another login.";
            } else {
                $sqlsafe_username = sql_prep($username);
                $hashed_password = sha1($password);
                $user = find_user($sqlsafe_username,$hashed_password);
                if($user) { 
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['access_level'] = $user['access_level'];
                    $_SESSION['msg'] = "Welcome back ".ucwords($user['username']);
                    after_successful_login();
                    clear_failed_logins($username);
                    redirect_to('staff.php');
                } else {
                    record_failed_login($username);
                    $message = "Username/password combination not found.";
                }
            }
        } else {
            $message = "need ful data";
	}
    }
}

?>
<section style="min-height: 200px;" id="content" class="right-sidebar clearfix">
		
			<!-- INTRO -->
			<header class="page-heading clearfix">
				<div class="container">
				
					<!-- PAGE TITLE -->
					<div id="page-title">
						<h1 class="page-title">Login</h1>
					</div>
					<!-- / PAGE TITLE -->
					
				</div>
                            
			</header>
			<!-- / INTRO -->
			
			<div class="container">
		
				<!-- PAGE DESCRIPTION -->
				<div class="page-description">
					<h1>Login Here</h1>
					<hr>
				</div>
				<!-- / PAGE DESCRIPTION -->
					
				<article>
                                    <div>

                                    <?php
                                        if($message != "") {
                                            $u = "<div class=\"error-box\"><div class=\"message-box\">
                                                  <p><strong>Error!</strong> ". h($message) ."</p></div></div>";
                                            echo $u;
                                      }
                                    ?>

                                        <form action="login.php" method="POST" accept-charset="utf-8">
                                            <?php echo csrf_token_tag(); ?>
                                            <table>
                                                <tr>
                                                    <td>Username: </td>
                                                    <td><input type="text" name="username" value="<?php echo h($username); ?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td>Password: </td>
                                                    <td><input type="password" name="password" value="" /><br /></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="submit" name="submit" value="Log in" /></td>
                                                </tr>
                                                <tr>
                                                    <td><a style="font-size: 70%" href="forgot_password.php">I forgot my password.</a></td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>

                                </article>
			</div>
		
		</section>
<?php require_once('functions/footer.php');?>