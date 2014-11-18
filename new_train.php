<?php require_once("initialize.php"); ?>
<?php before_every_protected_page(); 
    if(!accessble(2)){ redirect_to("index.php"); }
?>
<?php require_once('functions/header.php');?>
<?php

$message = "";

if(request_is_post() && request_is_same_domain()) {
    
    if(!csrf_token_is_valid() || !csrf_token_is_recent()) {
        $message = "Sorry, request was not valid.";
    } else {
        $name = sql_prep($_POST['train_name']);
        $type = $_POST['types'];
        $first_class = $_POST['first_class'];
        $second_class = $_POST['second_class'];
        $third_class = $_POST['third_class'];
        $canteen = $_POST['canteen'];
    
        $query = "INSERT INTO trains (
				name, type, first_class, second_class, third_class, canteen
			) VALUES (
				'{$name}', {$type}, {$first_class}, {$second_class}, {$third_class}, {$canteen}
			)";
        $result = mysql_query($query, $connection);
	if ($result) {
            redirect_to("staff.php?msg=success");
	} else{
            $message = "Sorry, request was not valid.";
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
						<h1 class="page-title">Add New Train</h1>
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
                                        <form action="new_train.php" method="post" autocomplete="off">
                                        <?php echo csrf_token_tag(); ?>
                                        <table class="detail2">
                                            <col style="width: 200px;">
                                            <col style="width: 400px;">
                                            <tbody>
                                            <tr class="parent1">
                                                <td>Train Name: <span class="colored">*</span></td>
                                                <td><input type="text" name="train_name" maxlength="30" value="" required autofocus/></td>
                                            </tr>
                                            <tr class="parent1">
                                                <td>Train Type: <span class="colored">*</span></td>
                                                <td style="font-size: 130%;">
                                                    <input type="radio" name="types" value="1"  required autofocus/> Express
                                                    &nbsp;
                                                    <input type="radio" name="types" value="2"  required autofocus/> Slow
                                                    &nbsp;
                                                    <input type="radio" name="types" value="3"  required autofocus/> Inter City
                                                </td>
                                            </tr>
                                            <tr class="parent1">
                                                <td>First Class: <span class="colored">*</span></td>
                                                <td style="font-size: 130%;">
                                                    <input type="radio" name="first_class" value="1"  required autofocus/> Yes
                                                    &nbsp;
                                                    <input type="radio" name="first_class" value="0"  required autofocus/> No
                                                </td>
                                            </tr>
                                            <tr class="parent1">
                                                <td>Second Class: <span class="colored">*</span></td>
                                                <td style="font-size: 130%;">
                                                    <input type="radio" name="second_class" value="1"  required autofocus/> Yes
                                                    &nbsp;
                                                    <input type="radio" name="second_class" value="0"  required autofocus/> No
                                                </td>
                                            </tr>
                                            <tr class="parent1">
                                                <td>Third Class: <span class="colored">*</span></td>
                                                <td style="font-size: 130%;">
                                                    <input type="radio" name="third_class" value="1"  required autofocus/> Yes
                                                    &nbsp;
                                                    <input type="radio" name="third_class" value="0"  required autofocus/> No
                                                </td>
                                            </tr>
                                            <tr class="parent1">
                                                <td>Canteen: <span class="colored">*</span></td>
                                                <td style="font-size: 130%;">
                                                    <input type="radio" name="canteen" value="1"  required autofocus/> Yes
                                                    &nbsp;
                                                    <input type="radio" name="canteen" value="0"  required autofocus/> No
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