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
	<title>BerwaShop MIS</title>
</head>
<body>
	<?php include 'sidebar.php'; ?>
	<div class="main-content">
			<?php if(isset($_GET['task']) == 'sell'): ?>
			<h3>ADMIN Dashboard &rarr; Sell Product</h3>
			<hr>
			<div class="log_content">
				<div class="login-form">
					<h2>Sell Product: <?=$_GET['n'];?></h2>
					<form action="inc/process.php" method="POST">
						<input type="text" name="nm" readonly value="<?=$_GET['n'];?>">
						<input type="hidden" name="q" value="<?=$_GET['qtt'];?>">
						<input type="hidden" name="pc" value="<?=$_GET['p_c'];?>">
						<input type="hidden" name="id" value="<?=$_GET['i'];?>">
						<input type="hidden" name="p" value="<?=$_GET['p'];?>">
						<input type="text" name="u_qtt" placeholder="Quantity to be sold..." required>
						<input type="text" name="u_price" value="<?=$_GET['p'];?>" placeholder="Price per unit..." required>
						<button type="submit" class="ok" name="product_out">Sell Product</button>
					</form>
				</div>
			</div>
		<?php else: ?>
			<h3>ADMIN Dashboard &rarr; Product-out</h3>
			<hr>
			<div class="table">
				<table cellspacing="0">
					<tr>
						<th>N <sup><u>o</u></sup></th>
						<th>Product Name</th>
						<th>Date</th>
						<th>Quantity</th>
						<th>Unit Price</th>
						<th>Total Price</th>
					</tr>
					<?php
					$getData = "SELECT * FROM productout, product WHERE product.ProductCode = productout.ProductCode ORDER BY id DESC";
					$fetch = $db->query($getData);
					$total_p_in = "SELECT SUM(TotalPrice) AS sum FROM productout";
					$process = $db->query($total_p_in);
					$sum = $process->fetch_assoc();

					if ($fetch->num_rows > 0) {
						$n = 1;
					  	while ($product = $fetch->fetch_assoc()) {
					  		$id = $product['id'];
					  		$p_code = $product['ProductCode'];
					  		$name = $product['ProductName']; 
					  		$qtt = $product['Quantity'];
					  		$dt = $product['Date'];
					  		$up = $product['UniquePrice'];
					  		$tp = $product['TotalPrice'];
					  		?> 
					  		<tr>
								<td><?=$n++;?></td>
								<td><?=$name;?></td>
								<td><?=$dt;?></td>
								<td><?=$qtt;?></td>
								<td><?=$up;?></td>
								<td><?=$tp;?></td>
							</tr>
					  		<?php
					  	}
					  	echo "<tr>
								<td colspan='5'>Summation</td>
								<td><b>".$sum['sum']." Frw</b></td>
							</tr>";
					  } else {
					  	echo '<tr><td colspan="6">No Data to show.</td></tr>';
					  }
					?>
				</table>
			</div>
	</div>
<?php endif; ?>
</body>
</html>

