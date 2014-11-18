<?php

function confirm_query($result_set) {
    if (!$result_set) {
        die("Database query failed: " . mysql_error());
    }
}

function redirect_to($new_location) {
    header("Location: ".$new_location);
    exit;
}

function find_user($username,$hashed_password){
    global $connection;
    $query = "SELECT id, username, access_level ";
    $query .= "FROM users ";
    $query .= "WHERE username = '{$username}' ";
    $query .= "AND hashed_password = '{$hashed_password}' ";
    $query .= "LIMIT 1";
    $result_set = mysql_query($query);
    if (mysql_num_rows($result_set) == 1){
        $r = mysql_fetch_array($result_set);
        return $r;
    } else{
        return false;
    }
}

function find_user_for_token($username){
    global $connection;
    $query = "SELECT id,token,email,token ";
    $query .= "FROM users ";
    $query .= "WHERE username = '{$username}' ";
    $query .= "LIMIT 1";
    $result_set = mysql_query($query);
    if (mysql_num_rows($result_set) == 1){
        $r = mysql_fetch_array($result_set);
        return $r;
    } else{
        return false;
    }
}

function find_user_by_token($token){
    global $connection;
    $query = "SELECT id,username ";
    $query .= "FROM users ";
    $query .= "WHERE token = '{$token}' ";
    $query .= "LIMIT 1";
    $result_set = mysql_query($query);
    if (mysql_num_rows($result_set) == 1){
        $r = mysql_fetch_array($result_set);
        return $r;
    } else{
        return false;
    }
}

function update_user_token($username, $token_value){
    global $connection;
    $query = "UPDATE users ";
    $query .= "SET token = '{$token_value}' ";
    $query .= "WHERE username = '{$username}'";
    $result = mysql_query($query);
    return true;
}

function update_user_password($id, $hashed_password){
    global $connection;
    $query = "UPDATE users ";
    $query .= "SET hashed_password = '{$hashed_password}' ";
    $query .= "WHERE id = {$id}";
    $result = mysql_query($query);
    return true;
}


function find_user_failed_logins($username){
    global $connection;
    $query = "SELECT id ,count ,last_time ";
    $query .= "FROM failed_logins ";
    $query .= "WHERE username = '{$username}' ";
    $query .= "LIMIT 1";
    $result_set = mysql_query($query);
    if (mysql_num_rows($result_set) == 1){
        $r = mysql_fetch_array($result_set);
        return $r;
    } else{
        return false;
    }
}

function add_failed_logins($username,$count,$last_time){
    global $connection;
    $query = "INSERT INTO failed_logins ";
    $query .= "(username, count, last_time) ";
    $query .= "VALUES ('{$username}', {$count}, {$last_time})";
    $result = mysql_query($query, $connection);
    return true;
}

function update_record_in_failed_logins($id, $count, $last_time){
    global $connection;
    $query = "UPDATE failed_logins ";
    $query .= "SET count = {$count}, last_time= {$last_time} ";
    $query .= "WHERE id = {$id}";
    $result = mysql_query($query, $connection);
    return true;
}

function find_one_in_blacklist($ip){
    global $connection;
    $query = "SELECT * ";
    $query .= "FROM blacklist ";
    $query .= "WHERE ip = '{$ip}' ";
    $query .= "LIMIT 1";
    $result = mysql_query($query);
    confirm_query($result);
    if (mysql_num_rows($result) == 1){
        return true;
    } else{
        return false;
    }
}

function add_record_to_blacklist($ip){
    global $connection;
    $query = "INSERT INTO blacklist ";
    $query .= "(ip) ";
    $query .= "VALUES ('{$ip}')";
    $result = mysql_query($query, $connection);
    confirm_query($result);
    return true;
}

function stations_list(){
    $a = array();
    global $connection;
    $query = "SELECT name ";
    $query .= "FROM stations";
    $result = mysql_query($query, $connection);
    confirm_query($result);
    while($row = mysql_fetch_array($result)){
        array_push($a, $row['name']);
    }
    return $a;
}

function trains_list(){
    $a = array();
    global $connection;
    $query = "SELECT name ";
    $query .= "FROM trains";
    $result = mysql_query($query, $connection);
    confirm_query($result);
    while($row = mysql_fetch_array($result)){
        array_push($a, $row['name']);
    }
    return $a;
}

function users_list(){
    $a = array();
    global $connection;
    $query = "SELECT username ";
    $query .= "FROM users";
    $result = mysql_query($query, $connection);
    confirm_query($result);
    while($row = mysql_fetch_array($result)){
        array_push($a, $row['username']);
    }
    return $a;
}

