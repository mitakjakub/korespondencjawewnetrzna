<?php
include("include/config.php");
session_start();
include("include/if.php");

if(!isset($_NEWPOST['Eimie'])){
	$_NEWPOST['Eimie']="";
}
if(!isset($_NEWPOST['Enazwisko'])){
	$_NEWPOST['Enazwisko']="";
}
if(!isset($_NEWPOST['Ekomorg'])){
	$_NEWPOST['Ekomorg']="";
}
if(!isset($_NEWPOST['Eid'])){
	$_NEWPOST['Eid']="";
}


else {
	if(isset($_REQUEST['ZMIANA'])){
		if(strlen($_NEWPOST['Epassword']) == 0){

			$usql='
			UPDATE Pracownik SET 
			Imie = "'.$_NEWPOST['Eimie'].'", 
			Nazwisko = "'.$_NEWPOST['Enazwisko'].'",  
			komorg_id = "'.$_NEWPOST['Ekomorg'].'" 
			WHERE id = '.$_NEWPOST['Eid'].';
			';		
			mysqli_query($conn,$usql);
			header('Location: pracownik.php');
			die();
		}
		else
			$password = password_hash($_NEWPOST['Epassword'], PASSWORD_DEFAULT);
			$usql='
			UPDATE Pracownik SET 
			Imie = "'.$_NEWPOST['Eimie'].'", 
			Nazwisko = "'.$_NEWPOST['Enazwisko'].'",  
			komorg_id = "'.$_NEWPOST['Ekomorg'].'",
			password = "'.$password.'"
			WHERE id = '.$_NEWPOST['Eid'].';
			';		
			mysqli_query($conn,$usql);
			header('Location: pracownik.php');
			die();
		
	}
	else{
	
	mysqli_query($conn, 'SET NAMES utf8');
	$pracownik='SELECT id, Imie, Nazwisko, komorg_id, username from Pracownik WHERE id = "'. $_NEWPOST['Eid'].'" and username = "'. $_NEWPOST['Eusername'] .'";';
	$ppracownik = mysqli_query($conn, $pracownik);
	$pracownik_wynik = mysqli_fetch_array($ppracownik);
	
	$komorg=mysqli_query($conn,"SELECT ID, nazwa from komorg;");
	
	
echo '
<html>
<head>
	<link href="style.css" rel=\'stylesheet\' media="all">
	<meta charset="UTF-8">
    <title>Korespondencja wewnętrzna :: Edycja użytkownika '. $_NEWPOST['Eusername'].'</title>
</head>
		<body class="gradient">';
include_once 'include/topmenu.php';			
echo '
<br><center>
			<div class="card1">
				<div class="header">
					<div class="textshadow">
					Edycja użytkownika '.$pracownik_wynik['Imie'].' '.$pracownik_wynik['Nazwisko'].' 
					</div>
				</div>
        	    <div class="container2">
	                <div class="textshadow">
						<center>
						<table>
						<form method="post" action="pracownik_edycja.php">
						<tr>
							<td>Imię:</td>
							<td><input type="text" required name="Eimie" value="'.$pracownik_wynik['Imie'].'"></td>
						</tr>
						<tr>
							<td>Nazwisko:</td>
							<td><input type="text" required name="Enazwisko" value="'.$pracownik_wynik['Nazwisko'].'"></td>
						</tr>
						<tr>
							<td>Komórka org.:</td>
							<td><select name="Ekomorg">';
				while($work = mysqli_fetch_array($komorg)) 
					{ 
					echo '
							<option value="' . $work[0] . '" '.(($pracownik_wynik['komorg_id']==$work[0])?'selected="selected"':"").'>' . $work[1] .'</option>';
					};
					echo '
							</select></td>
						</tr>
							<td>Hasło:</td>
							<td><input type="password" name="Epassword" pattern=".{8,}" placeholder="wpisz min. 8 znaków!" value="" autocomplete="off"></td>
						<tr>
						<input type="hidden" name="Eid" value="'.$_NEWPOST['Eid'].'">
						<input type="hidden" name="Eusername" value="'.$_NEWPOST['Eusername'].'">
						</table>
						<input type="submit" name="ZMIANA" value="Aktualizuj!">
						<br><br>
			</body>
</html>';
}
}
$conn->close();
?>	
