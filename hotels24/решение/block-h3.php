<?php
	include 'hotels24.php';
	$info = file_get_contents('php://input');
	$info = json_decode($info);
	$arr = from_string_to_array($string);
	$string = '<h3>'.$info->title.'</h3>'.$arr[$info->h2][$info->title];
	echo json_encode($string);
?>
