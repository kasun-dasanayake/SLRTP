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
$stop = NULL;
$train_n = NULL;
$station_n = NUll;

if(request_is_post() && request_is_same_domain()) {
    
    if(!csrf_token_is_valid() || !csrf_token_is_recent()) {
        $message = "Sorry, request was not valid.";
    } else {
        $a = $_POST['submit'];
        if($a == "Select"){
            $train_n = sql_prep($_POST['train_name']);
            $station_n = sql_prep($_POST['station_name']);
            if(has_exclusion_from($train_n, trains_list()) || has_exclusion_from($station_n, stations_list())) {
                $message = "train must be valid.";
            } else{  
                $train_name = trainid_for_name($train_n);
                $station_name = stationid_for_name($station_n);
                $stop = select_stop($train_name['id'], $station_name['id']);
                if($stop){
                    $fstep = False;
                    $nxtstep = True;
                } else{
                    $message = "Wrong combination.";
                }
                
            }
        } elseif($a == "Update"){
            $id = $_POST['id'];
            $train_name = sql_prep($_POST['train_name']);
            $station_name = sql_prep($_POST['station_name']);
            $arrive_time = time_to_int($_POST['arrive_time']);
            $depart_time = time_to_int($_POST['depart_time']);
            if($depart_time < $arrive_time){
                $message = "depart time and arrive_time must be valid.";
            } elseif(has_exclusion_from($train_name, trains_list()) || has_exclusion_from($station_name, stations_list())) {
                $message = "Stations must be valid.";
            } else {
                $s_i = stationid_for_name($station_name);
                $station_id = $s_i['id'];
                $t_i = trainid_for_name($train_name);
                $train_id = $t_i['id'];
                $query = "UPDATE stops ";
                $query .= "SET train_no = {$train_id}, station_no = {$station_id}, ";
                $query .= "arrive_time = {$arrive_time}, depart_time = {$depart_time} ";
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
<datalist id="browsers1">
    <?php 
    $list = stations_list();
    foreach ($list as $row) {
        echo "<option value=\"{$row}\">";
    }
    
    ?>
</datalist>
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
						<h1 class="page-title">Update a Stop</h1>
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
                                                $k = "<form action=\"update_stop.php\" method=\"post\" autocomplete=\"off\">";
                                                $k .= csrf_token_tag();
                                                $k .= "<table class=\"detail2\"><col style=\"width: 200px;\"><col style=\"width: 400px;\"><tbody>";
                                                $k .= "<tr class=\"parent1\"><td>Select Train: <span class=\"colored\">*</span></td>";
                                                $k .= "<td><input  list=\"browsers2\" type=\"text\" name=\"train_name\" maxlength=\"30\" value=\"\" required autofocus/></td></tr>";
                                                $k .= "<tr class=\"parent1\"><td>Select Station: <span class=\"colored\">*</span></td>";
                                                $k .= "<td><input  list=\"browsers1\" type=\"text\" name=\"station_name\" maxlength=\"30\" value=\"\" required autofocus/></td></tr>";
                                                $k .= "<tr  class=\"parent1\"><td colspan=\"2\"><input type=\"submit\" name=\"submit\" value=\"Select\" /></td></tr>";
                                                $k .= "</tbody></table></form>";
                                                echo $k;
                                            }
                                            if($nxtstep){
                                                $tid = $stop['id'];
                                                $at = $stop['arrive_time'];
                                                $dt = $stop['depart_time'];
                                                $r = "<form action=\"update_stop.php\" method=\"post\" autocomplete=\"off\">";
                                                $r .= csrf_token_tag();
                                                $r .= "<input type=\"hidden\" name=\"id\" value=\"".$tid."\" />";
                                                $r .= "<table class=\"detail2\"><col style=\"width: 200px;\"><col style=\"width: 400px;\"><tbody>";
                                                $r .= "<tr class=\"parent1\"><td>Train Name: <span class=\"colored\">*</span></td><td><input list=\"browsers2\" type=\"text\" name=\"train_name\" maxlength=\"30\" value=\"".$train_n."\" required autofocus/></td></tr>";
                                                $r .= "<tr class=\"parent1\"><td>Station Name: <span class=\"colored\">*</span></td><td><input list=\"browsers1\" type=\"text\" name=\"station_name\" maxlength=\"30\" value=\"".$station_n."\" required autofocus/></td></tr>";
                                                $r .= "<tr class=\"parent1\"><td>Arrive Time: <span class=\"colored\">*</span></td><td><input type=\"text\" name=\"arrive_time\" maxlength=\"30\" value=\"".int_to_timet($at)."\" id=\"a\"  required autofocus/></td></tr>";
                                                $r .= "<tr class=\"parent1\"><td>Depart Time: <span class=\"colored\">*</span></td><td><input type=\"text\" name=\"depart_time\" maxlength=\"30\" value=\"".int_to_timet($dt)."\" id=\"a\" required autofocus/></td></tr>";
                                                $r .= "<tr  class=\"parent1\"><td colspan=\"2\"><input type=\"submit\" name=\"submit\" value=\"Update\" /></td></tr></tbody></table></form>";
                                                echo $r;
                                            }
                                            
                                        ?>
                                        
                                            
                                           
                                            
                                    </div>
                                </article>
			</div>
		
		</section>
<?php require_once('functions/footer.php');?>