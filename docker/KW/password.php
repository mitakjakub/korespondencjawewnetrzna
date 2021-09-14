<?php
	include("include/config.php");
	session_start();
	include("include/if.php");
$error="";
	if($_SERVER["REQUEST_METHOD"] == "POST") {
			{
				if ($_POST['HASLO'] == $_POST['HASLO1']) {
					
					$password = password_hash($_POST['HASLO'], PASSWORD_DEFAULT);
					$sql1 = "UPDATE Pracownik SET password = '$password' WHERE id = '$_SESSION[userid]'";
					$result1 = mysqli_query($conn,$sql1);
					$error = "Dokonano prawidłowej zmiany obecnego hasła na: $_POST[HASLO]";
				}
				else {
					$error = "Podane hasła nie pasują do siebie!";
				}
			}
	}
echo '
<html>
<head>
	<link href="style.css" rel=\'stylesheet\' media="all">
	<meta charset="UTF-8">
    <title>Korespondencja wewnętrzna :: Zmiana hasła operatora</title>
</head>
<body class="gradient">
    <div align = "center">';
include_once 'include/topmenu.php';			
echo '
			<br><br>
         <div class="card2" style="width: 550px;">      
			<div class="red_header2">
				<div class="textshadow"><br>
					Zmiana hasła '. $_SESSION['dbusername']. '<br><br>
				</div>
			</div>
			<div class="container2"><br><br>
            <form action = "" method = "post">
			<center>
			<table class="a1">
			<center>
			<th style="border-radius:8px">Wprowadź nowe hasło:</th>
			<tr>					
				<td><input type = "password" name = "HASLO" autocomplete="off" placeholder="po raz pierwszy..."/></td>
			</tr>
			<tr>
				<td><center><input type = "password" name = "HASLO1" autocomplete="off" placeholder="po raz drugi..."/></td>
			</tr>
			<tr>
				<td class="a1"><center><input type = "submit" value = "Zmień hasło"/></td>
			</tr>
			</table>
			</form>
			<br>
            <div style = "font-size:11px; color:yellow; margin-top:5px">'.$error.'</div>
            <br>
			</div>
   </body>
</html>
';
?>
