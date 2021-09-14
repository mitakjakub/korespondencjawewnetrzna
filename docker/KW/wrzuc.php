<?php
include("include/config.php");
session_start();
include("include/if.php");

if(empty($_POST['password']) || empty($_POST['username']) || empty($_POST['imie']) || empty($_POST['komorg_id']) || empty($_POST['nazwisko'])) {
	$leerror = "<table><th>Niewłaściwe/puste dane formularza wejściowego. Żądanie anulowano.</th></table>";
	$_SESSION['leerror'] = $leerror;
	header("Location: error.php");
}
	
else {
	if (strlen($_POST['username']) < 8) {
	$leerror = "<table><th>Długość loginu musi wynosić przynajmniej <b>osiem</b> znaków!</th></table>";
	$_SESSION['leerror'] = $leerror;
	header("Location: error.php");
	}
	
else {
	$hashedpsswd = password_hash("$_POST[password]", PASSWORD_DEFAULT);
	$sql = "INSERT INTO Pracownik (Imie, Nazwisko, komorg_id, username, password) VALUES 
	('$_POST[imie]','$_POST[nazwisko]','$_POST[komorg_id]','$_POST[username]','$hashedpsswd')";
	if (mysqli_query($conn, $sql)) {
		$imie=$_POST['imie'];
		$nazwisko=$_POST['nazwisko'];
		$komorg_id=$_POST['komorg_id'];
		$username=$_POST['username'];
		header ("Location: pracownik.php");
		die();
		} 
	else {
	$leerror = "<table><th>Błąd wykonania polecenia. Sorki.</th></table>";
	$_SESSION['leerror'] = $leerror;
	header("Location: error.php");
		} 
	} 
}
mysqli_close($conn);
?>
