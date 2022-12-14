<?php
function clear_session($username, $password, $verbose) {
	$data="username=$username&password=$password";

	$ch=curl_init('https://cs4743.professorvaladez.com/api/clear_session');

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'content-type: application/x-www-form-urlencoded',
		'content-length: ' . strlen($data)));

	$time_start = microtime(true);
	$result = curl_exec($ch);
	$time_end = microtime(true);
	$execution_time = ($time_end - $time_start)/60;
	curl_close($ch);

	$cinfo=json_decode($result, true);

	if($verbose == true) {
		if($cinfo[0]=="Status: OK") {
			echo "\r\nSession Cleared Successfully!\r\n";
			echo "SID: $cinfo[2]\r\n";
			echo "Clear Session Execution Time: $execution_time\r\n";
		} else {
			echo $cinfo[0];
			echo "\r\n";
			echo $cinfo[1];
			echo "\r\n";
			echo $cinfo[2];
			echo "\r\n";
		}
	}

	return $cinfo;
}

function create_session($username, $password, $verbose) {
	$data="username=$username&password=$password";

	$ch=curl_init('https://cs4743.professorvaladez.com/api/create_session');

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'content-type: application/x-www-form-urlencoded',
		'content-length: ' . strlen($data)));

	$time_start = microtime(true);
	$result = curl_exec($ch);
	$time_end = microtime(true);
	$execution_time = ($time_end - $time_start)/60;
	curl_close($ch);

	$cinfo=json_decode($result, true);

	if($verbose == true) {
		if($cinfo[0] == "Status: OK" && $cinfo[1] == "MSG: Session Created") {
			echo "\r\nSession Created Successfully!\r\n";
			echo "SID: $cinfo[2]\r\n";
			echo "Create Session Execution Time: $execution_time\r\n";
		} else {
			echo $cinfo[0];
			echo "\r\n";
			echo $cinfo[1];
			echo "\r\n";
			echo $cinfo[2];
			echo "\r\n";
		}
	}

	return $cinfo;
}

function close_session($sid, $uid, $verbose) {
	$data="sid=$sid&uid=$uid";

	$ch=curl_init('https://cs4743.professorvaladez.com/api/close_session');

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'content-type: application/x-www-form-urlencoded',
		'content-length: ' . strlen($data)));

	$time_start = microtime(true);
	$result = curl_exec($ch);
	$time_end = microtime(true);
	$execution_time = ($time_end - $time_start)/60;
	curl_close($ch);

	$cinfo=json_decode($result, true);

	if($verbose == true) {
		if($cinfo[0] == "Status: OK") {
			echo "\r\nSession Closed Successfully!\r\n";
			echo "SID: $sid\r\n";
			echo "Close Session Execution Time: $execution_time\r\n";
		} else {
			echo $cinfo[0];
			echo "\r\n";
			echo $cinfo[1];
			echo "\r\n";
			echo $cinfo[2];
			echo "\r\n";
		}
	}

	return $cinfo;
}

function query_files($sid, $uid, $verbose) {
	$data="sid=$sid&uid=$uid";

	$ch=curl_init('https://cs4743.professorvaladez.com/api/query_files');

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'content-type: application/x-www-form-urlencoded',
		'content-length: ' . strlen($data)));

	$time_start = microtime(true);
	$result = curl_exec($ch);
	$time_end = microtime(true);
	$execution_time = ($time_end - $time_start)/60;
	curl_close($ch);

	$cinfo=json_decode($result, true);

	if($verbose == true) {
		if($cinfo[0] == "Status: OK") {
			echo "\r\nFiles Queried Successfully!\r\n";
			echo "SID: $sid\r\n";
			echo "File Query Execution Time: $execution_time\r\n";
			echo "\r\n";
			echo "Files Queried:";
			echo "\r\n";

			$files = explode(",", $cinfo[1]);
			$files[0] = ltrim($files[0], "MSG: ");
			foreach($files as $key => $value)
				echo "[" . $key . "] " . $value . "\r\n";
			
		} else {
			echo $cinfo[0];
			echo "\r\n";
			echo $cinfo[1];
			echo "\r\n";
			echo $cinfo[2];
			echo "\r\n";
		}
	}

	return $cinfo;

}

function request_file($sid, $uid, $fid, $verbose) {
	$data="sid=$sid&uid=$uid&fid=$fid";

	$ch=curl_init('https://cs4743.professorvaladez.com/api/request_file');

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'content-type: application/x-www-form-urlencoded',
		'content-length: ' . strlen($data)));

	$time_start = microtime(true);
	$result = curl_exec($ch);
	$time_end = microtime(true);
	$execution_time = ($time_end - $time_start)/60;
	curl_close($ch);

	$file_pointer = fopen("/var/www/html/received/$fid", "wb");
	fwrite($file_pointer, $result);
	fclose($file_pointer);

	if($verbose == true)
		echo "$fid written to file system\r\n";
}
?>
