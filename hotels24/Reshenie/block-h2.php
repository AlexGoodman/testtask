<?php
	include 'hotels24.php';
	$info = file_get_contents('php://input');
	$info = json_decode($info);
	$arr = from_string_to_array($string);
	$string = '<h2>'.$info->title.'</h2>';
	foreach($arr[$info->title] as $k => $v){
		if($k == 'text'){
			$string = $string.$v;
		}
		else{
			$string = $string.'<h3>'.$k.'</h3>'.$v;
		}
	}
	echo json_encode($string);
?>
