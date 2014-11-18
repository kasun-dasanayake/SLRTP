<?php

function has_presence($value) {
	$trimmed_value = trim($value);
  return isset($trimmed_value) && $trimmed_value !== "";
}

function has_length($value, $options=array()) {
	if(isset($options['max']) && (strlen($value) > (int)$options['max'])) {
		return false;
	}
	if(isset($options['min']) && (strlen($value) < (int)$options['min'])) {
		return false;
	}
	if(isset($options['exact']) && (strlen($value) != (int)$options['exact'])) {
		return false;
	}
	return true;
}

function has_format_matching($value, $regex='//') {
	return preg_match($regex, $value);
}

function has_number($value, $options=array()) {
	if(!is_numeric($value)) {
		return false;
	}
	if(isset($options['max']) && ($value > (int)$options['max'])) {
		return false;
	}
	if(isset($options['min']) && ($value < (int)$options['min'])) {
		return false;
	}
	return true;
}

function has_inclusion_in($value, $set=array()) {
  return in_array($value, $set);
}

function has_exclusion_from($value, $set=array()) {
  return !in_array($value, $set);
}

?>