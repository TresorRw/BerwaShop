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
			<h3>ADMIN Dashboard &rarr; Product-in</h3>
			<hr>
			<div class="log_content">
				<div class="login-form">
					<h2>Add product-in</h2>
					<form action="inc/process.php" method="POST">
						<select name="stock">
							<option value="">Select Product</option>
							<?php
						$getData = "SELECT * FROM product ORDER BY ProductCode DESC";
						$fetch = $db->query($getData);
						if ($fetch->num_rows > 0) {
							$n = 1;
						  	while ($product = $fetch->fetch_assoc()) {
						  		$id = $product['ProductCode'];
						  		$name = $product['ProductName'];
						  		?> 
						  		<option value="<?=$id;?>"><?=$name;?></option>
						  		<?php
						  	}
						  }  
						?>
						</select>
						<input type="text" name="qtt" placeholder="Delivered quantity..." autofocus required>
						<input type="text" name="up" placeholder="Price per unit ..." required>
						<button type="submit" class="ok" name="product_in">Add to stock</button>
					</form>
				</div>
			</div>
			<div class="table">
				<table cellspacing="0">
					<tr>
						<th>N <sup><u>o</u></sup></th>
						<th>Product Name</th>
						<th>Date</th>
						<th>Quantity</th>
						<th>Unit Price</th>
						<th>Total Price</th>
						<th>Sell Product</th>
					</tr>
					<?php
					$getData = "SELECT * FROM productin, product WHERE product.ProductCode = productin.ProductCode ORDER BY id DESC";
					$fetch = $db->query($getData);
					$total_p_in = "SELECT SUM(TotalPrice) AS sum FROM productin";
					$process = $db->query($total_p_in);
					$sum = $process->fetch_assoc();

					if ($fetch->num_rows > 0) {
						$n = 1;
					  	while ($product = $fetch->fetch_assoc()) {
					  		$p_id = $product['id'];
					  		$id = $product['ProductCode'];
					  		$name = $product['ProductName']; 
					  		$qtt = $product['Quantity'];
					  		$dt = $product['Date'];
					  		$up = $product['UniquePrice'];
					  		$tp = $product['TotalPrice'];
					  		$sell = '<a class="btn-link up" href="productout.php?task=sell&p_c='.$id.'&i='.$p_id.'&n='.$name.'&qtt='.$qtt.'&p='.$up.'">Sell</a>';
					  		?> 
					  		<tr>
								<td><?=$n++;?></td>
								<td><?=$name;?></td>
								<td><?=$dt;?></td>
								<td><?=$qtt;?></td>
								<td><?=$up;?></td>
								<td><?=$tp;?></td>
								<td><?=$sell;?></td>
							</tr>
					  		<?php
					  	}
					  	echo "<tr>
								<td colspan='5'>Summation</td>
								<td><b>".$sum['sum']." Frw</b></td>
							</tr>";
					  }  else {
					  	echo '<tr><td colspan="7">No Data to show.</td></tr>';
					  }
					?>
				</table>
			</div>
	</div>
</body>
</html>

