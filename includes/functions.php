<?php

	function mysql_prep( $value ) {
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
		if( $new_enough_php ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}

	function redirect_to( $location = NULL ) {
		if ($location != NULL) {
			header("Location: {$location}");
			exit;
		}
	}

	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed: " . mysql_error());
		}
	}
        
        function train_details($train_no){
            global $connection;
            $query = "SELECT * ";
            $query .= "FROM trains " ;
            $query .=  "WHERE id='{$train_no}'";
            $result = mysql_query($query, $connection);
            confirm_query($result);
            return $result;
        }
        
        function stations_list(){
            global $connection;
            $query = "SELECT name ";
            $query .= "FROM stations";
            $result = mysql_query($query, $connection);
            confirm_query($result);
            return $result;
        }
        
        function station_details_id($station_no){
            global $connection;
            $query = "SELECT * ";
            $query .= "FROM stations " ;
            $query .=  "WHERE id='{$station_no}'";
            $result = mysql_query($query, $connection);
            confirm_query($result);
            return $result;
        }
        
        function station_details($station_name){
            global $connection;
            $query = "SELECT * ";
            $query .= "FROM stations " ;
            $query .=  "WHERE name='{$station_name}'";
            $result = mysql_query($query, $connection);
            confirm_query($result);
            return $result;
        }
        
        function selected_station_for_selected_train($train_no, $station_no){
            global $connection;
            $query = "SELECT * ";
            $query .= "FROM stops " ;
            $query .= "WHERE train_no={$train_no} ";
            $query .= "AND station_no={$station_no} ";
            $query .= "ORDER BY arrive_time ASC";
            $result = mysql_query($query, $connection);
            confirm_query($result);
            return $result;
        }
        
        function selected_trains_for_station_no($station_no){
            global $connection;
            $query = "SELECT * ";
            $query .= "FROM stops " ;
            $query .=  "WHERE station_no={$station_no} ";
            $query .= "ORDER BY arrive_time ASC";
            $result = mysql_query($query, $connection);
            confirm_query($result);
            return $result;
        }
        
        
        function arrive_time($train_no, $station_no){
            global $connection;
            $query = "SELECT * ";
            $query .= "FROM stops " ;
            $query .= "WHERE train_no={$train_no} ";
            $query .= "AND station_no={$station_no} " ;
            $query .= "LIMIT 1" ;
            $result = mysql_query($query, $connection);
            confirm_query($result);
            return $result;
        }
        
        function selected_trains_for_station_no_for_selected_time($station_no,$depart_time){
            global $connection;
            $query = "SELECT * ";
            $query .= "FROM stops " ;
            $query .=  "WHERE station_no={$station_no} ";
            $query .= "AND arrive_time > {$depart_time} " ;
            $query .= "ORDER BY arrive_time ASC";
            $result = mysql_query($query, $connection);
            confirm_query($result);
            return $result;
        }

?>
