<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	$errors = array();
	
	// Form Validation
	$required_fields = array('name');
	foreach($required_fields as $fieldname) {
		if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]) && $_POST[$fieldname] != 0)) {
			$errors[] = $fieldname;
		}
	}
	
	$fields_with_lengths = array('name' => 30);
	foreach($fields_with_lengths as $fieldname => $maxlength ) {
		if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) { $errors[] = $fieldname; }
	}
	
	if (!empty($errors)) {
		redirect_to("new_station.php");
	}
?>
<?php
	$name = mysql_prep($_POST['name']);
?>
<?php
	$query = "INSERT INTO stations (
				name
			) VALUES (
				'{$name}'
			)";
	$result = mysql_query($query, $connection);
	if ($result) {
		// Success!
		redirect_to("staff.php?msg=success");
	} else {
		// Display error message.
		echo "<p>Subject creation failed.</p>";
		echo "<p>" . mysql_error() . "</p>";
	}
?>

<?php 
    mysql_close($connection);
?>