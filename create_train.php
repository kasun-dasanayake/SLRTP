<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	$errors = array();
	
	// Form Validation
	$required_fields = array('name', 'type', 'first_class', 'second_class', 'third_class', 'canteen');
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
		redirect_to("new_train.php");
	}
?>
<?php
	$name = mysql_prep($_POST['name']);
	$type = mysql_prep($_POST['type']);
	$first_class = mysql_prep($_POST['first_class']);
	$second_class = mysql_prep($_POST['second_class']);
	$third_class = mysql_prep($_POST['third_class']);
	$canteen = mysql_prep($_POST['canteen']);
?>
<?php
	$query = "INSERT INTO trains (
				name, type, first_class, second_class, third_class, canteen
			) VALUES (
				'{$name}', '{$type}', {$first_class}, {$second_class}, {$third_class}, {$canteen}
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