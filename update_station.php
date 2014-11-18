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
$station = NULL;

if(request_is_post() && request_is_same_domain()) {
    
    if(!csrf_token_is_valid() || !csrf_token_is_recent()) {
        $message = "Sorry, request was not valid.";
    } else {
        $a = $_POST['submit'];
        if($a == "Select"){
            $station_name = sql_prep($_POST['station_name']);
            if(has_exclusion_from($station_name, stations_list())) {
                $message = "station must be valid.";
            } else{
                $fstep = False;
                $nxtstep = True;
                $station = stationid_for_name($station_name);
            }
        } elseif($a == "Update"){
            $id = $_POST['id'];
            $name = sql_prep($_POST['station_name']);

            $query = "UPDATE stations ";
            $query .= "SET name = '{$name}' ";
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
<datalist id="browsers1">
    <?php 
    $list = stations_list();
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
						<h1 class="page-title">Update a Station</h1>
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
                                                $k = "<form action=\"update_station.php\" method=\"post\" autocomplete=\"off\">";
                                                $k .= csrf_token_tag();
                                                $k .= "<table class=\"detail2\"><col style=\"width: 200px;\"><col style=\"width: 400px;\"><tbody>";
                                                $k .= "<tr class=\"parent1\"><td>Select a Station: <span class=\"colored\">*</span></td>";
                                                $k .= "<td><input  list=\"browsers1\" type=\"text\" name=\"station_name\" maxlength=\"30\" value=\"\" required autofocus/></td></tr>";
                                                $k .= "<tr  class=\"parent1\"><td colspan=\"2\"><input type=\"submit\" name=\"submit\" value=\"Select\" /></td></tr>";
                                                $k .= "</tbody></table></form>";
                                                echo $k;
                                            }
                                            if($nxtstep){
                                                $sid = $station['id'];
                                                $sname = $station['name'];
                                                $r = "<form action=\"update_station.php\" method=\"post\" autocomplete=\"off\">";
                                                $r .= csrf_token_tag();
                                                $r .= "<input type=\"hidden\" name=\"id\" value=\"".$sid."\" />";
                                                $r .= "<table class=\"detail2\"><col style=\"width: 200px;\"><col style=\"width: 400px;\"><tbody>";
                                                $r .= "<tr class=\"parent1\"><td>Station Name: <span class=\"colored\">*</span></td><td><input type=\"text\" name=\"station_name\" maxlength=\"30\" value=\"".$sname."\" required autofocus/></td></tr>";
                                                $r .= "<tr  class=\"parent1\"><td colspan=\"2\"><input type=\"submit\" name=\"submit\" value=\"Update\" /></td></tr></tbody></table></form>";
                                                echo $r;
                                            }
                                            
                                        ?>
                                        
                                            
                                           
                                            
                                    </div>
                                </article>
			</div>
		
		</section>
<?php require_once('functions/footer.php');?>