<?php
include("include/config.php");
session_start();
$_NEWPOST = array_map("strip_tags", $_POST);

if (strlen($_NEWPOST['uwagi']) > 250 or strlen($_NEWPOST['tresc']) > 250) {
		 $leerror = "<table><th>Pola tekstowe TREŚĆ i UWAGI nie mogą być dłuższe, niż 250 znaków. Błąd jest związany z nieprawidłową długością tych pól.</th></table>";
		 	 $_SESSION['leerror'] = $leerror;
		 	 header("Location: error.php");
			      die();
}


if(empty($_NEWPOST['uwagi'])) {
	$_NEWPOST['uwagi'] = 'NULL';	
}
else{
	$_NEWPOST['uwagi'] = "'".$_NEWPOST['uwagi']."'";
}

if(empty($_NEWPOST['kategoria_id'])) {
	$_NEWPOST['kategoria_id'] = 'NULL';	
}
else{
	$_NEWPOST['kategoria_id'] = "'".$_NEWPOST['kategoria_id']."'";
}
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

else {
	mysqli_query($conn, 'SET NAMES utf8');
	
	$sql = '
	INSERT INTO Pismo (numer, symbol, tresc, uwagi, nadawca_id, Pracownik_id, data_pisma, kierunek, kategoria_id) 
	VALUES (
		"'.$_NEWPOST['numer'].'", 
		"'.$_NEWPOST['symbol'].'", 
		"'.$_NEWPOST['tresc'].'", 
		'.$_NEWPOST['uwagi'].', 
		"'.$_NEWPOST['nadawca_id'].'", 
		"'.$_SESSION['userid'].'", 
		"'.$_NEWPOST['data_pisma'].'", 
		"'.$_NEWPOST['kierunek'].'",
		'.$_NEWPOST['kategoria_id'].'
	)';

	
	if (mysqli_query($conn, $sql)) {

				$_SESSION['pismoinserted'] = 'OK';
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		die();
	} 
	else {
		print_r($_NEWPOST);
		echo "\n";
		print_r($_SESSION);
	 $leerror = "<table><th>Błąd. Nie powiodło się dodanie pisma do listy.</th></table>";
			 $_SESSION['leerror'] = $leerror;
			 header("Location: error.php");
			      die();

	} 
} 
mysqli_close($conn);
?>
