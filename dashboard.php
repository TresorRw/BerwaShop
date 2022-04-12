<link rel="stylesheet" href="css/main.css">
<?php  
	session_start();
	include 'inc/db.php';
	if (!isset($_SESSION['id']) && !isset($_COOKIE['Berwa-essential-data'])) {
		echo '<div class = "message error"><p>Please login first.</p></div>';
		echo '<meta http-equiv="refresh"; content="1 url=index.php">';
		die();
	}
	$total = "SELECT COUNT(*) AS total FROM product";
	$d = $db->query($total);
	$data = $d->fetch_assoc();
	$q = "SELECT count(*) AS total FROM productin";
	$w = $db->query($q);
	$f = $w->fetch_assoc();
	$e = "SELECT count(*) AS total FROM productout";
	$r = $db->query($e);
	$t = $r->fetch_assoc();
	$tin = "SELECT SUM(TotalPrice) AS total FROM productin";
	$tin_q = $db->query($tin);
	$tin_r = $tin_q->fetch_assoc();
	$tout = "SELECT SUM(TotalPrice) AS total FROM productout";
	$tout_q = $db->query($tout);
	$tout_r = $tout_q->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BerwaShop MIS</title>
</head>
<body>
	<?php include 'sidebar.php'; ?>
	<div class="main-content">
		
		<?php if (isset($_GET['add']) == 'product'): ?>
			<h3>ADMIN Dashboard &rarr; Register new product</h3>
			<hr>
			<div class="log_content">
			<div class="login-form">
				<h2>ADD Product</h2>
				<form action="inc/process.php" method="POST">
					<input type="text" name="p_name" placeholder="Product name..." autofocus required>
					<button type="submit" class="ok" name="save_prod">Keep</button>
				</form>
			</div>
		</div>
		<?php else: ?>
			<h3>ADMIN Dashboard &rarr; Stock Status</h3>
			<hr>
			<div class="stock-status">
			<div class="state">
				<p class="text">Total Products</p> <br>
				<strong><?=$data['total'];?></strong>
			</div>
			<div class="state">
				<p class="text">Total Product-in</p> <br>
				<strong><?=$f['total'];?></strong>
			</div>
			<div class="state">
				<p class="text">Total Product-out</p> <br>
				<strong><?=$t['total'];?></strong>
			</div>
			<div class="state">
				<p class="text">Total Product-in amount</p> <br>
				<strong><?=$tin_r['total'];?> Frw</strong>
			</div>
			<div class="state">
				<p class="text">Total Product-out amount</p> <br>
				<strong><?=$tout_r['total'];?> Frw</strong>
			</div>
		</div>
		<?php endif; ?> 
	</div>
</body>
</html>

