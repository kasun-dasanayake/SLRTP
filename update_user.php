<?php require_once("initialize.php"); ?>
<?php before_every_protected_page(); 
    if(!accessble(2)){ redirect_to("index.php"); }
?>
<?php require_once('functions/header.php');?>
<?php

$message = "";
$smessage = "";
$fstep = True;
$nxtstep = False;
$user = NULL;

if(request_is_post() && request_is_same_domain()) {
    
    if(!csrf_token_is_valid() || !csrf_token_is_recent()) {
        $message = "Sorry, request was not valid.";
    } else {
        $a = $_POST['submit'];
        if($a == "Select"){
            $username = sql_prep($_POST['username']);
            if(has_exclusion_from($username, users_list())) {
                $message = "user must be valid.";
            } else{
                $fstep = False;
                $nxtstep = True;
                $user = userid_for_name($username);
            }
        } elseif($a == "Update"){
            $id = $_POST['id'];
            $username = sql_prep($_POST['username']);
            $email = sql_prep($_POST['email']);
            $password = $_POST['password'];
            $password_confirm = $_POST['confirm_password'];
            $access_level = $_POST['access_level'];
            if($password !== $password_confirm) {
                $message = "Password confirmation does not match password.";
                $fstep = False;
                $nxtstep = True;
            } else {
                $hashed_password = sha1($password);
                $query = "UPDATE users ";
                $query .= "SET username = '{$username}', email = '{$email}', ";
                $query .= "hashed_password = '{$hashed_password}', access_level = {$access_level} ";
                $query .= "WHERE id = {$id}";
                $result = mysql_query($query, $connection);
                confirm_query($result);
                if ($result) {
                    $smessage = "Success!";
                    $fstep = True;
                    $nxtstep = False;
                } else{
                    $message = "Sorry, request was not valid.";
                    $fstep = False;
                    $nxtstep = True;
                }
            }
        }
    }
}

?>
<datalist id="browsers2">
    <?php 
    $list = users_list();
    foreach ($list as $row) {
        echo "<option value=\"{$row}\">";
    }
    
    ?>
</datalist>
<section style="min-height: 200px;" id="content" class="right-sidebar clearfix">
		
			<!-- INTRO -->
			<header class="page-heading clearfix">
				<div class="container">
				
					<!-- PAGE TITLE -->
					<div id="page-title">
						<h1 class="page-title">Update a Train</h1>
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
                                            $u = "<div class=\"error-box\"><div class=\"message-box\">
                                                  <p><strong>Error!</strong> ". h($message) ."</p></div></div>";
                                            echo $u;
                                            $message = "";
                                      } if($smessage != "") {
                                            $u = "<div class=\"success-box\" style=\"margin-bottom: 10px;\"><div class=\"message-box\" style=\"padding: 5px;\">
                                                  <p>". h($smessage) ."</p></div></div>";
                                            echo $u;
                                            $smessage = "";
                                      }
                                    ?>
                                    </div>
                                    <div>
                                        <?php
                                            if($fstep){
                                                $k = "<form action=\"update_user.php\" method=\"post\" autocomplete=\"off\">";
                                                $k .= csrf_token_tag();
                                                $k .= "<table class=\"detail2\"><col style=\"width: 200px;\"><col style=\"width: 400px;\"><tbody>";
                                                $k .= "<tr class=\"parent1\"><td>Select a User: <span class=\"colored\">*</span></td>";
                                                $k .= "<td><input  list=\"browsers2\" type=\"text\" name=\"username\" maxlength=\"30\" value=\"\" required autofocus/></td></tr>";
                                                $k .= "<tr  class=\"parent1\"><td colspan=\"2\"><input type=\"submit\" name=\"submit\" value=\"Select\" /></td></tr>";
                                                $k .= "</tbody></table></form>";
                                                echo $k;
                                            }
                                            if($nxtstep){
                                                $uid = $user['id'];
                                                $uname = $user['username'];
                                                $uemail = $user['email'];
                                                $ual = $user['access_level'];
                                                $r = "<form action=\"update_user.php\" method=\"post\" autocomplete=\"off\">";
                                                $r .= csrf_token_tag();
                                                $r .= "<input type=\"hidden\" name=\"id\" value=\"".$uid."\" />";
                                                $r .= "<table class=\"detail2\"><col style=\"width: 200px;\"><col style=\"width: 400px;\"><tbody>";
                                                $r .= "<tr class=\"parent1\"><td>Username: <span class=\"colored\">*</span></td><td><input type=\"text\" name=\"username\" maxlength=\"30\" value=\"".$uname."\" required autofocus/></td></tr>";
                                                $r .= "<tr class=\"parent1\"><td>Email: <span class=\"colored\">*</span></td><td><input type=\"email\" name=\"email\" maxlength=\"30\" value=\"".$uemail."\" required autofocus/></td></tr>";
                                                $r .= "<tr class=\"parent1\"><td>Password: <span class=\"colored\">*</span></td><td><input type=\"password\" name=\"password\" maxlength=\"30\" value=\"\" required autofocus/></td></tr>";
                                                $r .= "<tr class=\"parent1\"><td>Confirm Password: <span class=\"colored\">*</span></td><td><input type=\"password\" name=\"confirm_password\" maxlength=\"30\" value=\"\" required autofocus/></td></tr>";
                                                $r .= "<tr class=\"parent1\"><td>Access Level: <span class=\"colored\">*</span></td><td style=\"font-size: 130%;\">";
                                                if($ual == 1){
                                                    $r .= "<input type=\"radio\" name=\"access_level\" value=\"1\" checked=\"checked\" required autofocus/> Data Operator&nbsp;<input type=\"radio\" name=\"access_level\" value=\"2\"  required autofocus/> Admin</td></tr>";
                                                }else{
                                                    $r .= "<input type=\"radio\" name=\"access_level\" value=\"1\"  required autofocus/> Data Operator&nbsp;<input type=\"radio\" name=\"access_level\" value=\"2\" checked=\"checked\" required autofocus/> Admin</td></tr>";
                                                }
                                                $r .= "<tr  class=\"parent1\"><td colspan=\"2\"><input type=\"submit\" name=\"submit\" value=\"Update\" /></td></tr></tbody></table></form>";
                                                echo $r;
                                            }
                                            
                                        ?>
                                        
                                            
                                           
                                            
                                    </div>
                                </article>
			</div>
		
		</section>
<?php require_once('functions/footer.php');?>