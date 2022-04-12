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
		<?php if(isset($_GET['task'])== 'update'): ?>
			<?php $id = $_GET['i'];
			$name = $_GET['name'];
			?>
			<h3>ADMIN Dashboard &rarr; Modify: <?=$name;?></h3>
			<hr>
			<div class="log_content">
			<div class="login-form">
				<h2>Update product</h2>
				<form action="inc/process.php" method="POST">
					<input type="hidden" name="id" value="<?=$id; ?>">
					<input type="text" name="p_name" placeholder="New Product Name..." autofocus required>
					<button type="submit" class="ok" name="update">Save Changes</button>
				</form>
			</div>
		</div>
		<?php else: ?>
			<h3>ADMIN Dashboard &rarr; All products</h3>
			<hr>
			<div class="table">
				<table cellspacing="0">
					<tr>
						<th>N <sup><u>o</u></sup></th>
						<th>Product Name</th>
						<th>Action</th>
					</tr>
					<?php
					$getData = "SELECT * FROM product ORDER BY ProductCode DESC";
					$fetch = $db->query($getData);
					if ($fetch->num_rows > 0) {
						$n = 1;
					  	while ($product = $fetch->fetch_assoc()) {
					  		$id = $product['ProductCode'];
					  		$name = $product['ProductName']; 
					  		$ed = '<a class="btn-link up" href="manage_products.php?task=update&i='.$id.'&name='.$name.'">Edit</a> ';
					  		$del = '<a class="btn-link del" href="inc/process.php?task=delete&i='.$id.'">Delete</a>';
					  		?> 
					  		<tr>
								<td><?=$n++;?></td>
								<td><?=$name;?></td>
								<td><?=$ed .$del;?></td>
							</tr>
					  		<?php
					  	}
					  }  else {
					  	echo '<tr><td colspan="4">No Data to show.</td></tr>';
					  }  
					?>
				</table>
			</div>
		<?php endif; ?>
	</div>
</body>
</html>

