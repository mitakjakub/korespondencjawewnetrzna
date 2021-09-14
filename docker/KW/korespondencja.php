<?php
session_start();
include("include/config.php");

include("include/if.php");
$nadawca = mysqli_query($conn,'SELECT ID, Nazwa FROM nadawca ORDER BY Nazwa;');

$kategoria = mysqli_query($conn, 'SELECT * FROM kategoria;');


if(!isset($_NEWPOST['E_symbol'])){
    $_NEWPOST['E_symbol']="";
}
if(!isset($_NEWPOST['E_kierunek'])){
    $_NEWPOST['E_kierunek']="";
}
if(!isset($_NEWPOST['E_tresc'])){
    $_NEWPOST['E_tresc']="";
}
if(!isset($_NEWPOST['E_uwagi'])){
    $_NEWPOST['E_uwagi']='';
}
if(!isset($_NEWPOST['E_numer'])){
    $_NEWPOST['E_numer']="";
}

#$_SESSION['pismoinserted'] = "OK";

if(isset($_SESSION['pismoinserted']))
{
	    $pismook='<center>
        <div id="dialog"><br><br>
    <p><center>Korespondencja została poprawnie dodana do bazy</p>
       </div></center>';
}
else
{
$pismook='';
}
unset($_SESSION['pismoinserted']);
#echo strlen($_NEWPOST['E_uwagi']);

$sql = "SELECT
    P.kierunek,
    P.id, 
    P.numer, 
    P.symbol, 
    P.tresc, 
    P.data_pisma, 
    N.Nazwa,
    PR.username as Pracownik,
    K.nazwa,
    P.uwagi,
    K.skrot,
    KA.nazwa
from 
    Pracownik PR,
    komorg K,
    nadawca N,
    Pismo P
    left outer join kategoria as KA on P.kategoria_id = KA.id
where
    P.Pracownik_id = PR.id and 
    K.id = PR.komorg_id and
    P.nadawca_id = N.ID and
    PR.komorg_id in ($aaaa)
