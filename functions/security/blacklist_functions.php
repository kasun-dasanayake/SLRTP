<?php

function is_blacklisted_ip($ip) {
	$blacklisted_ip = find_one_in_blacklist($ip);
	return $blacklisted_ip;
}

function block_blacklisted_ips() {
	$request_ip = $_SERVER['REMOTE_ADDR'];
	if(isset($request_ip) && is_blacklisted_ip($request_ip)) {
		die("Request blocked");
	}
}

function add_ip_to_blacklist($ip) {
	add_record_to_blacklist($ip);
	return true;
}

?>
