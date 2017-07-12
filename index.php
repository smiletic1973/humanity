<?php 
session_start();
include 'konekcija.php'; 
?>


<?php

if ($_POST){
	$username1 = $_POST["username1"];
	$sifra = $_POST["sifra"];
	$sifra_cript = md5($sifra);
	
	
	if ($username1 != '') {
		
		
		if ($sifra != '') {
		
			$admin = array();
			$sql = "SELECT * FROM users WHERE username = '".$username1."' AND pass = '".$sifra_cript."'";
			$ticket = mysql_query($sql);
			while($row = mysql_fetch_assoc($ticket)){
				$admin[] = $row;
			}

			
			if(sizeof($admin) > 0){
				$_SESSION["user"] = $admin[0];
				
				header ('Location: interno.php?user=' . $_SESSION["user"]["id_user"]);
			}else{
				echo 'Nisu ispravni podaci!';
			}
		
		}else {
			echo 'Unesite sifru!';
		}
	
	}else{
		echo 'Unesite username!';
		}
		
}

?>

<h1 style="font-weight:bold; font-size:2em;">Humanity - test</h1>

Za pristup stranici user-a koji treba da zatrazi dane za godisnji odmor koristite <br />
<strong>Username/Password: user</strong><br /><br />
Za pristup stranici na kojoj se odobravaju/odbijaju dani pristupiti sa <br />
<strong>Username/Password: admin</strong><br /><br /><br />


<form action="index.php" method="post">
	
<input type="text" name="username1" placeholder="Username" />  <br /><br />  
<input type="password" name="sifra" placeholder="Password" />  <br /><br />

<input type="submit" value="Login!" />



</form>


