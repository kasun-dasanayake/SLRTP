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
        $name = sql_prep($_POST['station_name']);
        $id = sql_prep($_POST['id']);
        if(!is_numeric($id)){
            $message = "Sorry, request was not valid.";
        } else{
            $query = "INSERT INTO stations (
				id, name
			) VALUES (
				{$id},'{$name}'
			)";
            $result = mysql_query($query, $connection);
            if ($result) {
                redirect_to("staff.php?msg=success");
            } else{
                $message = "Sorry, request was not valid.";
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
						<h1 class="page-title">Add New Station</h1>
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
                                        <form action="new_station.php" method="post" autocomplete="off">
                                        <?php echo csrf_token_tag(); ?>
                                        <table class="detail2">
                                            <col style="width: 200px;">
                                            <col style="width: 400px;">
                                            <tbody>
                                            <tr class="parent1">
                                                <td>Id: <span class="colored">*</span></td>
                                                <td><input type="text" name="id" maxlength="3" value="" required autofocus/></td>
                                            </tr>
                                            <tr class="parent1">
                                                <td>Station Name: <span class="colored">*</span></td>
                                                <td><input type="text" name="station_name" maxlength="30" value="" required autofocus/></td>
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