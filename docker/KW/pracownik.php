<?php
session_start();
include("include/config.php");
if($_SESSION['group'] !== "3") 
	{	
		$leerror="<table><th>Żądana strona nie jest dostępna na tym poziomie zabezpieczeń!</th></table>";
		$_SESSION['leerror'] = $leerror;
		header("location: error.php");
	}
include("include/if.php");
$grupa = mysqli_query($conn,"SELECT ID, Nazwa from komorg ORDER BY nazwa;");
$sql = "SELECT P.id, P.username, P.imie, P.nazwisko, K.nazwa, K.skrot FROM Pracownik P, komorg K where P.komorg_id = K.id order by K.nazwa, P.id";
$result = $conn->query($sql);
     if ($result->num_rows > 0) {
		echo '
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="style.css" rel=\'stylesheet\' media="all">
	<title>Korespondencja wewnętrzna :: Zarządzanie użytkownikami</title>
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
	<meta charset="UTF-8">
<body class="gradient">
	<a name="TOP"></a>';
include_once 'include/topmenu.php';			
echo '
		<br>
	    <center>
		<div class="card1">
			<div class="header">
				<div class="textshadow">
					Lista użytkowników
				</div>
			</div>
        	<div class="container2">
				<div class="textshadow">
			<center>
			<table width="100%">
			<tr>
				<th>
					<p align="center">
					ID
					</p>
				</th>
				<th>
					<p align="center">
					Login
					</p>
				</th>
				<th>
					<p align="center">
					Imię
					</p>
				</th>
				<th>
					<p align="center">
					Nazwisko
					</p>
				</th>
				<th>
					<p align="center">
					Komórka Organizacyjna
					</p>
				</th>
			</tr>';
	while($row = $result->fetch_assoc()) {
					echo"<tr><td><b>" . mysqli_escape_string($conn,$row["id"]). "</b></td><td>" . mysqli_escape_string($conn,$row["username"]) . "</td><td>" . mysqli_escape_string($conn,$row["imie"]). "</td><td>" . mysqli_escape_string($conn,$row["nazwisko"]). "</td><td>" . mysqli_escape_string($conn,$row["skrot"])." - ". mysqli_escape_string($conn,$row["nazwa"])."</td>";
					echo '<form action="pracownik_edycja.php" method="post" id="edycja">
					<input type="hidden" name="Eid" value="'.mysqli_escape_string($conn,$row['id']).'"/>
					<input type="hidden" name="Eusername" value="'.mysqli_escape_string($conn,$row['username']).'"/>
					<td class="a3" width="3%"><p align="right"><input align="middle" class="edycja" type="submit" value="Edycja" /></p></td></form>';
		} 
		echo "</table><br>";
	if (empty($imie)) {
		echo "";
	}
	else {
		echo '
		<center><li>Pomyślnie dodano pracownika <b>'. mysqli_escape_string($conn,$username) .' 
		'. mysqli_escape_string($conn,$imie) .' 
		'. mysqli_escape_string($conn,$nazwisko).' 
		'. $conn->query('SELECT id from Pracownik WHERE imie = "'.mysqli_escape_string($conn,$imie).'" and nazwisko = "'.mysqli_escape_string($conn,$nazwisko).'"').
		'</b> do bazy</li></center><br><br><br>'; 
		} 
     
     }
     else {
	     echo "Brak wyników";
     }
     echo '
	</div></div></div>
	<br>
	<br>
	<center>
	<div class="card1" style="width: 550px">
		<div class="red_header2">
			<div class="textshadow">
				<b>Tworzenie nowego użytkownika</b>
			</div>
		</div>
		<div class="container2">
			<center><br>
			<table class="a1"><thead>
				<th style="background-color:#333; border-radius:8px">Wprowadź dane nowego użytkownika</th>
				<form action="wrzuc.php" method="post">
				<tr>
					<td><center>Login:<br>
					<input type="text" name="username" required="yes" autocomplete="off"/></td>
				</tr>
				<tr>
					<td><center>Hasło:<br>
					<input type="password" name="password" required="yes" autocomplete="off"/></td>
				</tr>
				<tr>
					<td><center>Imię:<br>
					<input type="text" name="imie" required="yes"/></td>
				</tr>
				<tr>
					<td><center>Nazwisko:<br>
					<input type="text" name="nazwisko" required="yes"/></td>
				</tr>
				
				<tr>
					<td><center>Komórka Organizacyjna:<br>
					<select name="komorg_id">
					';
									while($work = mysqli_fetch_array($grupa)) 
				{
				echo '<option value="'.mysqli_escape_string($conn,$work[0]).'" default="">'.mysqli_escape_string($conn,$work[1]).'</option>';
				}
				echo '

					</select>
					</td>
				</tr>
			</thead>	
			</table>
				<br>
						<input type = "submit" value = "" style="background: #4CAF50 url(img/add.png) no-repeat center;"/>
				</form>
			<br><br>
	</div></div><br><br>
</body>
</html>';
$conn->close();
?> 
