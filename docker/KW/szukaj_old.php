<?php
session_start();
include("include/config.php");
include("include/if.php");
error_reporting( error_reporting() & ~E_NOTICE );
#print_r($_SESSION);
##### Obsługa daty
$today= date('Y-m-d');
if($_NEWPOST['startdate'] == "") { 
		$startdate= $today ; 
	} 
	else { 
		$startdate= $_NEWPOST['startdate']; 
}

if($_NEWPOST['enddate'] == "") { 
	$enddate=  $today; 
} 
else { 
	$enddate= $_NEWPOST['enddate']; 
}
$pismodata="P.data_pisma BETWEEN \"$startdate\" and \"$enddate\" and";

unset($_SESSION['search_startdate']);



#### Obsługa tytułu
if($_NEWPOST['tytul'] == "") {
	$tytul="";
}
else {
   $_NEWPOST['tytul'] = preg_replace("+[*]+", "%", $_NEWPOST['tytul']);
    $tytul="P.tresc like \"%" . $_NEWPOST['tytul'] . "%\" and";
}
$sqltitle="P.tresc like \" . $tytul . \" and ";


#### Obsluga tytulu
if($_NEWPOST['uwagi'] == "") {
	$uwagi="";
}
else {
    $_NEWPOST['uwagi'] = preg_replace("+[*]+", "%", $_NEWPOST['uwagi']);
	$uwagi="P.uwagi like \"%" . $_NEWPOST['uwagi'] . "%\" and";
}
$sqluwagi="P.uwagi like \" . $uwagi . \" and ";



#### KIERUNEK - PRZYCHODZACA, WYCHODZZACA
if($_NEWPOST['kierunek'] == "P") {
	$kierunek="P.kierunek = \"P\" and";
}
elseif($_NEWPOST['kierunek'] == "W") {
	$kierunek="P.kierunek = \"W\" and";
}
else {
	$kierunek="";
}

$nadawcaA = "SELECT ID, Nazwa FROM nadawca;";
$nadawca = $conn->query($nadawcaA);



##### Nadawca
if ($_POST['nadawca'] == "") {
	$nadawcasql = "";
}
else {
	$nadawcasql = "N.ID = " . $_NEWPOST['nadawca'] . " and ";
}


$grupa="SELECT * from komorg
where id = $_SESSION[group]
";





$sqlbase="SELECT
	@curNumer := @curNumer + 1 as LP,
	P.id, 
	P.kierunek,
	P.numer, 
	P.symbol, 
    P.tresc, 
    P.data_pisma, 
    N.Nazwa,
	P.uwagi,
	PR.username as Pracownik,
	K.nazwa,
	K.skrot
from 
	Pracownik PR,
	komorg K,
	nadawca N,
	Pismo P
	JOIN (SELECT @curNumer := 0) as G
where
	P.Pracownik_id = PR.id and 
	K.id = PR.komorg_id and
	P.nadawca_id = N.ID and
	$pismodata
	$tytul
	$uwagi
	$nadawcasql
	$kierunek
	PR.komorg_id in ($aaaa)
	
	
ORDER BY P.id DESC, P.data_pisma DESC;
	";
if (!isset($_SESSION['dbusername'])) {
    header("Location: login.php");
	die(); 
}
 if ($conn->connect_error) {
     die("Połączenie niemożliwe: " . $conn->connect_error);
} 
$result = $conn->query($sqlbase);

echo '
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
		<link href="style.css" rel=\'stylesheet\' media="all">
		<title>Korespondencja wewnętrzna :: Lista korespondencji</title>
	</head>	 
	<body class="gradient">
	<center>
		<div>';
