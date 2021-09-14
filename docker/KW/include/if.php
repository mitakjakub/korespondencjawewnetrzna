<?php

if (!isset($_SESSION['dbusername'])) {
    header("Location: login.php");
	die(); 
}
 if ($conn->connect_error) {
	 $leerror = "<table><th>Nie mo¿na nawi¹zaæ po³¹czenia z baz¹ danych.<br>Proszê spróbowaæ ponownie póŸniej.<br>Jeœli problem wci¹¿ wystêpuje to nale¿y poinformowaæ administratora aplikacji.</th></table>";
	 $_SESSION['leerror'] = $leerror;
	 header("Location: error.php");
     die("" . $conn->connect_error);
} 

if (($_SESSION['group']) == 3) {
	$aaaa="1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16";
}
else {
	$aaaa = $_SESSION['group'];
}
   
$_NEWPOST = array_map("strip_tags", $_POST);
$_NEWGET = array_map("strip_tags", $_GET);
?>