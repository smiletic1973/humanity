<?php 
session_start();
include 'konekcija.php'; 


$id =$_GET["user"];

	$sql = "SELECT * FROM users WHERE id_user=".$id."";
	$tiket = mysql_query($sql);
	$korisnik = mysql_fetch_assoc($tiket);


	$sql = "SELECT SUM(broj_dana) as total FROM slobodni_dani WHERE (user_id = '".$id."' AND odobreno = 1)";
	$ticket = mysql_query($sql);
	$row = mysql_fetch_assoc($ticket);

	$dani = $row['total'];

	$ukupno_dana = 20 - $dani;
	


if($_POST){
	
	$days = $_POST["days"];

	$sql = "INSERT INTO slobodni_dani (id_dani, user_id, broj_dana, odobreno) VALUES (NULL, '".$id."', '".$days."', 0)";
	mysql_query($sql);	
	
	header ('Location:interno.php?user=' . $id);
}
?>


Dear <?php echo $korisnik["username"]; ?>,<br /><br />


<?php if ($korisnik["privilegija"] == 0) { // user nalog ?>

<?Php 

	$request = array(); 
	$sql = "SELECT * FROM slobodni_dani WHERE odobreno = 0";
	$tiket = mysql_query($sql);
	while($row = mysql_fetch_assoc($tiket)){ 
	$request[] = $row; 
	}

if ($request == NULL) { // ako nema dana na cekanju
?>

Days you already spent: <?php if ($dani == NULL) { echo '0'; }else{ echo $dani; } ?><br />
Remaining vacation days: <?php echo $ukupno_dana; ?> <br /><br /><br />


<?php if ($ukupno_dana == 0) { ?>

<strong>You spent all days of your vacation!</strong>

<?php }else{ ?>

<strong>Vacation request:</strong><br /><br />

<form action="interno.php?user=<?php echo $id; ?>" method="post">

I want to use 

<select name="days">
                <?php for($i=1;$i<$ukupno_dana+1;$i++) { ?>
                	<option value="<?php echo $i ?>"><?php echo $i ?></option>
                <?php } ?>
                </select> 
days of my vacation.<br /><br />

<input id="submit" type="submit" value="Send request!"> 

</form>    

<?php } ?>

<?php }else{ ?>

Your requested vacation days are sent! Please wait a few days for response!

<?php } ?>

<?php }else{ // administratorski nalog ?>



<?php 
	$request = array(); 
	$sql = "SELECT * FROM slobodni_dani JOIN users ON slobodni_dani.user_id = users.id_user WHERE odobreno = 0";
	$tiket = mysql_query($sql);
	while($row = mysql_fetch_assoc($tiket)){ 
	$request[] = $row; 
	}
?>

<br /><br />

<?php if ($request == NULL) { ?>

<strong>No new requests!</strong>

<?php }else{ ?>

<table rules="all" width="30%">
	<tr>
    	<td style="font-weight:bold;" width="30%">User</td>
        <td style="font-weight:bold;" align="center">Requested days</td>
        <td style="font-weight:bold;" align="center">Accept / Reject</td>
    </tr>
    
<?php for ($i=0; $i<sizeof($request); $i++) { ?>   
	<tr>
    	<td><?php echo $request[$i]["username"]; ?></td>
        <td align="center"><?php echo $request[$i]["broj_dana"]; ?></td>
        <td align="center">
        <a href="accept.php?user=<?php echo $id; ?>&id_pro=<?php echo $request[$i]["id_dani"]; ?>">Accept</a> / 
        <a href="reject.php?user=<?php echo $id; ?>&id_pro=<?php echo $request[$i]["id_dani"]; ?>">Reject</a>
        </td>
    </tr>
<?php } ?>    

</table>




<?php } ?>

<?php } ?>

<br /><br /><br />
<?php if(isset($_SESSION["user"])){ ?>
  	<button style="font-weight:bold;"><a href="logout.php" style="font-weight:bold;">Logout</a></button>
<?php } ?>
