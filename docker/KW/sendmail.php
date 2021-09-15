<?php
session_start();
include("include/config.php");
include("include/if.php");
$_NEWPOST = array_map("strip_tags", $_POST);
function GOTOHELL() 
{
	$to  = getenv('KW_EMAIL_SUPPORT'); 
	$subject = 'Zgłoszenie błędu / usprawnienia do aplikacji od użytkownika ' .$_SESSION['dbusername']. '';
	$message = '
	<html>
	<head><title>Zgłoszenie błędu występującego w aplikacji</title></head>
	<style media="screen" type="text/css">
	body {
	height: 100%;
	color: white;
	margin: 0;
	font-size: 10px;
	background-repeat: no-repeat;
	background-attachment: fixed;
	background-position: right bottom; 
	font-family: Tahoma, Arial, Helvetica, sans-serif;
	}
	table {
	font-size: 11px;
	padding: 2px;
	border: 1px solid dimgrey;
	background-color: grey;
	border-radius: 10px 10px 10px 10px;
	}
	</style>
	<body>
		<p><font color="black">W aplikacji <b>Korespondencja Wewnętrzna</b> wystąpił błąd / wymagane jest usprawnienie.</font></p>
		<p><font color="black">Poniżej znajdują się informacje zgromadzone przy pomocy formularza dostępnego w aplikacji</font></p><br>
	<table><tr>
			<th>Pracownik dokonujący zgłoszenia:</th><th>Treść zgłoszenia</th><th>Dodatkowe informacje</th><th>Waga błędu</th></tr>
			<tr><td>'.$_SESSION['dbusername'].'</td>
			<td>'. $_POST['tresczgloszenia'].'</td>
			<td>'. $_POST['dodatkizgloszenie'].'</td>
			<td>'. $_POST['kategoria'].'</td>
	</table></body></html>';
	$_SESSION['Informacja_wysylka'] = "<b><font color=\"yellow\">Zgłoszenie zostało przekazane do autora</font></b>";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	$headers .= 'From: "Korespondencja Wewnętrzna"<'. getenv('KW_EMAIL_SUPPORT') .'>' . "\r\n";
	mail($to, $subject, $message, $headers);
	header("Location: $_SERVER[HTTP_REFERER]");	
echo $message;
	
}


if($_SERVER['HTTP_REFERER'] == "https://kw.local/zgloszenie.php")
{
GOTOHELL();
}
else { 
	$leerror = "<br><br><table><th>Dostęp nie jest możliwy.<br>Wywołanie nie jest prawidłowe, ta metoda nie jest obsługiwana.<br>To nie jest błąd aplikacji.<br></th></table><br><br>";
	$_SESSION['leerror'] = $leerror;
	header("Location: error.php");
    die("" . $conn->connect_error);
}
?>
