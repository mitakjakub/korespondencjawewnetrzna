<?php
	session_start();
	include("include/config.php");
	session_unset();
	session_reset();
	session_destroy();
	header("location: login.php");
	die("Redirecting to: login.php");
?>
