<?php
include("include/config.php");
session_start();
$_NEWPOST = array_map("strip_tags", $_POST);

if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}



else {
	mysqli_query($conn, 'SET NAMES utf8');
	
	$sql = '
	INSERT INTO nadawca (Nazwa, pracownik_id, adres, kodpocztowy, miasto, kraj, wojewodztwo) 
	VALUES ("'.mysqli_escape_string($conn, $_NEWPOST[textnadawca]).'", "'.mysqli_escape_string($conn, $_SESSION[userid]).'", "'.mysqli_escape_string($conn, $_NEWPOST[adres]).'", "'.mysqli_escape_string($conn, $_NEWPOST[kod]).'", "'.mysqli_escape_string($conn, $_NEWPOST[miasto]).'", "'.mysqli_escape_string($conn, $_NEWPOST[kraj]).'", "'.mysqli_escape_string($conn, $_NEWPOST[wojewodztwo]).'")';
	
	if (mysqli_query($conn, $sql)) {
		header("Location: nadawca.php");
		die();
	} 
	else {
	print_r($_NEWPOST);
	print_r($_SESSION);
		
	} 
} 
mysqli_close($conn);
?>
