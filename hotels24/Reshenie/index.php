<html>
	<head>
		<meta charset=utf-8>
		<title>Hotels24 - Гудаков Александр</title>
		 <link rel="stylesheet" href="style.css" type="text/css" />  
	</head>
	<body>
		<?php
			include 'hotels24.php';
			
			foreach(from_string_to_array($string) as $k => $v){
				echo '<div>';
					echo '<div id = "h2" class = "h2">'.$k.'</div>';
					foreach($v as $k2 => $v2){
						if( $k2 != 'text'){
							echo '<div id = "h3" class = "h3">'.$k2.'</div>';
						}
					}
				echo '</div>';
			}
		?>
		<div id='text'></div>
		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="js/my-javascript.js" type="text/javascript"></script>
	</body>
</html>