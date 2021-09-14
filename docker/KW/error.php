<?php
	include("include/config.php");
	session_start();
	include("include/if.php");

echo '
<html>
<head>
	<link href="style.css" rel=\'stylesheet\' media="all">
	<meta charset="UTF-8">
    <title>Korespondencja wewnętrzna :: BŁĄD !!!</title>
</head>
		<body class="gradient">';
include_once 'include/topmenu.php';			
	echo '
<br><center>
			<div class="card1">
				<div class="header">
					<div class="textshadow">
						Wystąpił błąd!
					</div>
				</div>
        	    <div class="container2">
	                <div class="textshadow">
						<center>' .$_SESSION['leerror']. ''
;	