include_once 'include/topmenu.php';
		echo '
			<br>
	        <center>
		</div>
		<div class="card1">
			<div class="red_header2">
				<div class="textshadow">
					<b>Lista korespondencji</b>
				</div>
			</div>	
		
			<div class="container2">
				<form action="szukaj" method="post" id="korespondencja">
					<ul style="border-radius:8px;">
						<li style="padding-left:5px;padding-right:5px">
							<img src="img/data.png" style="width: 12px; height: 12px; vertical-align:middle"/> Data od:<br>
							<input align="middle"  type="date" name="startdate" required="yes" max="2020-12-31" min="2015-01-01" value="' . $startdate . '"/>
						<br><br></li>
						<li style="padding-left:5px;padding-right:5px">
							<img src="img/data.png" style="width: 12px; height: 12px; vertical-align:middle"/> Data do:<br>
							<input align="middle" type="date" name="enddate" required="yes" max="2020-12-31" min="'. $_NEWPOST[startdate] . '" value="' . $enddate . '"/>
						<br><br></li>	
						<li style="padding-left:5px;padding-right:5px">
							<img src="img/title.png" style="width: 12px; height: 12px; vertical-align:middle"/>Tytuł:<br>
							<input align="middle" type="text" name="tytul" default="" value="' . preg_replace("+[%]+", "*", $_NEWPOST['tytul']).'"/>
						<br><br></li>	
						<li style="padding-left:5px;padding-right:5px">
							<img src="img/title.png" style="width: 12px; height: 12px; vertical-align:middle"/>Uwagi:<br>
							<input align="middle" type="text" name="uwagi" default="" value="' . preg_replace("+[%]+", "*", $_NEWPOST['uwagi']) .'"/>
						<br><br></li>	
						<li style="padding-left:5px;padding-right:5px">
							<img src="img/adresat.png" style="width: 12px; height: 12px; vertical-align:middle"/> Adresat:<br>
							<select name="nadawca" align="middle">
						<option value="">Wszyscy</option>';
					while($work = mysqli_fetch_array($nadawca)) 
					{ 
						echo '
								<option value="' . $work[0] . '" '.(($_POST[nadawca]==$work[0])?'selected="selected"':"").'>' . $work[1] .'</option>';
					};
					echo '
							</select>
						<br><br></li>
						<li style="padding-left:5px">
							<img src="img/kierunek.png" style="width: 12px; height: 12px; vertical-align:middle"/> Kierunek:<br>
							<select name="kierunek">
								<option value="" '.(($_POST[kierunek]=='')?'selected="selected"':"").'>Dowolny</option>
								<option value="P" '.(($_POST[kierunek]=='P')?'selected="selected"':"").'>Przychodząca</option>
								<option value="W" '.(($_POST[kierunek]=='W')?'selected="selected"':"").'>Wychodząca</option>
							</select>
						<br><br></li>
					</ul>
					<p align="right">';
					unset($_SESSION['search_startdate']);
					echo '
						<input type="submit" value="Filtruj" autofocus>
				</form>
					<div class="textshadow">
					</div>
						';
