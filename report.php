<link rel="stylesheet" href="css/main.css">
 <?php
	session_start();
	include 'inc/db.php';
	if (!isset($_SESSION['id']) && !isset($_COOKIE['Berwa-essential-data'])) {
		echo '<div class = "message error"><p>Please login first.</p></div>';
		echo '<meta http-equiv="refresh"; content="1 url=index.php">';
		die();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Report Generator &rarr; BerwaShop MIS</title>
</head>
<body>
	<?php include 'sidebar.php'; ?>
	<div class="main-content">
			<h3>ADMIN Dashboard &rarr; Report Generation</h3>
			<hr>
			<div class="log_content">
				<div class="login-form">
					<h2>Generate report by dates</h2>
					<small>Format: Year/Month/Date Hour:Minutes:Seconds</small>
					<form action="inc/process.php" method="POST">
						<input type="text" name="from" placeholder="Date from..." autofocus required>
						<input type="text" name="to" placeholder="Date to..." required>
						<button type="submit" class="ok" name="generate_report">Generate report</button>
					</form>
				</div>
			</div>
	</div>
</body>
</html>

