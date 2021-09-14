<?php

if(!isset($error)){
	$error="";
}
   include("include/config.php");
   session_start();
   $_NEWPOST = array_map("strip_tags", $_POST);

   session_regenerate_id(true); 

    #default value for error - aby wyswietlanie bez bledu bylo ok - nie podnosi linii
    $error = "";
   
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$myusername = mysqli_real_escape_string($conn,$_NEWPOST['username']);
		$mypassword = mysqli_real_escape_string($conn,$_NEWPOST['password']); 
		$sql = 'SELECT password FROM Pracownik WHERE username = "'.mysqli_escape_string($conn,$myusername).'"';
		$usergroup = 'SELECT komorg_id from Pracownik WHERE username="'.mysqli_escape_string($conn,$myusername).'"';
		$userid = 'SELECT id from Pracownik WHERE username="'.mysqli_escape_string($conn,$myusername).'"';
		$groupname = 'SELECT K.nazwa FROM komorg K, Pracownik P WHERE P.username = "'.mysqli_escape_string($conn,$myusername).'" and P.komorg_id = K.ID';

		$userid_result = mysqli_query($conn,$userid);
		$group_result = mysqli_query($conn,$usergroup);
		$groupname_result = mysqli_query($conn,$groupname);
		
		$grow = mysqli_fetch_array($group_result,MYSQLI_ASSOC);
		$idrow = mysqli_fetch_array($userid_result,MYSQLI_ASSOC);
		
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$count = mysqli_num_rows($result);
		$groupname_result1 = mysqli_fetch_array($groupname_result,MYSQLI_ASSOC);

		
		if($count == 1) 
		{
			if (password_verify($mypassword, mysql_escape_string($row['password'])))
			{
				$_SESSION['dbusername'] = mysql_escape_string($myusername);
				$_SESSION['group'] = mysql_escape_string($grow['komorg_id']);
				$_SESSION['userid'] = mysql_escape_string($idrow['id']);
				$_SESSION['groupname'] = mysql_escape_string($groupname_result1['Nazwa']);
				if($_SESSION['group'] == "3") 
				{
					echo $_SESSION['group'];
					header("location: pracownik.php");
				}
				else 
				{
					echo "USER";
					header("location: szukaj.php");
				}
			}
			else
			{ 
				#				$error = "<div class=\"armatextshadow\"> Niewłaściwe hasło lub nieznany użytkownik!</div>";		
				$error ='<div id="dialog"><br><b>Błąd logowania!</b><br><br>
				    Niewłaściwe hasło, nieznany użytkownik lub konto użytkownika jest zablokowane.
				        </div>';
			}
		}
		else {
			#	$error = "<div class=\"armatextshadow\">Niewłaściwe hasło lub nieznany użytkownik!</div>";
					$error ='<div id="dialog"><br><b>Błąd logowania!</b><br><br>
						    Niewłaściwe hasło, nieznany użytkownik lub konto użytkownika jest zablokowane.
						        </div>';
			

			}
	}
	
echo '<html>
<link href="style.css" rel=\'stylesheet\' media="all">
<link rel="shortcut icon" href="favicon.ico" />
<meta charset="UTF-8">
   <head>
      <title>Korespondencja wewnętrzna :: Logowanie</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
			);
         }
         
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         
         .box {
            border:#666666 solid 1px;
         }
      </style>
      <script src="../lib/jquery-3.1.1.min.js"></script>
        <script src="../lib/jquery-ui.js"></script>
		<script>
        $( function() {
        $( "#dialog" ).dialog({ closeText: "Zamknij", hide: { effect: "drop", duration: 500 },  show: { effect: "drop", duration: 500 }, modal: true,  open: function(event, ui)
		{ setTimeout("$(\'#dialog\').dialog(\'close\')",3000);}
		});
        } );
  </script> 
   </head>
<body class="gradient" ><br>
      <div align = "center"><br><br><br>
         <div class="card2" style="width: 600px; border: 10px solid dimgrey; border-radius: 8px;">      
			<div class="red_header2">
				<div class="textshadow"><br>
					<b>Dziennik korespondencji</b><br><br>
				</div>
			</div>
			<div class="container2" style="background: #8c8c8c "><br>Wpisz dane logowania<br><br>
            <form action = "" method = "post">
			<center>
			<table class="a1">
			<tr>	
					<td class="a1">Nazwa użytkownika: <br><input type = "text" name = "username" required="yes" autocomplete="off"/></td>
			</tr>
			<tr>
					<td class="a1">Hasło: <br><input type = "password" name = "password" autocomplete="off"/></td>
			</tr>
			<tr>
					<td class="a1"><center><input type = "submit" value = "" style="background: #3d3d5c url(img/key.png) no-repeat center;"/></td>
			</tr>
			</table>
			</form>
            <div style = "font-size:11px; color:yellow; margin-top:5px">';
			echo $error;
			echo '</div>
            </div>
		</div><br><br>
		<center><div class="trans">2016/2017 JM</div></center>
   </body>
</html>
';
?>
