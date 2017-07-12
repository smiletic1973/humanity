<?php 
session_start();
include 'konekcija.php'; 

	
$user = $_GET["user"];
$id_pro = $_GET["id_pro"];

		$sql = "UPDATE slobodni_dani SET odobreno = 1 WHERE id_dani = '".$id_pro."'";
					
		mysql_query($sql);


header('Location: interno.php?user=' .$user);



?>
