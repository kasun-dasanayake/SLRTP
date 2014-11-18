<?php require_once("initialize.php"); ?>
<?php block_blacklisted_ips(); 
    if(!isset($_GET['no'])){
        redirect_to('index.php');
    } else{
        $sn = station_for_no($_GET['no']);
        if(!$sn){
            redirect_to('index.php');
        } else{
            $station = mysql_fetch_array($sn);
        }
    }
?>
<?php require_once('functions/header.php');?>

<section style="min-height: 200px;" id="content" class="right-sidebar clearfix">
		
			<!-- INTRO -->
			<header class="page-heading clearfix">
				<div class="container">
				
					<!-- PAGE TITLE -->
					<div id="page-title">
                                            <h1 class="page-title"><?php echo ucfirst($station['name']);?></h1>
					</div>
					<!-- / PAGE TITLE -->
					
				</div>
                            
			</header>
			<!-- / INTRO -->
			
			<div class="container">
		
				<!-- PAGE DESCRIPTION -->
                                <div class="google-map"><?php echo "<iframe src=\"".$station['map']."\" width=\"960\" height=\"450\" frameborder=\"0\" style=\"border:0\">
                                    
                                    </iframe>";?></div>
					
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