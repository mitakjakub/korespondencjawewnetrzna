<?php
$nazwa_original =  mysqli_escape_string($conn,basename($_SERVER["SCRIPT_FILENAME"]));
$phpk= mysqli_escape_string($conn,"korespondencja.php");
$phps=mysqli_escape_string($conn,"szukaj.php");
$phpn=mysqli_escape_string($conn,"nadawca.php");
$phpp=mysqli_escape_string($conn,"pracownik.php");

print '
	<ul>
		<li><a href="korespondencja.php" '.(($phpk==$nazwa_original)?'class="active"':"").'><img src="img/new_.png" style="width: 12px; height: 12px; vertical-align:middle"/> Nowa pozycja</a></li>
		<li><a href="szukaj.php" '.(($phps==$nazwa_original)?'class="active"':"").'><img src="img/search.png" style="width: 12px; height: 12px; vertical-align:middle "/> Lista korespondencji</a></li>
		<li><a href="nadawca.php" '.(($phpn==$nazwa_original)?'class="active"':"").'><img src="img/adresat.png" style="width: 12px; height: 12px; vertical-align:middle"/> Adresaci</a></li>';	
if ($_SESSION['group'] == 3) 
	{
	echo '
		<li><a href="pracownik.php" '.(($phpp==$nazwa_original)?'class="active"':"").'><img src="img/people.png" style="width: 12px; height: 12px; vertical-align:middle"/>Użytkownik</a></li>';
	}
	echo '
		<li class="dropdown" style="float:right">
			<a href="#" class="dropbtn">'. mysqli_escape_string($conn,$_SESSION['dbusername']).': menu </a>
			<div class="dropdown-content">
				<a href="zgloszenie.php"><img src="img/bug.png" style="width: 12px; height: 12px; vertical-align:middle"/> Zgłoś problem</a>
				<a href="logout.php"><img src="img/key.png" style="width: 12px; height: 12px; vertical-align:middle"/> Wyloguj</a>
				<a href="password.php"><img src="img/logout.png" style="width: 12px; height: 12px; vertical-align:middle"/> Zmień hasło</a>
			</div>
		</li>
	</ul>';
?>
