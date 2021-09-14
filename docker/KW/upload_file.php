<?php
session_start();
include("include/config.php");

if (!isset($_SESSION['dbusername'])) {
    header("Location: login.php");
	die(); 
}

if ($conn->connect_error) {
	 $leerror = "<table><th>Nie można nawiązać połączenia z bazą danych.<br>Proszę spróbować ponownie później.<br>Jeśli problem wciąż występuje to należy poinformować administratora aplikacji.</th></table>";
	 $_SESSION['leerror'] = $leerror;
	 header("Location: error.php");
     die("" . $conn->connect_error);
	 
} 
if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0)
{
	$fileName = $_FILES['userfile']['name'];
	$tmpName  = $_FILES['userfile']['tmp_name'];
	$fileSize = $_FILES['userfile']['size'];
	$fileType = $_FILES['userfile']['type'];

	$fp = fopen($tmpName, 'r');
	$plik = fread($fp, filesize($tmpName));
	$plik = addslashes($plik);
	fclose($fp);

	if(!get_magic_quotes_gpc())
		{
			$fileName = addslashes($fileName);
	}

	mysqli_query($conn, 'INSERT INTO Pismo_plik(pracownik_id, plik, pismo_id, rozmiar, typ_pliku, nazwa_pliku) VALUES ("'.$_SESSION[userid].'", "'.$plik.'", "'.$_POST[E_id].'", "'.$fileSize.'", "'.$fileType.'", "'.$fileName.'" );') or die('Błąd wysyłki pliku!');
	$_SESSION['wlasciwosc'] = $_POST['E_id'];
	header("Location: " . $_SERVER["HTTP_REFERER"]);
}
else
    { echo 'ERROR'; }
header("Location: " . $_SERVER["HTTP_REFERER"]);
$conn->close();

?>
