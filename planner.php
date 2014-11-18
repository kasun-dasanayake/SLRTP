<?php require_once("initialize.php"); ?>
<?php 
$final = array();
function planner1($dsn,$asn,$dst,$mt,$a,$b){
    global $final;
    $track = tracker($dsn ,$asn);
    $trains_set = all_trains_for_station_no_and_depart_time($dsn,$dst,$mt,$a,$b);
    while($train = mysql_fetch_array($trains_set)){
        $max = 1440;
        $plans = array();
        $tn = $train['train_no'];
        $ndt = $train['depart_time'];
        $nsn = mysql_fetch_array(next_station($tn, $ndt));
        if($nsn){
            if(!(array_search($nsn['station_no'], $track))){continue;} // if nxt station > $track
            $at = $nsn['arrive_time'];
            $ns = $nsn['station_no'];
            $duration = $at - $ndt;
            $t = array_keys($track, $ns);        
            $j = array_keys($track, $dsn);
            if($ns == $asn){
                $max = $at;
                $p = array(array($dsn,$ndt,$ns,$at,$duration,0), array(array($tn,$dsn,$ns,$ndt,$at)));
                array_push($final, $p);
                continue;}
            elseif(array_search($nsn['station_no'], $track) && ($j < $t)){
                $p = array(array($dsn,$ndt,$ns,$at,$duration,0), array(array($tn,$dsn,$ns,$ndt,$at)));
                array_unshift($plans, $p);
                $p = planner2($plans,$track,$asn,$max,$a,$b);
                if(isset($p)){array_push($final, $p);}}
        }
    }
    
    return $final;
}

function planner2($plans,$track,$asn,$max,$a,$b){
    global $final;
    $bestplan = null;
    $maxc = 20;
    while(!empty($plans)){
        $m = array_pop($plans);
        $dsn = $m[0][2];
        $dst = $m[0][3];
        $trains_set = selected_trains_for_station_no_and_depart_time($dsn,$dst,$a,$b);
        while($train = mysql_fetch_array($trains_set)){
            $tn = $train['train_no'];
            $ndt = $train['depart_time'];
            $nsn = mysql_fetch_array(next_station($tn, $ndt));
            if($nsn){
                if(!(array_search($nsn['station_no'], $track))){;continue;} // if nxt station > $track
                $at = $nsn['arrive_time'];
                $ns = $nsn['station_no'];
                $duration = $at - $m[0][1];
                $t = array_keys($track, $ns);        
                $j = array_keys($track, $dsn);
                if($ns == $asn){
                    if($max<$at){continue;}
                    if($max==$at && $maxc <= $m[0][5]){continue;}
                    $max = $at;
                    $r = array_pop($m[1]);
                    if($r[0] == $tn){
                        $u = array($r[0],$r[1],$ns,$r[3],$at);
                        array_push($m[1],$u);
                        $r1 = count($m[1]) - 1;
                        $p1 = array($m[0][0],$m[0][1],$ns,$at,$duration,$r1);
                        $maxc = $r1;
                        $p = array($p1, $m[1]);
                        $bestplan = $p;
                        array_pop($m[1]);
                        array_push($m[1],$r);
                    } else{
                        array_push($m[1],$r);
                        array_push($m[1],array($tn,$dsn,$ns,$ndt,$at));
                        $r1 = count($m[1]) - 1;
                        $p1 = array($m[0][0],$m[0][1],$ns,$at,$duration,$r1);
                        $maxc = $r1;
                        $p = array($p1, $m[1]);
                        $bestplan = $p;
                        array_pop($m[1]);
                    }
                    continue;
                    }
                elseif(array_search($nsn['station_no'], $track) && ($j < $t)){
                    $r = array_pop($m[1]);
                    if($r[0] == $tn){
                        $u = array($r[0],$r[1],$ns,$r[3],$at);
                        array_push($m[1],$u);
                        $r1 = count($m[1]) - 1;
                        $p1 = array($m[0][0],$m[0][1],$ns,$at,$duration,$r1);
                        $p = array($p1, $m[1]);
                        array_unshift($plans, $p);
                        array_pop($m[1]);
                        array_push($m[1],$r);
                    } else{
                        array_push($m[1],$r);
                        array_push($m[1],array($tn,$dsn,$ns,$ndt,$at));
                        $r1 = count($m[1]) - 1;
                        $p1 = array($m[0][0],$m[0][1],$ns,$at,$duration,$r1);
                        $p = array($p1, $m[1]);
                        array_unshift($plans, $p);
                        array_pop($m[1]);
                    }
                }
            }
        }
    }
    return $bestplan;
    }
?>