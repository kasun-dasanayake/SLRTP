<?php

function record_failed_login($username) {
    $failed_login = find_user_failed_logins($username);
    if(!$failed_login) {
        $count = 1;
        $last_time = time();
        add_failed_logins($username,$count,$last_time);
    } else {
        $count = $failed_login['count'] + 1;
        $last_time = time();
        update_record_in_failed_logins($failed_login['id'], $count, $last_time);
    }
    return true;
}

function clear_failed_logins($username) {
    $failed_login = find_user_failed_logins($username);
    if(isset($failed_login)) {
        $count = 0;
        $last_time = time();
        update_record_in_failed_logins($failed_login['id'], $count, $last_time);
    }
    return true;
}

function throttle_failed_logins($username) {
    $throttle_at = 5;
    $blacklist_at = 10;
    $delay_in_minutes = 10;
    $delay = 60 * $delay_in_minutes;

    $failed_login = find_user_failed_logins($username);

    if(isset($failed_login) && $failed_login['count'] >= $throttle_at) {
        if($failed_login['count'] >= $blacklist_at){
            require_once("functions/blacklist_functions.php");
            $request_ip = $_SERVER['REMOTE_ADDR'];
            add_ip_to_blacklist($request_ip);
            echo "yes";
        }
        $remaining_delay = ($failed_login['last_time'] + $delay) - time();
        $remaining_delay_in_minutes = ceil($remaining_delay / 60);
        return $remaining_delay_in_minutes;
    } else {
        return 0;
    }
}

?>
