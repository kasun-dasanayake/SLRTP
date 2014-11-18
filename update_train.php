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
$train = NULL;

if(request_is_post() && request_is_same_domain()) {
    
    if(!csrf_token_is_valid() || !csrf_token_is_recent()) {
        $message = "Sorry, request was not valid.";
    } else {
        $a = $_POST['submit'];
        if($a == "Select"){
            $train_name = sql_prep($_POST['train_name']);
            if(has_exclusion_from($train_name, trains_list())) {
                $message = "train must be valid.";
            } else{
                $fstep = False;
                $nxtstep = True;
                $train = trainid_for_name($train_name);
            }
        } elseif($a == "Update"){
            $id = $_POST['id'];
            $name = sql_prep($_POST['train_name']);
            $type = $_POST['types'];
            $first_class = $_POST['first_class'];
            $second_class = $_POST['second_class'];
            $third_class = $_POST['third_class'];
            $canteen = $_POST['canteen'];

            $query = "UPDATE trains ";
            $query .= "SET name = '{$name}', type = {$type}, first_class = {$first_class}, ";
            $query .= "second_class = {$second_class}, third_class = {$third_class}, canteen = {$canteen} ";
            $query .= "WHERE id = {$id}";
            $result = mysql_query($query);
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
                                            $u = "<div class=\"success-box\" style=\"width: 700px;margin: auto;\"><div class=\"message-box\" style=\"padding: 5px;\">
                                                  <p>". h($smessage) ."</p></div></div>";
                                            echo $u;
                                            $smessage = "";
                                      }
                                    ?>
                                    </div>
                                    <div>
                                        <?php
                                            if($fstep){
                                                $k = "<form action=\"update_train.php\" method=\"post\" autocomplete=\"off\">";
                                                $k .= csrf_token_tag();
                                                $k .= "<table class=\"detail2\"><col style=\"width: 200px;\"><col style=\"width: 400px;\"><tbody>";
                                                $k .= "<tr class=\"parent1\"><td>Select a Train: <span class=\"colored\">*</span></td>";
                                                $k .= "<td><input  list=\"browsers2\" type=\"text\" name=\"train_name\" maxlength=\"30\" value=\"\" required autofocus/></td></tr>";
                                                $k .= "<tr  class=\"parent1\"><td colspan=\"2\"><input type=\"submit\" name=\"submit\" value=\"Select\" /></td></tr>";
                                                $k .= "</tbody></table></form>";
                                                echo $k;
                                            }
                                            if($nxtstep){
                                                $tid = $train['id'];
                                                $tname = $train['name'];
                                                $ttype = $train['type'];
                                                $tfc = $train['first_class'];
                                                $tsc = $train['second_class'];
                                                $ttc = $train['third_class'];
                                                $tcan = $train['canteen'];
                                                $r = "<form action=\"update_train.php\" method=\"post\" autocomplete=\"off\">";
                                                $r .= csrf_token_tag();
                                                $r .= "<input type=\"hidden\" name=\"id\" value=\"".$tid."\" />";
                                                $r .= "<table class=\"detail2\"><col style=\"width: 200px;\"><col style=\"width: 400px;\"><tbody>";
                                                $r .= "<tr class=\"parent1\"><td>Train Name: <span class=\"colored\">*</span></td><td><input type=\"text\" name=\"train_name\" maxlength=\"30\" value=\"".$tname."\" required autofocus/></td></tr>";
                                                $r .= "<tr class=\"parent1\"><td>Train Type: <span class=\"colored\">*</span></td><td style=\"font-size: 130%;\">";
                                                if($ttype == 1){
                                                    $r .= "<input type=\"radio\" name=\"types\" value=\"1\" checked=\"checked\" required autofocus/> Express&nbsp;<input type=\"radio\" name=\"types\" value=\"2\"  required autofocus/> Slow&nbsp;<input type=\"radio\" name=\"types\" value=\"3\"  required autofocus/> Inter City</td></tr>";
                                                } elseif($ttype == 2){
                                                    $r .= "<input type=\"radio\" name=\"types\" value=\"1\" required autofocus/> Express&nbsp;<input type=\"radio\" name=\"types\" value=\"2\" checked=\"checked\" required autofocus/> Slow&nbsp;<input type=\"radio\" name=\"types\" value=\"3\"  required autofocus/> Inter City</td></tr>";
                                                } else{
                                                    $r .= "<input type=\"radio\" name=\"types\" value=\"1\" required autofocus/> Express&nbsp;<input type=\"radio\" name=\"types\" value=\"2\"  required autofocus/> Slow&nbsp;<input type=\"radio\" name=\"types\" value=\"3\" checked=\"checked\" required autofocus/> Inter City</td></tr>";
                                                }
                                                $r .= "<tr class=\"parent1\"><td>First Class: <span class=\"colored\">*</span></td><td style=\"font-size: 130%;\">";
                                                if($tfc == 1){
                                                    $r .= "<input type=\"radio\" name=\"first_class\" value=\"1\" checked=\"checked\" required autofocus/> Yes&nbsp;<input type=\"radio\" name=\"first_class\" value=\"0\"  required autofocus/> No</td></tr>";
                                                }else{
                                                    $r .= "<input type=\"radio\" name=\"first_class\" value=\"1\"  required autofocus/> Yes&nbsp;<input type=\"radio\" name=\"first_class\" value=\"0\" checked=\"checked\" required autofocus/> No</td></tr>";
                                                }
                                                $r .= "<tr class=\"parent1\"><td>Second Class: <span class=\"colored\">*</span></td><td style=\"font-size: 130%;\">";
                                                if($tsc == 1){
                                                    $r .= "<input type=\"radio\" name=\"second_class\" value=\"1\" checked=\"checked\" required autofocus/> Yes&nbsp;<input type=\"radio\" name=\"second_class\" value=\"0\"  required autofocus/> No</td></tr>";
                                                }else{
                                                    $r .= "<input type=\"radio\" name=\"second_class\" value=\"1\"  required autofocus/> Yes&nbsp;<input type=\"radio\" name=\"second_class\" value=\"0\" checked=\"checked\" required autofocus/> No</td></tr>";
                                                }
                                                $r .= "<tr class=\"parent1\"><td>Third Class: <span class=\"colored\">*</span></td><td style=\"font-size: 130%;\">";
                                                if($ttc == 1){
                                                    $r .= "<input type=\"radio\" name=\"third_class\" value=\"1\" checked=\"checked\" required autofocus/> Yes&nbsp;<input type=\"radio\" name=\"third_class\" value=\"0\"  required autofocus/> No</td></tr>";
                                                }else{
                                                    $r .= "<input type=\"radio\" name=\"third_class\" value=\"1\"  required autofocus/> Yes&nbsp;<input type=\"radio\" name=\"third_class\" value=\"0\" checked=\"checked\" required autofocus/> No</td></tr>";
                                                }
                                                $r .= "<tr class=\"parent1\"><td>Canteen: <span class=\"colored\">*</span></td><td style=\"font-size: 130%;\">";
                                                if($tcan == 1){
                                                    $r .= "<input type=\"radio\" name=\"canteen\" value=\"1\" checked=\"checked\" required autofocus/> Yes&nbsp;<input type=\"radio\" name=\"canteen\" value=\"0\"  required autofocus/> No</td></tr>";
                                                }else{
                                                    $r .= "<input type=\"radio\" name=\"canteen\" value=\"1\"  required autofocus/> Yes&nbsp;<input type=\"radio\" name=\"canteen\" value=\"0\" checked=\"checked\" required autofocus/> No</td></tr>";
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