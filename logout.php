<link rel="stylesheet" type="text/css" href="css/main.css">
<?php 
	session_start();
	session_unset();
	session_destroy();
	setcookie('Berwa-essential-data', 'berwa_admin', time() - (86400 * 30), "/");
	echo '<div class = "message success"><p>You have logged out.</p></div>';
	echo '<meta http-equiv="refresh"; content="3 url=index.php">';

 ?>