if ($result->num_rows > 0) {
	echo '<center>
						<table width="100%">
							<tr>
								<th>LP</th>
								<th>Data</th>
								<th>Adresat</th>
								<th>Tytuł</th>
								<th>Symbol</th>
								<th>Numer</th>
								<th>Uwagi</th>
								<th>Kierunek</th>
								<th>Pracownik</th>
								
							</tr>';

	while($row = $result->fetch_assoc()) {
		$wyniki[] = $row;
		$pliki="
SELECT
	PP.nazwa_pliku,
	PP.typ_pliku,
	PP.rozmiar,
	PP.id,
	PP.plik,
	P.username,
	K.skrot,
	K.nazwa
from 
	Pismo_plik PP,
	Pracownik P, 
	Pismo PIS,
	komorg K
WHERE 
	PP.pismo_id = $row[id] AND 
	P.id = PP.pracownik_id AND
	PIS.id = PP.pismo_id AND
	K.ID = P.komorg_id
ORDER BY 
PP.id;
";
		$presult = $conn->query($pliki);
		echo"
							<tr><td><center>".$row["LP"]."</td>
								<td><center>".date("Y.m.d", strtotime($row["data_pisma"]))."</td>
								<td>".$row["Nazwa"]."</td>
								<td>".$row["tresc"]."</td>
								<td>".(($row[symbol]=='XXX')?'BRAK':$row['symbol']). "</td>
								<td>".(($row[numer]=='9999')?'BRAK':$row['numer']).  " </td>	
								
								<td>".$row["uwagi"]."</td>
								<td>".(($row[kierunek]=='W')?'<img src="img/up.png" style="width: 13px; height: 13px; vertical-align:middle"/><mark style="background-color: lightblue; color: blue">Wychodząca</mark>':'<img src="img/down.png" style="width: 13px; height: 13px; vertical-align:middle"/><mark style="background-color: orange; font: brown">Przychodząca</mark>')."</td>
								<td>".$row["skrot"]." ".$row["Pracownik"]."</td>"
								;
		if(date("Y.m.d", strtotime($row["data_pisma"])) == date("Y.m.d")  or ($_SESSION['group'] == 3))
			{
				echo '<form action="edycja_korespondencji" method="post" id="edycja">
					<input type="hidden" name="E_id" value="'.$row['id'].'"/>';
					$_SESSION['search_startdate'] = $startdate;
					$_SESSION['search_enddate'] = $enddate;
					$_SESSION['search_tytul'] = $tytul;
					$_SESSION['search_nadawca'] = $nadawca;
					echo '
					<td class="a3" width="1%"><p align="right"><input align="right" class="edycja" type="submit" value="Edycja" /></p></td></form>';
			}
		$zmiany_test = "SELECT PZ.pismo_id AS id FROM Pismo_zmiany PZ, nadawca N, Pracownik P, Pismo PIS WHERE PZ.pismo_id = $row[id] AND PZ.nadawca_id_new = N.ID AND P.id = PZ.pracownik_id AND PIS.id = PZ.pismo_id;";
		$zmienione_query = $conn->query($zmiany_test);
		if (( $zmienione_query->num_rows > 0) and date("Y.m.d", strtotime($row["data_pisma"])) !== date("Y.m.d"))
		{
			$hrow = $zmienione_query->fetch_assoc();
			echo '
		
				<form action="historia_korespondencji" method="post" id="historia" />
					<input type="hidden" name="IDCLASS" value="'.$hrow['id'].'" />';
					$_SESSION['search_startdate'] = $startdate;
					$_SESSION['search_enddate'] = $enddate;
					$_SESSION['search_tytul'] = $tytul;
					$_SESSION['search_nadawca'] = $nadawca;
					$_SESSION['search_uwagi'] = $uwagi;
					
					echo'<td class="a3" width="1%"><p align="right"><input align="middle" class="edycja" type="submit" value="Historia zmian" />
				</form>
				</p>
			</td>';
			}
			if(mysqli_num_rows($presult) > 0) {
			echo '<tr>';
			while($work1 = mysqli_fetch_array($presult))
			{
				echo "
				<tr class=\"b1\">
					<td colspan=\"2\" style=\"background-color: transparent\"></td>
					<td class=\"file\">
						<a href=\"plik_pobierz?id=". $work1['id']."\" style=\"color: white;text-decoration:none\"><img src=\"img/note.png\" style=\"width: 13px; height: 13px; vertical-align:middle\"/> ". $work1['nazwa_pliku'] . "
						</a><td style=\"background-color: transparent\"></td>
					<td colspan=\"2\" class=\"file\">Rozmiar: " .strstr($work1[rozmiar] / 1024, '.', True) ."kB<td style=\"background-color: transparent\"></td><td class=\"file\">" .$work1[skrot]. " " .$work1[username]."
					</td>
				</tr>";	
			}
			echo '</tr><tr></tr>';	
}							
	}		
	
	echo "
			</tr></table>";
}
    else {
		echo '
						<div class="big">
							<p class="cc">
								Brak wyników
							</p>
						</div>';
    }


$ngrupa = $conn->query($grupa);	
$nazwa_grupy = $ngrupa->fetch_assoc();

$skidrow = $result->fetch_assoc();
if ($result->num_rows > 0) {
echo '
						<p class="cc">
							<a class="red" href="javascript:window.print()">Drukuj wyniki</a>
						</p><br>
					</div>
				</div>
			</div>
		<div class="drukuj">
		<br><br><b>Korespondencja '. $nazwa_grupy['nazwa']. '<br>' . $startdate .' - ' . $enddate.'</b><br><br><br>
		<table class="a2" width="95%">
		<tr>
			<th class="a5">Data</th>
			<th class="a5">Numer/symbol</th>
			<th class="a5">Adresat</th>
			<th class="a5">Tytuł pisma</th>
			<th class="a5">Podpis os. odb.</th>
		</tr>
		
		
		';
			foreach($wyniki as $key => $value)
{
echo "
	<tr>
		<td class=\"a4\"><center>". date("Y.m.d", strtotime($value['data_pisma'])) . "</td>
		<td class=\"a4\"><center>".(($value[symbol]=='XXX')?' ':$value['symbol']). " " .(($value[numer]=='9999')?' ':$value['numer']).  " </td>	
		<td class=\"a4\">". $value['Nazwa'] ."</td>
		<td class=\"a4\">". $value['tresc'] . "</td>
		<td class=\"a4\" width=\"15%\" bgcolor=\"#00FF00\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>";
}
			echo '</table>
		</div>';
}
else {
echo '</div></div></div>';
}
echo '</div><br><br>
	</body>
</html>
';

$conn->close();
?>