ORDER BY P.id DESC, P.data_pisma DESC
LIMIT 3;";
$result = $conn->query($sql);
echo '
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
	    <link href="style.css" rel=\'stylesheet\' media="all">
		<title>Korespondencja wewnętrzna :: Nowa pozycja</title>
        <script src="../lib/jquery-3.1.1.min.js"></script>
        <script src="../lib/jquery-ui.js"></script>
        <script src="../lib/datepicker-pl.js"></script>
        <script>
        $( function() {
        $( "#datepicker" ).datepicker({ dateFormat: \'yy-mm-dd\', defaultDate: \'01/01/01\' });
	} );
	</script>
        <script>
        $( function() {
        $( "#dialog" ).dialog({ closeText: "Zamknij", hide: { effect: "drop", duration: 500 },  show: { effect: "drop", duration: 500 }, modal: true,  open: function(event, ui)
		{ setTimeout("$(\'#dialog\').dialog(\'close\')",3000);}
		});
        } );
		</script>
		<script language="javascript" type="text/javascript">
		function charLimit(limitField, limitCount, limitNum) {
			if (limitField.value.length > limitNum) {
				limitField.value = limitField.value.substring(0, limitNum);
			} 
			else {
				limitCount.value = limitNum - limitField.value.length;
		}
		}
		</script>

	</head>	 
	<body class="gradient">';
include_once 'include/topmenu.php';
echo '
<br>
<center>
	<div class="card1">
		<div class="red_header2">
			<div class="textshadow">
				<b>Nowa korespondencja</b><a name="NOWA"></a>
			</div>
		</div>
		<div class="container2">';
if ($result->num_rows > 0)
    {
	echo '
            <ul>
				<li class="dropdown">
					<a href="#" class="dropbtn"><img src="img/storage.png" style="width: 12px; height: 12px; vertical-align:middle"> Ostatnie trzy dodane pozycje</a>
						<div class="dropdown-content">
							<table width="100%" style="background-color: darkgrey; font-size: 10px; padding: 0px; border: solid 3px #f3f3c4; box-shadow: 0 0px 2px 2px dimgrey, 0px 30px 60px 0 rgba(0, 0, 0, 0.7), 0px 0px 25px 0 rgba(0, 0, 0, 0.5); border-radius: 5px;">
								<tr class="b1">
								<td style="background-color: transparent"></td>
								<th>Data pisma</th>
								<th>Adresat</th>
								<th>Treść</th>
								<th>Symbol</th>
								<th>Numer</th>
								<th>Uwagi</th>
								<th>Kierunek</th>
								<th>Pracownik</th>
								<th>Kategoria</th>
								</tr>';		
	while($row = $result->fetch_assoc()) 
		{
		echo '
								<tr>
								<td class="a3" width="3%" style="background-color: darkgrey;">
								<form action="korespondencja.php#makemebad" method="post" id="kopia">
									<input type="hidden" name="E_kierunek" value="'.$row['kierunek'].'"/>
									<input type="hidden" name="E_numer" value="'.$row['numer'].'"/>
									<input type="hidden" name="E_symbol" value="'.$row['symbol'].'"/>
									<input type="hidden" name="E_tresc" value="'.$row['tresc'].'"/>
									<input type="hidden" name="E_uwagi" value="'.$row['uwagi'].'"/>
									<input align="middle" class="edycja" type="submit" value="Kopiuj" /></td>';
									
		echo "
								<td width=\"5%\">". date("Y.m.d", strtotime($row["data_pisma"]))."</td>
								<td>". $row["Nazwa"]. "</td>
								<td>". $row['tresc']. "</td>
								<td width=\"5%\">". $row["symbol"]. "</td>
								<td width=\"5%\">" . $row["numer"]. "</td>
								<td>". $row["uwagi"]. "</td>
								<td width=\"3%\">".(($row['kierunek']=='W')?'<img src="img/up.png" style="width: 13px; height: 13px; vertical-align:middle"/><mark style="background-color: lightblue; color: blue">Wychodząca</mark>':'<img src="img/down.png" style="width: 13px; height: 13px; vertical-align:middle"/><mark style="background-color: orange; font: brown">Przychodząca</mark>')."</td>
								<td width=\"5%\">" . $row["Pracownik"]. " " . $row["skrot"] . "</td>
								<td>" . $row["nazwa"]."</td>
								</form>
								</tr>";
		}
		echo '
	</table></div></li></ul>';
}
echo $pismook;
echo '      <center>	
			<table class="a1"><a name="makemebad"></a><br>
				<form action="wkorespondencja.php" method="post" id="korespondencja">
					<th colspan="3" style="background-color:#333; border-radius:8px">Dodaj nową pozycję:</th>
					<tr>
					<td class="a1">
					Numer:<br><input type="number" title="Wpisz numer. Aby ukryć to pole z wydruku wpisz 9999" name="numer" required value="'.$_NEWPOST['E_numer'].'" min="1" placeholder="Numer..."/><br>
					<td class="a1">
					Symbol:<br><input type="text" title="Wpisz symbol. Aby ukryć to pole z wydruku wpisz XXX" name="symbol" required value="'.$_NEWPOST['E_symbol'].'" placeholder="Symbol dokumentu"/></td>
					<td class="a1">Kierunek przesyłki: <br>
					<select name="kierunek" size="1" required style="color: dimgrey">
							<option style="background-color: lightblue; color: blue" value="W"   '.(($_NEWPOST['E_kierunek']=='W')?"selected":"").'  >wychodząca</option>
							<option style="background-color: orange; color: brown" value="P"   '.(($_NEWPOST['E_kierunek']=='P')?"selected":"").'  >przychodząca</option>
					</select>
					</td>
				</tr>				<tr>
					<td colspan="3" class="a1">Treść:<br>	
					<textarea rows="3" cols="80" name="tresc" form="korespondencja" required="yes" placeholder="Wpisz treść o długości poniżej 250 znaków..." onKeyDown="charLimit(this.form.tresc,this.form.countdown,250);" maxlenght="250">'.$_NEWPOST['E_tresc'].'</textarea></td>
				</tr>
				<tr>
					<td colspan="3" class="a1">Uwagi:<br>				
					<textarea rows="3" cols="80" name="uwagi" form="korespondencja"  placeholder="[pole opcjonalne]" >'.$_NEWPOST['E_uwagi'].'</textarea></td>
				</tr>
				<tr>
					<td class="a1">Kategoria:<br>
					<select name="kategoria_id" size="1" style="color:#333">
					<option value="" style="color:lightgrey">Wybierz...</option>
';
				while($korki = mysqli_fetch_array($kategoria)) {
				echo '<option value="'.$korki[0].'">'.$korki[1].'</option>';
				}	
echo '

					<td class="a1">Adresat:<br>
					<select name="nadawca_id" size="1" required style="color:#333">
					<option value="" style="color:lightgrey">Wybierz...</option>
					';		
while($work = mysqli_fetch_array($nadawca))	{				
	echo '<option value="'.$work[0].'">'.$work[1].'</option>';
}
echo '
					</select></td>
					<td class="a1">
						<a class="red" href="nadawca.php#NADRESAT">Dodaj nowego adresata</a>
					</td>
				</tr>
				<tr>
					<td class="a1">Data:<br>
										<input type="text" id="datepicker" name="data_pisma" required="yes" max="2030-12-31" min="2016-01-01" value="'.date('Y-m-d').'"/></td>
                    <td colspan="2" class="a1" style="color: yellow">UWAGA!!! Edycja pozycji książki nadawczej<br>możliwa jest jedynie w dniu podanym w polu data!</td>
				</tr>
					<input type="hidden" name="id" value="'.$_SESSION['userid'].'"/>
			</table>
				<br>
					<input type="submit" value="Dodaj pozycję" autofocus>
				</form>
			</center>
			<br>
	</div></div><br>
</body>
</html>';
$conn->close();
?>