function tracker($d_s_r ,$a_s_r){
        $track = array();
        $track1 = array();
        $track2 = array();
        $track3 = array();
        $graph = array(1 => array(3,0,2), 2 =>array(1,0,0), 3 =>array(4,1,0), 4=>array(5,3,0),  5=>array(0,4,7),
                    6=>array(7,0,0), 7=>array(5,6,8), 8 =>array(7,0,14), 9=>array(14,0,10),  10=>array(9,0,13),
                    11 => array(12,0,0), 12 =>array(13,11,0), 13 =>array(10,12,0), 14=>array(8,9,15),  15=>array(14,0,16),
                    16=>array(15,0,0)
                    );
        $found = false;
        $c = 5;
        array_unshift($track1, $c);
        while(!$found){
            if($d_s_r > $c){
                $c = $graph[$c][2];
                array_unshift($track1, $c);
            } elseif($d_s_r < $c){
                $c = $graph[$c][1];
                array_unshift($track1, $c);
            } else{
                break;
            }
        }
        $c = 5;
        array_unshift($track2, $c);
        while(!$found){
            if($a_s_r > $c){
                $c = $graph[$c][2];
                array_push($track2, $c);
            } elseif($a_s_r < $c){
                $c = $graph[$c][1];
                array_push($track2, $c);
            } else{
                break;
            }
        }
        $c1 = array_diff($track1, $track2);
        $e1 = array_diff($track2, $track1);
        $d1 = array_intersect($track1, $track2);
        array_push($c1, array_shift($d1));
        $f = array_merge($c1, $e1);

    return $f;
    }
    
//    function selected_trains_for_station_no_and_depart_time($station_no,$time){
//        global $connection;
//        $query = "SELECT * ";
//        $query .= "FROM stops ";
//        $query .= "WHERE station_no={$station_no} ";
//        $query .= "AND depart_time > {$time} ";
//        $query .= "ORDER BY arrive_time ASC";
//        $result = mysql_query($query, $connection);
//        confirm_query($result);
//        return $result;
//    }
    
    function selected_trains_for_station_no_and_depart_time($station_no,$time,$a,$b){
        global $connection;
        $maxtime = $time+120;
        $query = "SELECT s.train_no as train_no, s.station_no as station_no, s.arrive_time as arrive_time, s.depart_time as depart_time ";
        $query .= "FROM stops AS s ";
        $query .= "JOIN trains AS t ";
        $query .= "ON s.train_no = t.id ";
        $query .= "WHERE s.station_no={$station_no} ";
        $query .= "AND s.depart_time > {$time} ";
        $query .= "AND s.depart_time < {$maxtime} ";
        if($b > 0){
            $query .= "AND t.type = {$b} ";
        }
        if($a == 1){
            $query .= "AND t.first_class = 1 ";
        } elseif($a == 2){
            $query .= "AND t.second_class = 1 ";
        } elseif($a == 3){
            $query .= "AND t.third_class = 1 ";
        }
        $query .= "ORDER BY s.arrive_time ASC";
        $result = mysql_query($query, $connection);
        confirm_query($result);
        return $result;
    }
    
    function all_trains_for_station_no_and_depart_time($station_no,$time,$maxtime,$a,$b){
        global $connection;
        $query = "SELECT s.train_no as train_no, s.station_no as station_no, s.arrive_time as arrive_time, s.depart_time as depart_time ";
        $query .= "FROM stops AS s ";
        $query .= "JOIN trains AS t ";
        $query .= "ON s.train_no = t.id ";
        $query .= "WHERE s.station_no={$station_no} ";
        $query .= "AND s.depart_time > {$time} ";
        $query .= "AND s.depart_time < {$maxtime} ";
        if($b > 0){
            $query .= "AND t.type = {$b} ";
        }
        if($a == 1){
            $query .= "AND t.first_class = 1 ";
        } elseif($a == 2){
            $query .= "AND t.second_class = 1 ";
        } elseif($a == 3){
            $query .= "AND t.third_class = 1 ";
        }
        $query .= "ORDER BY s.arrive_time ASC";
        $result = mysql_query($query, $connection);
        confirm_query($result);
        return $result;
    }
    
    function next_station($train_no, $depart_time){
        global $connection;
        $query = "SELECT * ";
        $query .= "FROM stops " ;
        $query .= "WHERE train_no={$train_no} ";
        $query .= "AND arrive_time > {$depart_time} " ;
        $query .= "ORDER BY arrive_time ASC ";
        $query .= "LIMIT 1" ;
        $result = mysql_query($query, $connection);
        confirm_query($result);
        return $result;
    }

        function details_for_station_no_and_train_no($station_no,$train_no){
        global $connection;
        $query = "SELECT * ";
        $query .= "FROM stops ";
        $query .= "WHERE station_no={$station_no} ";
        $query .= "AND train_no = {$train_no} ";
        $query .= "LIMIT 1";
        $result = mysql_query($query, $connection);
        confirm_query($result);
        return $result;
    }
    
    function station_for_no($id){
        global $connection;
        $query = "SELECT * ";
        $query .= "FROM stations ";
        $query .= "WHERE id={$id} ";
        $query .= "LIMIT 1";
        $result = mysql_query($query, $connection);
        confirm_query($result);
        if (mysql_num_rows($result) == 1){
            return $result;
        } else{
            return false;
        }
    }
    
    function stationid_for_name($name){
        global $connection;
        $query = "SELECT * ";
        $query .= "FROM stations ";
        $query .= "WHERE name='{$name}' ";
        $query .= "LIMIT 1";
        $result = mysql_query($query, $connection);
        confirm_query($result);
        if (mysql_num_rows($result) == 1){
            return mysql_fetch_array($result);
        } else{
            return false;
        }
    }
    
    function userid_for_name($username){
        global $connection;
        $query = "SELECT id,username,email,access_level ";
        $query .= "FROM users ";
        $query .= "WHERE username='{$username}' ";
        $query .= "LIMIT 1";
        $result = mysql_query($query, $connection);
        confirm_query($result);
        if (mysql_num_rows($result) == 1){
            return mysql_fetch_array($result);
        } else{
            return false;
        }
    }
        
    function trainid_for_name($name){
        global $connection;
        $query = "SELECT * ";
        $query .= "FROM trains ";
        $query .= "WHERE name='{$name}' ";
        $query .= "LIMIT 1";
        $result = mysql_query($query, $connection);
        confirm_query($result);
        if (mysql_num_rows($result) == 1){
            return mysql_fetch_array($result);
        } else{
            return false;
        }
    }  
    
    function train_for_no($id){
        global $connection;
        $query = "SELECT * ";
        $query .= "FROM trains ";
        $query .= "WHERE id='{$id}' ";
        $query .= "LIMIT 1";
        $result = mysql_query($query, $connection);
        confirm_query($result);
        if (mysql_num_rows($result) == 1){
            return $result;
        } else{
            return false;
        }
    }  
    function int_to_time($t){
    $h = floor($t/60);
    $min = $t % 60;
    $r = "";
    if($h > 12){
        if($h < 22){
            if($min < 10){
                $r .= "0".($h-12).":0".$min." PM";
            } else{
                $r .= "0".($h-12).":".$min." PM";
            }
        } else{
            if($min < 10){
                $r .= ($h-12).":0".$min." AM";
            } else{
                $r .= ($h-12).":".$min." AM";
            }
        }
    } else{
        if($h < 10){
            if($min < 10){
                $r .= "0".$h.":0".$min." AM";
            } else{
                $r .= "0".$h.":".$min." AM";
            }
        } else{
            if($min < 10){
                $r .= $h.":0".$min." AM";
            } else{
                $r .= $h.":".$min." AM";
            }
        }
    }
    return $r;
}

