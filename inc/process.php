<link rel="stylesheet" href="../css/main.css">
<?php session_start();
	include 'db.php';
	function validateData($field) {
		$field = trim($field);
		$field = stripslashes($field);
		$field = htmlspecialchars($field);

		return $field;
	}

	if(isset($_POST['log_user'])) {
		$username = validateData($_POST['username']);
		$password = validateData($_POST['password']);
		$password = md5($password);

		$getUser = "SELECT * FROM shopkeeper WHERE UserName = '$username' AND Password = '$password'";
		$fetch = $db->query($getUser);
		if ($fetch->num_rows > 0) {
			while ($user = $fetch->fetch_assoc()) {
				$id = $user['ShopkeeperId'];
				$name = $user['Username'];
				$pwd = $user['Password'];

				$_SESSION['name'] = $name;
				$_SESSION['id'] = $id;
				setcookie("Berwa-essential-data", $name, time() + (86400 *30),"/");
				echo '<div class = "message success"><p>Login Successfully</p></div>';
				echo '<meta http-equiv="refresh"; content="3 url=../dashboard.php">';
			}
		} else {
			echo '<div class = "message error"><p>No user found with provided data</p></div>';
			echo '<meta http-equiv="refresh"; content="3 url=../">';
		}
		die();
	}
	if(isset($_POST['save_prod'])) {
		$prod_name = validateData($_POST['p_name']);

		$saveProd = "INSERT INTO product VALUES ('','$prod_name')";
		$save = $db->query($saveProd);
		if ($save) {
				echo '<div class = "message success"><p>Product Added Successfully</p></div>';
				echo '<meta http-equiv="refresh"; content="3 url=../dashboard.php">';
		} else {
			echo '<div class = "message error"><p>Error occured <br> Try again</p></div>';
			echo '<meta http-equiv="refresh"; content="3 url=../dashboard.php?add=product">';
		}
		die();
	}
	if(isset($_GET['task'])=='delete') {
		@$id = $_GET['i'];
		$delProd = "DELETE FROM product WHERE ProductCode = '$id'";
		$del = $db->query($delProd);
		if ($del) {
			echo '<div class = "message success"><p>Product Deleted Successfully</p></div>';
			echo '<meta http-equiv="refresh"; content="3 url=../manage_products.php">';
		} else {
			echo '<div class = "message error"><p>Error occured <br> Try again</p></div>';
			echo '<meta http-equiv="refresh"; content="3 url=../manage_products.php">';
		}
		die();
	}
	if(isset($_POST['update'])) {
		$p_name = validateData($_POST['p_name']);
		$ids = validateData($_POST['id']);

		$upProd = "UPDATE product SET ProductName = '$p_name' WHERE ProductCode = '$ids'";
		$save_cahnges = $db->query($upProd);
		if ($save_cahnges) {
			echo '<div class = "message success"><p>Product Updated Successfully</p></div>';
			echo '<meta http-equiv="refresh"; content="3 url=../manage_products.php">';
		} else {
			echo '<div class = "message error"><p>Error occured during updating <br> Try again!</p></div>';
			echo '<meta http-equiv="refresh"; content="3 url=../manage_products.php">';
		}
		die();
	}
	if(isset($_POST['product_in'])) {
		$p_code = validateData($_POST['stock']);
		$p_qtt = validateData($_POST['qtt']);
		$p_up = validateData($_POST['up']);
		$total_price = $p_qtt * $p_up;

		$saveProd = "INSERT INTO productin (ProductCode, Quantity, UniquePrice, TotalPrice) VALUES ('$p_code', '$p_qtt', '$p_up', '$total_price')";
		$save = $db->query($saveProd);
		if ($save) {
				echo '<div class = "message success"><p>Product Stocked Successfully</p></div>';
				echo '<meta http-equiv="refresh"; content="3 url=../productin.php">';
		} else {
			echo '<div class = "message error"><p>Error occured <br> Try again</p></div>';
			echo '<meta http-equiv="refresh"; content="3 url=../productin.php">';
		}
		die();
	}
	if(isset($_POST['product_out'])) {
		$name = validateData($_POST['nm']);
		$p_qtt = validateData($_POST['q']);
		$code = validateData($_POST['pc']);
		$id = validateData($_POST['id']);
		$p_price = validateData($_POST['p']);
		$u_qtt = validateData($_POST['u_qtt']);
		$u_price = validateData($_POST['u_price']);
		// Checking if order is minimum the stock
		if ($p_qtt >= $u_qtt && $p_price >= $u_price) {
			$remained_quantity = $p_qtt - $u_qtt;
			$user_order_total = $u_qtt * $u_price;
			$remained_total_price = ($p_qtt * $p_price) - $user_order_total;
			$save = "UPDATE productin SET Quantity = '$remained_quantity', TotalPrice = '$remained_total_price' WHERE id = '$id'";
			$query = $db->query($save);
			$save_out = "INSERT INTO productout (ProductCode, Quantity, UniquePrice, TotalPrice) VALUES ('$code', '$u_qtt', '$p_price', '$user_order_total')";
			$z = $db->query($save_out);
			if ($z && $query) {
			 	echo '<div class = "message success"><p>Product Sold Successfully</p></div>';
				$back = '../productout.php';
				echo '<div class="slip">
						<h1>BerwaShop</h1>
						<p><b>Product Name: </b>'.$name.'</p>
						<p><b>Product Quantity: </b>'.$u_qtt.'</p>
						<p><b>Product Unit Price: </b>'.$u_price.' Frw</p>
						<p><b>Product Total Price: </b>'.$user_order_total.' Frw</p>
						<p><b>Transaction Date & time: </b>'.date('l d/m/Y h:i:s A').'</p>
						<p class="thank">Thank you for shopping with us.</p>
						<button class="ok" onclick="window.print();">Print Slip</button>
						<button class="ok"><a href="../dashboard.php">Go Back</a></button>
					</div>'; 
			} else {
				echo '<div class = "message error"><p>Please enter less values.<br> Try again</p></div>';
				echo '<meta http-equiv="refresh"; content="3 url=../productin.php">';
			}
		}
		die();
	}
	if(isset($_POST['generate_report'])) {
		$from = validateData($_POST['from']);
		$to = validateData($_POST['to']);

		// Product in
		$getData = "SELECT * FROM product, productin WHERE `Date` BETWEEN '$from' AND '$to' AND product.ProductCode = productin.ProductCode";
		$fetchData = $db->query($getData);
		$tin = "SELECT SUM(TotalPrice) AS total FROM productin";
		$tin_q = $db->query($tin);
		$tin_r = $tin_q->fetch_assoc();
		if ($fetchData -> num_rows > 0) {
			$n =1;?>
			<div class="table">
				<button class="ok" onclick="window.print();">Print Report</button>
				<button class="ok"><a href="../dashboard.php">Go Back</a></button>				
				<table cellspacing="0">
					<tr><th colspan="6">Product-in Transaction Done From: <?=$from;?> To: <?=$to;?></th></tr>
					<tr>
						<th>N <sup><u>o</u></sup></th>
						<th>Product Name</th>
						<th>Date</th>
						<th>Quantity</th>
						<th>Unit Price</th>
						<th>Total Price</th>
					</tr><?php 
			while ($data = $fetchData -> fetch_assoc()) {
				$id = $data['id'];
				$name = $data['ProductName'];
				$Quantity = $data['Quantity'];
				$date = $data['Date'];
				$unit_price = $data['UniquePrice'];
				$total_price = $data['TotalPrice'];
				?>
				<tr>
					<td><?=$n++;?></td>
					<td><?=$name;?></td>
					<td><?=$date;?></td>
					<td><?=$Quantity;?></td>
					<td><?=$unit_price;?></td>
					<td><?=$total_price;?></td>
				</tr>
				<?php 
			}
			echo "<tr>
					<td colspan='5'>Summation</td>
					<td><b>".$tin_r['total']." Frw</b></td>
				</tr>";
			echo '</table></div>';
		} else {
			echo '<div class = "message error"><p>No Transaction found with provided date <strong>Use another dates.</strong></p></div>';
		}
		// Product-out
		$get_out = "SELECT * FROM product, productout WHERE productout.Date BETWEEN '$from' AND '$to' AND product.ProductCode = productout.ProductCode";
		$fetchOut = $db->query($get_out);
		$tout = "SELECT SUM(TotalPrice) AS total FROM productout";
		$tout_q = $db->query($tout);
		$tout_r = $tout_q->fetch_assoc();
		if ($fetchOut -> num_rows > 0) {
			$n =1;?>
			<div class="table">
				<table cellspacing="0">
					<tr>
						<th colspan="6">Product-out (Sold) Transaction Done From: <?=$from;?> To: <?=$to;?></th>
					</tr>
					<tr>
						<th>N <sup><u>o</u></sup></th>
						<th>Product Name</th>
						<th>Date</th>
						<th>Quantity</th>
						<th>Unit Price</th>
						<th>Total Price</th>
					</tr><?php 
			while ($data = $fetchOut -> fetch_assoc()) {
				$id = $data['id'];
				$name = $data['ProductName'];
				$Quantity = $data['Quantity'];
				$date = $data['Date'];
				$unit_price = $data['UniquePrice'];
				$total_price = $data['TotalPrice'];
				?>
				<tr>
					<td><?=$n++;?></td>
					<td><?=$name;?></td>
					<td><?=$date;?></td>
					<td><?=$Quantity;?></td>
					<td><?=$unit_price;?></td>
					<td><?=$total_price;?></td>
				</tr>
				<?php 
			}
			echo "<tr>
					<td colspan='5'>Summation</td>
					<td><b>".$tout_r['total']." Frw</b></td>
				</tr>";
			echo '</table></div>';
		} else {
			echo '<div class = "message error"><p>No Transaction found with provided date<strong>Use another 	dates.</strong></p></div>';
			echo '<meta http-equiv="refresh"; content="3 url=../report.php">';
		}
		die();
	}
?>