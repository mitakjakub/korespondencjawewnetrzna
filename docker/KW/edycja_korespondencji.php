<?php
include("include/config.php");
session_start();
if(isset($_SESSION['wlasciwosc']))
{
	$_POST['E_id'] = $_SESSION['wlasciwosc'];
}

unset($_SESSION['wlasciwosc']);
$nadawca = mysqli_query($conn,'SELECT ID, Nazwa FROM nadawca ORDER BY Nazwa;');
$zmiany= mysqli_query($conn, "SELECT 
	@curNumer := @curNumer + 1 as LP,
	PZ.tresc_new, 
	PZ.tresc_old, 
	PZ.symbol_new, 
	PZ.symbol_old, 
	PZ.numer_new, 
	PZ.numer_old, 
	PZ.nadawca_id_old, 
	N.Nazwa, 
	PZ.uwagi_old,
	PZ.uwagi_new,
	P.username, 
	PIS.tresc, 
	PZ.data_zmiany, 
	PZ.kierunek_old,
	PZ.kierunek_new
FROM 
	Pismo_zmiany PZ, 
	nadawca N, 
	Pracownik P, 
	Pismo PIS 
	JOIN (SELECT @curNumer := 0) as G
WHERE 
	PZ.pismo_id = $_POST[E_id] AND 
	PZ.nadawca_id_new = N.ID AND 
	P.id = PZ.pracownik_id AND 
	PIS.id = PZ.pismo_id
ORDER BY PZ.data_zmiany ASC;");


$pliki=mysqli_query($conn, "
SELECT
	PP.nazwa_pliku,
	PP.typ_pliku,
	PP.rozmiar,
	PP.id,
	PP.plik,
	P.username,
	K.skrot
from 
	Pismo_plik PP,
	Pracownik P, 
	Pismo PIS,
	komorg K
WHERE 
	PP.pismo_id = $_POST[E_id] AND 
	P.id = PP.pracownik_id AND
	PIS.id = PP.pismo_id AND
	K.ID = P.komorg_id
ORDER BY 
PP.id;
");

$pismo_dane=mysqli_query($conn, "
SELECT * FROM Pismo WHERE id = $_POST[E_id];
");

include("include/if.php");
if(!isset($_NEWPOST['E_id']))
{
	$leerror = "<table><th>Niewłaściwe odwołanie.<br>Błąd uniemożliwiający wykonanie żądania.<br>Nie można edytować nieokreślonej pozycji książki.<br>To nie jest błąd aplikacji.<br></th></table>";
	$_SESSION['leerror'] = $leerror;
	header("Location: error.php");
    die("" . $conn->connect_error);
}

echo '
<html>
<head>
	<link href="style.css" rel=\'stylesheet\' media="all">
	<meta charset="UTF-8">
    <title>Korespondencja wewnętrzna :: edycja wprowadzonej pozycji</title>
</head>
		<body class="gradient">';
include_once 'include/topmenu.php';			
echo '
<br><center>
			<div class="card1">
				<div class="header">
					<div class="textshadow">
					Edycja dodanej pozycji książki
					</div>
				</div>
        	    <div class="container2">
	                <div class="textshadow">
						<center>';					
						if(mysqli_num_rows($zmiany) > 0) {
							echo '
							<table>
							<th style="border-radius:8px; background-color: brown" colspan="15">Historia zmian pozycji</th> <tr>
							<th>LP</th>
							<th>Data zmiany</th>
							<th>Nowa treść</th>
							<th>Dawna treść</th>
							<th>Nowy symbol</th>
							<th>Dawny symbol</th>
							<th>Nowy numer</th>
							<th>Stary numer</th>
							<th>Nowy adresat</th>
							<th>Stary adresat</th>
							<th>Nowa uwaga</th>
							<th>Stara uwaga</th>
							<th>Nowy kierunek</th>
							<th>Stary kierunek</th>
							<th>Pracownik</th>
							';
							while($komorka = $zmiany->fetch_assoc()) {
							echo"<tr><td><center>"
							. $komorka['LP']. "</td><td><center>"
							. $komorka['data_zmiany'] . "</td><td>"
							. $komorka['tresc_new']. "</td><td>"
							. $komorka['tresc_old']. "</td><td>"
							. $komorka['symbol_new']. "</td><td>"
							. $komorka['symbol_old']. "</td><td>"
							. $komorka['numer_new']. "</td><td>" 
							. $komorka['numer_old']. "</td><td>"
							. $komorka['nadawca_id_old'] . "</td><td>"
							. $komorka['Nazwa'] . "</td><td>"
							. $komorka['uwagi_new']. "</td><td>" 
							. $komorka['uwagi_old']. "</td><td>"
							. $komorka['kierunek_new']. "</td><td>"
#							.(($row['kierunek_old']=='W')?'<img src="img/up.png" style="width: 13px; height: 13px; vertical-align:middle"/><mark style="background-color: lightblue; color: blue">Wychodząca</mark>':(($row['kierunek_old']=='P')?'<img src="img/down.png" style="width: 13px; height: 13px; vertical-align:middle"/><mark style="background-color: orange; font: brown">Przychodząca</mark>':''))."</td><td>"
#							.(($row['kierunek_new']=='W')?'<img src="img/up.png" style="width: 13px; height: 13px; vertical-align:middle"/><mark style="background-color: lightblue; color: blue">Wychodząca</mark>':(($row['kierunek_new']=='P')?'<img src="img/down.png" style="width: 13px; height: 13px; vertical-align:middle"/><mark style="background-color: orange; font: brown">Przychodząca</mark>':''))."</td><td>"
#							
							. $komorka['kierunek_old']. "</td><td>"
							. $komorka['username'] . "</td></tr>";
							}
							echo '</table>';
						};
if(mysqli_num_rows($pismo_dane) == 1)
{
		$ELpismo = $pismo_dane->fetch_assoc();
		$login_pracownik=mysqli_query($conn, "
		SELECT username FROM Pracownik WHERE id = $ELpismo[Pracownik_id];
		");
		$nadawca_nazwa=mysqli_query($conn, "
		SELECT Nazwa FROM nadawca where ID = $ELpismo[nadawca_id];");
		$ELpracownik = $login_pracownik->fetch_assoc();
		$ELnadawca = $nadawca_nazwa->fetch_assoc();
				echo'<br>
				
				<form action="ukorespondencja.php" method="post" id="korespondencja">
				<table class="a1">
				<th style="background-color:#333; border-radius:8px" colspan="3">Zmień wprowadzoną pozycję</th>
				<tr>
					<td class="a1"><center>
					Numer:<br><input type="number" name="numer" required min="1" value="'.$ELpismo['numer'].'"/><br>
						<input type="hidden" value="'.$ELpismo['numer'].'" name="numer_old">
					<td class="a1"><center>
					Symbol:<br><input type="text" name="symbol" required value="'.$ELpismo['symbol'].'"/></td>	
						<input type="hidden" value="'.$ELpismo['symbol'].'" name="symbol_old">
					<td class="a1"><center>
						Adresat:<br>
					<select name="nadawca_id" required>
					<option value="">&nbsp;&nbsp;&nbsp;wybierz adresata</option>
					';
				while($work = mysqli_fetch_array($nadawca)) 
				{
				echo '<option value="'.$work[0].'" default="">'.$work[1].'</option>';
				}
echo '					
				</center>	
				</tr>
				<tr>
					<td colspan="3" class="a1"><center>Treść:<br>				
					<textarea rows="3" cols="80" name="tresc" form="korespondencja" required placeholder="'.$ELpismo['tresc'].'">'.$ELpismo['tresc'].'</textarea></td>
					<input type="hidden" name="tresc_old" value="'.$ELpismo['tresc'].'">
				</tr>
				<tr>
					<td colspan="3" class="a1"><center>Uwagi:<br>				
					<textarea rows="3" cols="100" name="uwagi_new" form="korespondencja" placeholder="'.$ELpismo['uwagi'].'">'.$ELpismo['uwagi'].'</textarea></td>
					<input type="hidden" name="uwagi_old" value="'.$ELpismo['uwagi'].'">
				</tr>
				<tr>';
#				echo "
#				<td>".(($row[kierunek]=='W')?'<img src="img/up.png" style="width: 13px; height: 13px; vertical-align:middle"/><mark style="background-color: lightblue; color: blue">Wychodząca</mark>':'<img src="img/down.png" style="width: 13px; height: 13px; vertical-align:middle"/><mark style="background-color: orange; font: brown">Przychodząca</mark>')."</td>
#				";
				echo '
				<td class="a1">
					
					Kierunek przesyłki: <br>
					<select name="kierunek" size="1" required>
							<option style="background-color: lightblue; color: blue" value="W"   '.(($ELpismo['kierunek']=='W')?"selected":"").'  >wychodząca</option>
							<option style="background-color: orange; color: brown" value="P"   '.(($ELpismo['kierunek']=='P')?"selected":"").'  >przychodząca</option>
					</select>
					
					</td>


<td></td>
<td class="a1"><center>
Kategoria:<br>
<input type="text" name="oooooo" value="'.$ELpismo['kategoria_id'].'" disabled></td>
				</tr>
				<tr><center>
					<td class="a1"><center>Pracownik:<br>
						<input type="text" disabled required name="Pracownik_id" value="'.$ELpracownik['username'].'"></td>
					<td class="a1"><center>Oryginalny adresat:<br>
						<input type="text" disabled required name="nadawca_id_old" value="'.$ELnadawca['Nazwa'].'"></td>
						<input type="hidden" name="nadawca_id_old" value="'.$ELnadawca['Nazwa'].'">
					</select>
					<td class="a1"><center>Data: <br>
					<input type="date" name="data_pisma" disabled required max="2030-12-31" min="2016-01-01" value="'. date("Y-m-d", strtotime($ELpismo['data_pisma'])). '"/></td>
				</tr>
					<input type="hidden" name="userid" value="'.$_SESSION['userid'].'"/>
					<input type="hidden" name="id" value="'.$_POST['E_id'].'"/>
					<input type="hidden" name="kierunek_old" value="'.$ELpismo['kierunek'].'"/>
				<tr>
					<td colspan="3" class="a1"><br><center><input type="submit" value="Zmień pozycję" id="korespondencja"></td>
				</tr>
				</form>';
}
if(mysqli_num_rows($pliki) > 0) {
			echo '
					<th colspan="3" style="border-radius:8px">Pliki dodane do pisma (kliknij, aby pobrać):</th>';

			while($work1 = mysqli_fetch_array($pliki))
			{
				echo "<tr><td colspan=\"3\">
				<a href=\"plik_pobierz.php?id=". $work1['id']."\" style=\"color: white;text-decoration:none\">". $work1['nazwa_pliku'] . "</a></td></tr>";	
			}
			echo '<br>';	
}						
			echo '
<form method="post" enctype="multipart/form-data" action="upload_file.php">
	<tr><th colspan="3" style="border-radius:8px">Dodaj plik:</th></tr>
		<tr><td colspan="2" style="border-radius:8px">
			<input type="hidden" value="'.$_POST['E_id'].'" name="E_id">
			<input type="hidden" name="MAX_FILE_SIZE" value="12000000">
			<input name="userfile" type="file" accept=".pdf, .png, .jpg, .gif, " id="userfile" style="background-color: grey">
		</td>

		<td><input name="upload" type="submit" class="box" id="upload" value="Prześlij wybrany plik"></td>
		
	</tr>
</form>
</table>
<br>
	
				<a class="red" href="szukaj.php">Wróc do listy korespondencji</a><br><br></div></div></div><br><br>
			</body>
</html>';
$conn->close();
?>
