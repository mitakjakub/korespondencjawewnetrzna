<?php
include("include/config.php");
session_start();
$_NEWPOST = array_map("strip_tags", $_POST);


#print_r($_NEWPOST);

if(empty($_NEWPOST['uwagi_new'])) {
	$_NEWPOST['uwagi_new'] = 'NULL';
}
else {
	$_NEWPOST['uwagi_new'] = "'".$_NEWPOST['uwagi_new']."'";
}

if(empty($_NEWPOST['uwagi_old'])) {
	$_NEWPOST['uwagi_old'] = 'NULL';
}
else {
	$_NEWPOST['uwagi_old'] = "'".$_NEWPOST['uwagi_old']."'";
}

if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

else {
	mysqli_query($conn, 'SET NAMES utf8');
	
	$sql = '
	UPDATE Pismo SET
	numer = "'.$_NEWPOST['numer'].'",
	symbol = "'.$_NEWPOST['symbol'].'",
	tresc = "'.$_NEWPOST['tresc'].'",
	uwagi = '.$_NEWPOST['uwagi_new'].',
	kierunek = "'.$_NEWPOST['kierunek'].'",
	nadawca_id = "'.$_NEWPOST['nadawca_id'].'"
	WHERE ID = "'.$_NEWPOST['id'].'";
	';
	$zmiany = '
	INSERT INTO Pismo_zmiany (
								tresc_new, 
								tresc_old, 
								numer_new, 
								numer_old, 
								symbol_new, 
								symbol_old, 
								uwagi_new, 
								uwagi_old, 
								nadawca_id_new, 
								nadawca_id_old, 
								pracownik_id, 
								pismo_id, 
								kierunek_old, 
								kierunek_new) 
	VALUES 
					(
								"'.$_NEWPOST['tresc'].'", 
								"'.$_NEWPOST['tresc_old'].'",
								"'.$_NEWPOST['numer'].'", 
								"'.$_NEWPOST['numer_old'].'",
								"'.$_NEWPOST['symbol'].'", 
								"'.$_NEWPOST['symbol_old'].'",
								'.$_NEWPOST['uwagi_new'].', 
								'.$_NEWPOST['uwagi_old'].', 
								"'.$_NEWPOST['nadawca_id'].'", 
								"'.$_NEWPOST['nadawca_id_old'].'", 
								"'.$_SESSION['userid'].'", 
								"'.$_NEWPOST['id'].'", 
								"'.$_NEWPOST['kierunek_old'].'", 
								"'.$_NEWPOST['kierunek'].'");';
	
	if (mysqli_query($conn, $sql)) 
	{
		mysqli_query($conn, $zmiany);
		header('Location: szukaj.php');
		die();
	} 
	else {
		echo "Błąd.";
	} 

} 
mysqli_close($conn);
?>