function int_to_timet($t){
    $h = floor($t/60);
    $min = $t % 60;
    $r = "";
    if($h > 12){
        if($h < 22){
            if($min < 10){
                $r .= "0".($h-12)." : 0".$min." : PM";
            } else{
                $r .= "0".($h-12)." : ".$min." : PM";
            }
        } else{
            if($min < 10){
                $r .= ($h-12)." : 0".$min." : AM";
            } else{
                $r .= ($h-12)." : ".$min." : AM";
            }
        }
    } else{
        if($h < 10){
            if($min < 10){
                $r .= "0".$h." : 0".$min." : AM";
            } else{
                $r .= "0".$h." : ".$min." : AM";
            }
        } else{
            if($min < 10){
                $r .= $h." : 0".$min." : AM";
            } else{
                $r .= $h." : ".$min." : AM";
            }
        }
    }
    return $r;
}

function duration($t1,$t2){
    $t = $t1 - $t2;
    $h = floor($t/60);
    $min = $t % 60;
    $r = $h."hr".$min;
    return $r;
}

function time_to_int($t){
    $a = (int)substr($t, 0, 2);
    $b = (int)substr($t, 5, 2);
    $c = substr($t, 10, 2);
    if($c == 'PM'){
        $v = (($a+12)*60)+$b;
        return $v;
    } else{
        $v = ($a*60)+$b;
        return $v;
    }
}

function type_con($t){
    if($t == 1){
        return "Express";
    } elseif($t == 2){
        return "Slow";
    } elseif($t == 3){
        return "Inter City";
    }
}

    function ticket_prices($ds, $asn){
        global $connection;
        $query = "SELECT fc, sc, tc ";
        $query .= "FROM tickets " ;
        $query .= "WHERE ds={$ds} ";
        $query .= "AND asn={$asn} " ;
        $result = mysql_query($query, $connection);
        confirm_query($result);
        if(mysql_num_rows($result) == 1){
            return mysql_fetch_array($result);
        } else{
            return False;
        }
    }
    
        function select_stop($tn, $sn){
        global $connection;
        $query = "SELECT * ";
        $query .= "FROM stops " ;
        $query .= "WHERE train_no={$tn} ";
        $query .= "AND station_no={$sn} " ;
        $result = mysql_query($query, $connection);
        confirm_query($result);
        if(mysql_num_rows($result) == 1){
            return mysql_fetch_array($result);
        } else{
            return False;
        }
    }

?>

