<?php require_once("initialize.php"); ?>
<?php before_every_protected_page(); 
    if(!accessble(2)){ redirect_to("index.php"); }
?>
<?php require_once('functions/header.php');?>
<?php

$message = "";
$username = "";
$email = "";

if(request_is_post() && request_is_same_domain()) {
    
    if(!csrf_token_is_valid() || !csrf_token_is_recent()) {
        $message = "Sorry, request was not valid.";
    } else {
        $username = sql_prep($_POST['username']);
        $email = sql_prep($_POST['email']);
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
        $access_level = $_POST['access_level'];
        if($password !== $password_confirm) {
            $message = "Password confirmation does not match password.";
        } else {
            $hashed_password = sha1($password);
            $query = "INSERT INTO users (
                                    username, email, hashed_password, access_level
                            ) VALUES (
                                    '{$username}', '{$email}', '{$hashed_password}', {$access_level}
                            )";
            $result = mysql_query($query, $connection);
            if ($result) {
                redirect_to("staff.php?msg=success");
            } else{
                $message = "Sorry, request was not valid.aaaaa";
            }
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
						<h1 class="page-title">Add New User</h1>
					</div>
					<!-- / PAGE TITLE -->
					
				</div>
                            
			</header>
			<!-- / INTRO -->
			
			<div class="container">
		
				<!-- PAGE DESCRIPTION -->
				<div class="page-description">
					<h1>Pricing Tables</h1>
					<hr>
					<p>pick a plan that best fits your needs</p>
				</div>
				<!-- / PAGE DESCRIPTION -->
                                <article>
                                    <div>
                                    <?php
                                        if($message != "") {
                                            echo '<p>' . h($message) . '</p>';
                                        }
                                    ?>
                                    </div>
                                    <div>
                                        <form action="new_user.php" method="post" autocomplete="off">
                                        <?php echo csrf_token_tag(); ?>
                                        <table class="detail2">
                                            <col style="width: 230px;">
                                            <col style="width: 370px;">
                                            <tbody>
                                            <tr class="parent1">
                                                <td>Username: <span class="colored">*</span></td>
                                                <td><input type="text" name="username" maxlength="30" value="<?php echo htmlspecialchars($username);?>" required autofocus/></td>
                                            </tr>
                                            <tr class="parent1">
                                                <td>Email: <span class="colored">*</span></td>
                                                <td><input type="email" name="email" value="<?php echo htmlspecialchars($email);?>" required autofocus/></td>
                                            </tr>
                                            <tr class="parent1">
                                                <td>Password: <span class="colored">*</span></td>
                                                <td><input type="password" name="password" maxlength="30" value="" required autofocus/></td>
                                            </tr>
                                            <tr class="parent1">
                                                <td>Confirm Password: <span class="colored">*</span></td>
                                                <td><input type="password" name="password_confirm" maxlength="30" value="" required autofocus/></td>
                                            </tr>
                                            <tr class="parent1">
                                                <td>Access Level: <span class="colored">*</span></td>
                                                <td style="font-size: 130%;">
                                                    <input type="radio" name="access_level" value="1"  required autofocus/> Data Operator
                                                    &nbsp;
                                                    <input type="radio" name="access_level" value="2"  required autofocus/> Admin
                                                </td>
                                                </td>
                                            </tr>
                                            <tr  class="parent1">
                                                <td colspan="2"><input type="submit" name="submit" value="Result" /></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                    </div>
                                </article>
			</div>
		
		</section>
<?php require_once('functions/footer.php');?>