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
            $query = "INSERT INTO stops (
                                    train_no, station_no, arrive_time, depart_time
                            ) VALUES (
                                    {$train_id}, {$station_id}, {$arrive_time}, {$depart_time}
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
						<h1 class="page-title">Add New Stop</h1>
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
                                    <form action="new_stop.php" method="post" autocomplete="off">
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
                                            <td>Station Name: <span class="colored">*</span></td>
                                            <td><input  list="browsers1" type="text" name="station_name" maxlength="30" value="" required autofocus/></td>
                                        </tr>
                                        <tr class="parent1">
                                            <td>Arrive Time: <span class="colored">*</span></td>
                                            <td><input type="text" name="arrive_time" value="" id="a" required autofocus/></td>
                                        </tr>
                                        <tr class="parent1">
                                            <td>Depart Time: <span class="colored">*</span></td>
                                            <td><input type="text" name="depart_time" value="" id="a" required autofocus/></td>
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