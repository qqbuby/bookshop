<?php
$con = mysql_connect("localhost","root","root");
if(!$con){
	die("Error Connected:".mysql_error());
}
mysql_select_db("bookshop",$con) or die("Could not select DB");
?>
