<?php 
	$db = new mysqli("localhost", "root", "", "berwashop");
	$check = ($db)? "": die("Connection Problem to the server.");
	echo $check;
?>