<link rel="stylesheet" href="css/main.css">
<?php  
	session_start();
	if (isset($_SESSION['id']) || isset($_COOKIE['Berwa-essential-data'])) {
		echo '<div class = "message success"><p>You\'re being redirected to dashboard.</p></div>';
		echo '<meta http-equiv="refresh"; content="1 url=dashboard.php">';
		die();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Smart Admin  ||Berwa Shop</title>
</head>
<body>
	<div class="main-home">
		<div class="log_content">
			<h2 class="title">Welcome To BerwaShop SMART Admin</h2>
			<div class="login-form">
				<h2>Login</h2>
				<hr>
				<form action="inc/process.php" method="POST">
					<input type="text" name="username" placeholder="Username..." autofocus required>
					<input type="password" name="password" placeholder="Password..." required>
					<button type="submit" class="ok" name="log_user">Login</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>