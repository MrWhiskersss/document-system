<?php

function connect_to_database($host, $user, $password, $database) {
	$mysqli = new mysqli($host, $user, $password, $database);

	if(mysqli_connect_errno())
		die("ERROR could not connect to database: " . mysqli_connect_error());

	return $mysqli;
}

function record_file($mysqli, $file_path) {
	$path_parts = explode("/", $file_path);
	$system_path = "received/$path_parts[4]";
	$name_parts = explode("-", $path_parts[4]);

	$year = substr($name_parts[2], 0, 4);
	$month = substr($name_parts[2], 4, 2);
	$day = substr($name_parts[2], 6, 2);
	$date = $year . "-" . $month . "-" . $day;
	
	$database_entry = "Insert into `file` (`file_name`,
		`file_type`,
		`file_classification`,
		`deleted`,
		`in_use`,
		`path_real`,
		`path_presented`,
		`path_to_log`,
		`branch`,
		`date`,
		`user`) values ('$path_parts[4]',
		'pdf',
		'$name_parts[1]',
		'0',
		'0',
		'$system_path',
		'',
		'',
		'0',
		'$date',
		'$name_parts[0]')";

	$mysqli->query($database_entry) or
		die("something went wrong with $database_entry" . $dblink->error);
}
?>
