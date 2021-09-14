<?php
session_start();
include("include/config.php");
include("include/if.php");
if($_SERVER['HTTP_REFERER'] != "https://kw.local/sendmail.php")
{
	unset($_SESSION['Informacja_wysylka']); 
}


if(!isset($_SESSION['Informacja_wysylka'])) {
	$_SESSION['Informacja_wysylka'] = "Zgłoszenie zostanie przesłane do autora aplikacji<br>Odpowiedź zostanie przekazana drogą elektroniczną<br>";
}
 echo '
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
		    <link href="style.css" rel=\'stylesheet\' media="all">
			<title>Korespondencja Wewnętrzna :: Zgłoszenie</title>
		</head>	 
		<body class="gradient">';
include_once 'include/topmenu.php';			

     echo '
	<br>
	<center>
	<div class="card1" style="width: 550px">
		<div class="red_header2">
			<div class="textshadow">
				<b>Zgłoszenie</b>
				<br>
			</div>
		</div>
		<div class="container2">
			<center><br>
			<table class="a1">
				<form action="sendmail.php" method="post" id="sendmail">
				<th colspan="2" style="background-color:#333; border-radius:8px">Wypełnij poniższe pola</th>
				<tr>				
					<td class="a1" colspan="2">Treść zgłoszenia: <br><textarea rows="5" cols="60" name="tresczgloszenia" form="sendmail" required="yes" placeholder="Opisz problem [POLE WYMAGANE]" maxlength="2500"></textarea></td></tr>
					<tr>
					<td>Dodatkowe informacje:<br>
					<textarea rows="5" cols="80" name="dodatkizgloszenie" form="sendmail" autofocus placeholder="[POLE OPCJONALNE]" maxlength="2500"></textarea></td>
					</tr>
					<td class="a1">Rodzaj zgłoszenia:<br>
					<select name="kategoria" >
							<option value="Błąd">Błąd aplikacji</option>
							<option value="Pomoc">Pomoc w obsłudze aplikacji</option>
							<option value="Zmiana w aplikacji">Postulat zmiany w aplikacji</option>
							<option value="Inne">Inne</option>
					</select></td>
			</table>
	
				<br>
						<input type="submit" value="Prześlij zgłoszenie">
			<br><br>		</form>
	</div></div></div><br>
			<br>
	        <center>
			<div class="card1" style="width: 550px">

        	    <div class="container2">
	                <div class="textshadow">
						<center>
						<table id="lista1" width="100%"><p align="center">
							<tr>'.$_SESSION['Informacja_wysylka'].'
							</tr>
					</div></div></div></div><br>	
</body>
</html>';
$conn->close();

?>

