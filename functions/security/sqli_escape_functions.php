<?php

function sql_prep($string) {
	global $database;
	if($database) {
		return mysqli_real_escape_string($database, $string);
	} else {
	 	return addslashes($string);
	}
}

?>
