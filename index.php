<?php require_once("initialize.php"); ?>
<?php require_once('functions/header.php');?>
<?php require_once("planner.php"); ?>
<?php

block_blacklisted_ips();

$message = "";
$result = array();

if(request_is_post() && request_is_same_domain()) {
    
    if(!csrf_token_is_valid() || !csrf_token_is_recent()) {
        $message = "Sorry, request was not valid.";
    } else {
        $depart_station = sql_prep($_POST['depart_station']);
        $arrive_station = sql_prep($_POST['arrive_station']);
        $dtime = time_to_int($_POST['dtime']);
        $atime = time_to_int($_POST['atime']);
        $type = $_POST['types'];
        $clz = $_POST['clz'];
        if($dtime == $atime){
            $today = getdate();
            $dtime = ($today['hours'] + 3)*60 + $today['minutes'] + 30;
            $atime = 1440;
        }
    
        if(has_exclusion_from($depart_station, stations_list()) || has_exclusion_from($depart_station, stations_list())) {
            $message = "Stations must be valid.";
        } else {
            $query1 = "SELECT id ";
            $query1 .= "FROM stations " ;
            $query1 .=  "WHERE name='{$depart_station}'";
            $result1 = mysql_query($query1, $connection);
            $query2 = "SELECT id ";
            $query2 .= "FROM stations " ;
            $query2 .=  "WHERE name='{$arrive_station}'";
            $result2 = mysql_query($query2, $connection);
            $r1 = mysql_fetch_array($result1);
            $r2 = mysql_fetch_array($result2);
            $result = array($r1['id'],$r2['id'],$dtime,$atime,$clz,$type);
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
                                <h1 class="page-title">Railway Travel Planner</h1>
                        </div>
                        <!-- / PAGE TITLE -->

                </div>

        </header>
        <!-- / INTRO -->

        <div class="container">

                <!-- PAGE DESCRIPTION -->
                <div class="page-description">
                        <h1>Plan Your Journey.</h1>
                        <hr>
                        <p>pick a plan that best fits your needs</p>
                </div>

                <article>
                    <div>

                    <?php
                        if($message != "") {
                            $u = "<div class=\"error-box\"><div class=\"message-box\">
                                  <p><strong>Error!</strong> ". h($message) ."</p></div></div>";
                            echo $u;
                      }
                    ?>
                        
                    <form action="index.php" method="post" autocomplete="off">
                        <?php echo csrf_token_tag(); ?>
                        <table class="detail2">
                            <col style="width: 20px;">
                            <col style="width: 180px;">
                            <col style="width: 400px;">
                            <tbody>
                            <tr class="parent1">
                                <td colspan="2">Depart Station: <span class="colored">*</span></td>
                                <td><input list="browsers" type="text" name="depart_station" maxlength="30" value="" required autofocus/></td>
                            </tr>
                            <tr class="parent1">
                                <td colspan="2">Arrive Station: <span class="colored">*</span></td>
                                <td><input list="browsers" type="text" name="arrive_station" maxlength="30" value="" required autofocus/></td>
                            </tr>
                            <tr class="parent1">
                                <td><div class="arrow"></div></td>
                                <td colspan="2" style="font-size: 14px; color: black;  padding-left: 1px;">Advanced Options</td>
                            </tr>
                                    <tr class="child1">
                                        <td colspan="2">Start Time: </td>
                                        <td><input type="text" name="dtime" value="" id="a"/></td>
                                    </tr><tr class="child1">
                                        <td colspan="2">End Time: </td>
                                        <td><input type="text" name="atime" value="" id="a"/></td>
                                    </tr>
                                    <tr class="child1">
                                        <td colspan="2">Train Type: </td>
                                        <td style="font-size: 130%;">
                                            <input type="radio" name="types" value="0" checked="checked"/> Any
                                            &nbsp;
                                            <input type="radio" name="types" value="1" /> Express
                                            &nbsp;
                                            <input type="radio" name="types" value="2" /> Slow
                                            &nbsp;
                                            <input type="radio" name="types" value="3" /> Inter City
                                        </td>
                                    </tr>
                                    <tr class="child1">
                                        <td colspan="2">Train Class: </td>
                                        <td style="font-size: 130%;">
                                            <input type="radio" name="clz" value="0" checked="checked"/> Any
                                            &nbsp;
                                            <input type="radio" name="clz" value="1" /> First
                                            &nbsp;
                                            <input type="radio" name="clz" value="2" /> Second
                                            &nbsp;
                                            <input type="radio" name="clz" value="3" /> Third
                                        </td>
                                    </tr>
                            <tr  class="parent1">
                                <td colspan="3"><input type="submit" name="submit" value="Result" /></td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                    </div>
                        <?php if (!empty($result)) {
                                
                                $j1 = "<div id=\"planner\" style=\"margin: 10px; border: 1px solid #CCC;\">";
                                $dsn = $result[0];
                                $asn = $result[1];
                                $dst = $result[2];
                                $mt = $result[3];
                                $a = $result[4];
                                $b = $result[5];
                                $final = planner1($dsn,$asn,$dst,$mt,$a,$b);
                                $j1 .= "<table class=\"detail\" border=\"1px\">
                    <col style=\"width: 40px;\">
                    <col style=\"width: 170px;\">
                    <col style=\"width: 170px;\">
                    <col style=\"width: 100px;\">
                    <col style=\"width: 100px;\">
                    <col style=\"width: 100px;\">
                    <col style=\"width: 18px;\">
                    <thead>
                        <tr class=\"head1\">
                        <th></th>
                            <th>Stations</th>
                            <th>".date("Y-m-d")."</th>
                            <th>Duration</th>
                            <th>Change</th>
                            <th>Messages</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>";
                                foreach ($final as $f) {
                                    $r = array_shift($f);
                                    $d_sf = mysql_fetch_array(station_for_no($r[0]));
                                    $d_tf = int_to_time($r[1]);
                                    $a_sf = mysql_fetch_array(station_for_no($r[2]));
                                    $a_tf = int_to_time($r[3]);
                                    $c = $r[5];
                                    $duration = duration($r[3],$r[1]);
                                    $j1 .= "<tr class=\"parent\" style=\"\"><td><div class=\"arrow\"></div></td><td><a href=\"station.php?no=".u($d_sf['id'])."\">".ucwords($d_sf['name'])."</a>";
                                    $j1 .=   "</br><a href=\"station.php?no=".u($a_sf['id'])."\">".ucwords($a_sf['name'])."</a></td><td colspan=\"1\">{$d_tf}</br>";
                                    $j1 .= "{$a_tf}</td><td>{$duration}</td><td>{$c}</td><td colspan=\"2\">{$c}</td></tr>";
                                    $j1 .= "<tr class=\"child\">
                            <td colspan=\"7\">
                                <table class=\"detail1\">
                                    <col style=\"width: 80px;\">
                                    <col style=\"width: 40px;\">
                                    <col style=\"width: 200px;\">
                                    <col style=\"width: 100px;\">
                                    <col style=\"width: 110px;\">
                                    <col style=\"width: 105px;\">
                                    <thead>
                                        <tr class=\"parent\" style=\"padding:5px;text-align:left;color: #666;font-size: 90%;\">
                                            <th colspan=\"2\" style=\"padding:5px;\">Time</th>
                                            <th >Station/Train</th>
                                            <th>Duration</th>
                                            <th>Facilities</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                                    $ff = array();
                                    $i = count($f[0]);
                                    while($i > 0) {
                                        $t = $f[0][count($f[0]) - $i];
                                        $t2 = mysql_fetch_array(details_for_station_no_and_train_no($t[1],$t[0]));
                                        $t3 = mysql_fetch_array(details_for_station_no_and_train_no($t[2],$t[0]));
                                        $train = mysql_fetch_array(train_for_no($t[0]));
                                        $d_s1 = mysql_fetch_array(station_for_no($t[1]));
                                        $a_s1 = mysql_fetch_array(station_for_no($t[2]));
                                        $t4 = int_to_time($t[4]);
                                        $t5 = int_to_time($t[3]);
                                        $duration1 = duration($t[4],$t[3]);
                                        $type = type_con($train['type']);
                                        $prices = ticket_prices($t[1], $t[2]);
                                        if(!empty($ff)){
                                            $r3 = int_to_time(array_pop($ff));
                                            $r4 = array_pop($ff);
                                            $j1 .= "<tr class=\"parent\" style=\"font-size: 12px;\"><td>{$r3}</br>{$t5}</td><td></td><td colspan=\"6\">".ucwords($d_s1['name'])."</td></tr>";
                                        } else{
                                            $j1 .= "<tr class=\"parent\" style=\"font-size: 12px;\"><td>{$t5}</td><td></td><td colspan=\"6\">".ucwords($d_s1['name'])."</td></tr>";
                                        }
                                        $j1 .= "<tr class=\"parent\" style=\"background: #ffffff;font-size: 11px;\"><td></td><td><img style=\"padding-right: 5px;\" src=\"images/train.png\" width=\"17px\"  height=\"17px\"></td><td style=\" padding: 20px;\"><a href=\"train.php?no=".u($train['id'])."\">".ucwords($train['name'])."</a></td><td>{$duration1} </td><td>";
                                        if($train['first_class']){
                                            $j1 .= "<img style=\"padding-right: 5px;\" src=\"images/1.png\" width=\"17px\"  height=\"17px\"> Rs.{$prices['fc']}<br/>";
                                        } if($train['second_class']){
                                            $j1 .= "<img style=\"padding-right: 5px;\" src=\"images/2.png\" width=\"17px\"  height=\"17px\"> Rs.{$prices['sc']}<br/>";
                                        } if($train['third_class']){
                                            $j1 .= "<img style=\"padding-right: 5px;\" src=\"images/3.png\" width=\"17px\"  height=\"17px\"> Rs.{$prices['tc']}<br/>";
                                        } if($train['canteen']){
                                            $j1 .= "<img style=\"padding-right: 5px;\" src=\"images/canteen.png\" width=\"15px\"  height=\"15px\">";
                                        }
                                        $j1 .= "</td><td colspan=\"2\">{$type}</td></tr>";

                                        if($i > 1){
                                            array_push($ff,$a_s1['name']);
                                            array_push($ff,$t[4]);
                                        } else{
                                           $j1 .= "<tr class=\"parent\"  style=\"font-size: 12px;\"><td>{$t4}</td><td></td><td colspan=\"6\">".ucwords($a_s1['name'])."</td></tr>"; 
                                        }

                                        $i-= 1;
                                    }
                                    $j1 .= "</tbody></table></td></tr>";
                                }
                                $j1 .= "</tbody></table>";
                                echo $j1."</div>";
                        } 
                        ?>
                </article>
                <aside id="sidebar">
                    <!-- FLICKR WIDGET -->
					<section class="widget flickr-widget clearfix">
						<h3 class="widget-title">User Guide</h3>
						<ul class="flickr-wrap"></ul>
					</section>
					<!-- / FLICKR WIDGET -->
                </aside>
        </div>

</section>

<datalist id="browsers">
    <?php 
    $list = stations_list();
    foreach ($list as $row) {
        echo "<option value=\"{$row}\">";
    }
    
    ?>
</datalist>

<?php require_once('functions/footer.php');?>