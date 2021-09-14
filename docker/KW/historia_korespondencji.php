<?php
   include("include/config.php");
   session_start();
   
$zmiany= mysqli_query($conn, "SELECT 
	@curNumer := @curNumer + 1 as LP,
	PZ.tresc_new, 
	PZ.tresc_old, 
	PZ.symbol_new, 
	PZ.symbol_old, 
	PZ.numer_new, 
	PZ.numer_old, 
	PZ.nadawca_id_old, 
	PZ.uwagi_old,
	PZ.uwagi_new,
	PZ.kierunek_new,
	PZ.kierunek_old,
	N.Nazwa, 
	P.username, 
	PIS.tresc,
	PZ.data_zmiany 
FROM 
	Pismo_zmiany PZ, 
	nadawca N, 
	Pracownik P, 
	Pismo PIS 
	JOIN (SELECT @curNumer := 0) as G
WHERE 
	PZ.pismo_id = $_POST[IDCLASS] AND 
	PZ.nadawca_id_new = N.ID AND 
	P.id = PZ.pracownik_id AND 
	PIS.id = PZ.pismo_id
ORDER BY PZ.data_zmiany DESC;");

include("include/if.php");
if(!isset($_NEWPOST['IDCLASS']))
{
	$leerror = "<table><th>Niewłaściwe odwołanie.<br>Błąd uniemożliwiający wykonanie żądania.<br>Nie ma takiej pozycji książki.<br>To nie jest błąd aplikacji.</th></table>";
	$_SESSION['leerror'] = $leerror;
	header("Location: error.php");
    die("" . $conn->connect_error);
}


echo '
<html>
<head>
	<link href="style.css" rel=\'stylesheet\' media="all">
	<meta charset="UTF-8">
    <title>Korespondencja wewnętrzna :: Historia zmian pozycji</title>
</head>
		<body class="gradient">';
include_once 'include/topmenu.php';			
echo '
<br><center>
			<div class="card1">
				<div class="header">
					<div class="textshadow">
					Historia zmian pozycji listy
					</div>
				</div>
        	    <div class="container2">
	                <div class="textshadow">
						<center>';					
						if(mysqli_num_rows($zmiany) > 0) {
							echo '<br><table>
							<th>LP</th>
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
							<th>Data zmiany</th>
							';
							while($komorka = $zmiany->fetch_assoc()) {
							echo"<tr><td><center>"
							. $komorka['LP']. "</td><td>"
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
							. $komorka['kierunek_old']. "</td><td>"
							. $komorka['username'] . "</td><td><center>"
							. $komorka['data_zmiany'] . "</td></tr>";
							}
							echo '</table>';
						};
				echo'		
				<br>
				<a class="red" href="szukaj.php">Wróc do wyszukiwania</a><br><br></div></div></div>
			</body>
</html>';
$conn->close();
?>
