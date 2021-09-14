<?php
	include("include/config.php");
	session_start();
	include("include/if.php");
	
function gtfo() {
		$leerror="<table><th>Operacja niemożliwa do wykonania. Przerwano.</th></table>";
		$_SESSION['leerror'] = $leerror;
		header("location: error.php");
	}	
if(isset($_NEWGET['id']))
{
	$id = $_NEWGET['id'];
	if($_SESSION['group'] == 3) 
		{
		$query= 
		"SELECT 
			PP.nazwa_pliku, PP.typ_pliku, PP.rozmiar, PP.plik 
		FROM 
			Pismo_plik PP, Pismo PI, Pracownik P, komorg K
		WHERE 
			PP.id = $id and PP.pismo_id = PI.id;";
		}
	else
		{
		$query = "
		SELECT 
			PP.nazwa_pliku, PP.typ_pliku, PP.rozmiar, PP.plik 
		FROM 
			Pismo_plik PP, Pismo PI, Pracownik P, komorg K
		WHERE 
			PP.id = $id and PP.pismo_id = PI.id and PI.Pracownik_id = P.id and P.komorg_id = K.ID and K.ID = $_SESSION[group];";
		}
	$result = mysqli_query($conn, $query) or die(gtfo());
	if (mysqli_num_rows($result) == 1) 
		{
			list($nazwa_pliku, $typ_pliku, $rozmiar, $plik) = mysqli_fetch_array($result);
			$nnpliku = urlencode($nazwa_pliku);
#			header('Content-Description: File Transfer');

			header("Content-length: $rozmiar");
			header("Content-type: $typ_pliku");
#			header("Content-Transfer-Encoding: binary");
			header('Content-Disposition: attachment; filename="'.$nnpliku.'"');
			ob_clean();
			flush();
			echo $plik; 
			exit;
		}
	else 
		{
			gtfo();
		}
}
else 
{	
	gtfo();
}

?>
