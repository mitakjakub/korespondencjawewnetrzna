<?php
session_start();
include("include/config.php");
include("include/if.php");

$nadawca = mysqli_query($conn,'SELECT @curNumer := @curNumer + 1 as LP,
N.ID, N.Nazwa, N.miasto, N.adres, N.kodpocztowy, N.kraj, N.wojewodztwo, N.Data, P.username 
FROM nadawca N LEFT JOIN Pracownik P 
ON N.pracownik_id = P.id
JOIN (SELECT @curNumer := 0) as G
ORDER BY N.Nazwa;');

 echo '
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
		    <link href="style.css" rel=\'stylesheet\' media="all">
			<title>Korespondencja wewnętrzna :: Adresaci</title>
			<script src="../lib/jquery-3.1.1.min.js"></script>
		<script>
        $(document).ready(function(){
        $(\'table tbody\').each(function(){
        var num=$(this).children().length;
       // alert(num);
       $(this).before("<div id=\'header\' class=\'medium\'>++ Kliknij, aby pokazać/ukryć listę</div>");
        //alert($(this).html());
        $(this).wrap(\'<div class="new" />\');
        $(\'.new\').hide();
        });
        $(\'.medium\').on(\'click\',function(){
        $(this).next().slideToggle("slow");
        });
        });
        </script>
		</head>	 
		<body class="gradient">';
include_once 'include/topmenu.php';			

     echo '
	<br>
	<center>
	<div class="card1" style="width: 550px">
		<div class="red_header2">
			<div class="textshadow">
				<b>Nowy adresat</b>
				<br>
			</div>
		</div>
		<div class="container2">
			<center><br>
			<table class="a1"><thead>
				<form action="wnadawca.php" method="post" id="nadawca"><a name="NADRESAT"></a>
				<th colspan="2" style="background-color:#333; border-radius:8px">Wprowadź dane nowego adresata</th>
				<tr>				
					<td class="a1" colspan="2">Nazwa adresata/odbiorcy: <br><textarea rows="3" cols="60" name="textnadawca" form="nadawca" required="yes" placeholder="Nazwa [POLE WYMAGANE]"></textarea></td></tr>
					<tr><td class="a1" colspan="2">Adres: <br><textarea rows="2" cols="60" name="adres" form="nadawca"  placeholder="Ulica [Pole opcjonalne]"></textarea></td></tr>
					<tr><td class="a1">Kod pocztowy:<br>
					<input type="text" name="kod" placeholder="00-000 [Pole opcjonalne]" default="00-000" pattern="[0-9][0-9]-[0-9][0-9][0-9]"/></td>
					<td class="a1" style="float:right">Miasto:<br><input type="text" name="miasto" placeholder="Miasto [pole opcjonalne]"/></td></tr>
					
					</tr>
					<tr>
					<td class="a1">Województwo:<br>
					<select name="wojewodztwo">
							<option selected value="" default>Wybierz... [opcjonalnie]</option>
							<option value="dolnośląskie">dolnośląskie</option>
							<option value="kujawsko-pomorskie">kujawsko-pomorskie</option>
							<option value="lubelskie">lubelskie</option>
							<option value="lubuskie" >lubuskie</option>
							<option value="łódzkie">łódzkie</option>
							<option value="małopolskie">małopolskie</option>
							<option value="mazowieckie">mazowieckie</option>
							<option value="opolskie">opolskie</option>
							<option value="podkarpackie">podkarpackie</option>
							<option value="podlaskie">podlaskie</option>
							<option value="pomorskie">pomorskie</option>
							<option value="śląskie">śląskie</option>
							<option value="świętokrzyskie">świętokrzyskie</option>
							<option value="warmińsko-mazurskie">warmińsko-mazurskie</option>
							<option value="wielkopolskie">wielkopolskie</option>
							<option value="zachodniopomorskie">zachodniopomorskie</option>
					</select></td>
				<td class="a1" style="float:right" >Kraj:<br>
				<input type="text" name="kraj"  placeholder="Kraj [pole opcjonalne]"/></td></tr><//thead>
			</table>
				<br>
						<input type="submit" value="Dodaj pozycję" autofocus >
			<br><br>
	</div></div></div><br>
';
echo '
			<br>
	        <center>
			<div class="card1">
				<div class="header">
					<div class="textshadow">
						Lista adresatów		
					</div>
				</div>
        	    <div class="container2">
	                <div class="textshadow">
						<center>
						<table id="lista1" width="100%"><p align="center">
							<tr><th>LP</th>
								<th>Nazwa</th>
								<th>Adres</th>
								<th>Miasto</th>
								<th>Województwo</th>
								<th>Kod pocztowy</th>
								<th>Kraj</th>
								<th>Utworzył:</th>
								<th>Data utworzenia</th>
							</tr>
					</div>';
			
if ($nadawca->num_rows > 0) {

	while($row = $nadawca->fetch_assoc()) {
		echo
		"<tr>
		<td>". $row["LP"].
		"</td><td>". $row["Nazwa"]. 
		"</td><td>" . $row["adres"].
		"</td><td>" . $row["miasto"].
		"</td><td>" . $row["wojewodztwo"].
		"</td><td><center>" . $row["kodpocztowy"].
		"</td><td>" . $row["kraj"].
		"</td><td>" . $row["username"].
		"</td><td><center> ". $row["Data"].  "</td>";
    }
$aaaaaaa =  mysqli_character_set_name($conn);
	echo "</table><br>";
}
     else {
	     echo "</table><br><br>Brak wyników";
     }	
	
	
echo '</div></div></div><br>	
</body>
</html>';
$conn->close();

?>

