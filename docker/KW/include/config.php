<?php
	define('DB_SERVER', getenv('MARIADB_SERVER'));
	define('DB_USERNAME', getenv('MARIADB_USER'));
	define('DB_PASSWORD', getenv('MARIADB_PASSWORD'));
	define('DB_DATABASE', getenv('MARIADB_DATABASE'));
	$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
	mysqli_set_charset($conn,"utf8");	
?>
