<?php require_once("initialize.php"); ?>
<?php before_every_protected_page(); 
    if(!accessble(2)){ redirect_to("index.php"); }
?>
<?php require('functions/header.php');?>
<?php

$message = "";
$smessage = "";

if(request_is_post() && request_is_same_domain()) {
    
    if(!csrf_token_is_valid() || !csrf_token_is_recent()) {
        $message = "Sorry, request was not valid.";
    } else {
        $train_name = sql_prep($_POST['train_name']);
        $msg_type = $_POST['msg_type'];
        $delay_time = $_POST['delay_time'];
        if(has_exclusion_from($train_name, trains_list())) {
            $message = "train must be valid.";
        } if(!is_numeric($delay_time)) {
            $message = "delay time must be valid.";
        } else {
            $t_i = trainid_for_name($train_name);
            $train_id = $t_i['id'];
            $query = "INSERT INTO message (
                                    train_no, type, valid_time
                            ) VALUES (
                                    {$train_id}, {$msg_type}, {$delay_time} 
                            )";
            $result = mysql_query($query, $connection);
            if ($result) {
                $smessage = "Success! added";
            } else{
                $message = "Sorry, request was not valid.";
            }
	}
    }
}

?>
<datalist id="browsers2">
    <?php 
    $list = trains_list();
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
						<h1 class="page-title">Add New Delayed train or Canceled train message.</h1>
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
                                            $u = "<div class=\"success-box\" style=\"width: 700px;margin: auto;\"><div class=\"message-box\" style=\"padding: 5px;\">
                                                  <p>". h($smessage) ."</p></div></div>";
                                            echo $u;
                                            $smessage = "";
                                      }
                                    ?>
                                    </div>
                                    <div>
                                        <form action="special_msg.php" method="post" autocomplete="off">
                                        <?php echo csrf_token_tag(); ?>
                                        <table class="detail2">
                                            <col style="width: 200px;">
                                            <col style="width: 400px;">
                                            <tbody>
                                            <tr class="parent1">
                                                <td>Train Name: <span class="colored">*</span></td>
                                                <td><input  list="browsers2" type="text" name="train_name" maxlength="30" value="" required autofocus/></td>
                                            </tr>
                                            <tr class="parent1">
                                                <td>Message type: <span class="colored">*</span></td>
                                                <td style="font-size: 130%;">
                                                    <input type="radio" name="msg_type" value="1"  required autofocus/> Delayed Train
                                                    &nbsp;
                                                    <input type="radio" name="msg_type" value="2"  required autofocus/> Canceled Train
                                                </td>
                                            </tr>
                                            <tr class="parent1">
                                                <td>Delay time: </td>
                                                <td><input type="text" name="delay_time" value=""/> min</td>
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