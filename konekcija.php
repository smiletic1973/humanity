<?php


$server   = "localhost";
$database = "humanity";
$username = "root";
$password = "";

$mysqlConnection = mysql_connect($server, $username, $password);
if (!$mysqlConnection)
{
  echo "Please try later.";
}
else
{
mysql_select_db($database, $mysqlConnection);
mysql_query("SET NAMES  UTF8", $mysqlConnection);
}


?>