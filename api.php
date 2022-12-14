<?php
include dirname(__FILE__) . "/api_tools.php";
include dirname(__FILE__) . "/db_tools.php";

$username = "agh002";
$password = "wZpTPzWKdRNF9";

$verbose = true;

if(count($argv) > 1 && $argv[1] == "clear")
	clear_session($username, $password, $verbose);

echo "-----------------------  " . date("l   Y-m-d") . "  -----------------------\r\n";

$content_info = create_session($username, $password, $verbose);

if($content_info[0] == "Status: OK" && $content_info[1] == "MSG: Session Created") {
	$session_id = $content_info[2];
	$content_info = query_files($session_id, $username, $verbose);
	$files = explode(",", $content_info[1]);

	$mysqli = connect_to_database("localhost", "webuser", "simple", "document_system");

	foreach($files as $file_path) {
		$path_parts = explode("/", $file_path);
		request_file($session_id, $username, $path_parts[4], $verbose);
		record_file($mysqli, $file_path);
	}

	close_session($session_id, $username, $verbose);
}
?>
