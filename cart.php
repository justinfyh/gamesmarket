<?php

if ( !isset( $_SESSION ) ) {
	session_start();
}

spl_autoload_register( function ( $class ) {
	include_once( 'db.php' );
} );

$obj = new db_gamesmarket;

$status = "";
$currentorderid = $obj->getcurrentorderid('orders');

if (!isset($_SESSION['loggedin'])) {
	session_start();
	header('Location: login.php');
	$_SESSION['cartlogin'] = "You must sign in to be able to access the cart";
	exit();
}


$itemsquantity = 0;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Cart - Syndicate Games</title>
	<link rel="stylesheet" href="css/indexstyles.css?<?php echo time(); ?>">
	<link rel="stylesheet" href="css/cartstyles.css?<?php echo time(); ?>">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
<!--		Loop through the cart to get cart count -->
		<?php if (isset($_SESSION['cart'])) {foreach ($_SESSION['cart'] as $product) {
				$itemsquantity += 1;
				$_SESSION['itemsquantity'] = $itemsquantity;
			} }?>
		
		<?php include 'nav.php'; ?>
		
		
		<div class="sectionheader">
			<p>Your Shopping Cart</p>
			<div class="cartstatus"><p><?php if (isset($cartstatus)) echo $cartstatus ?></p></div>
		</div>
		<div class="cart">
			<?php 
			if (isset($_SESSION['cart'])) {
				$grosstotal = 0;
				$nettotal = 0;
				
			
			?>
			
			<table class="table">
<!--			<tbody>-->
				<tr>
					<th></th>
					<th class="alignleft">Item</th>
					<th class="alignright unitpricecol">Unit Price</th>
					<th>Quantity</th>
					<th class="alignright pricecol">Total Price</th>
				</tr>
				
				<?php foreach ($_SESSION['cart'] as $product) { 
						if($product['onsale'] == 1) {
							$price = ($product['discountedprice'] * $product['quantity']);
						} else {
							$price = ($product['price'] * $product['quantity']);
						}
				$product['image'] = str_replace('.jpg', 'preview.jpg', $product['image']);
		
		?>
				
				<tr>
				<td><img class="product-image" src="<?php echo $product['image']; ?>" alt=""></td>
					
				
				<td class="alignleft"><?php echo $product['title']; ?>
					
					<form action="controller.php" method="post">
						<input type="hidden" name="code" value="<?php echo $product['code']; ?>">
						<input type="hidden" name="id" value="<?php echo $product['productid']; ?>">
						<input type="hidden" name="action" value="remove">
						<button type="submit" class="remove">Remove Item</button>
					</form>	
				</td>
					
					
					<td class="alignright unitpricecol"><?php if($product['onsale'] == 1){ echo '<p class="discounted">$'.$product['price'].'</p>  $'.$product['discountedprice']; } else { echo ' $'.$product['price']; }  ?></td>
					
					
					
					
					<td class="aligncenter">
					<form action="controller.php" method="post">
						<input type="hidden" name="code" value="<?php echo $product['code']; ?>">
						<input type="hidden" name="action" value="change">
						<select name="quantity" class="itemquantity" onchange="this.form.submit()">
							<option  <?php if ($product['quantity'] == 1) echo "selected "; ?> value="1">1</option>
							<option <?php if ($product['quantity'] == 2) echo "selected "; ?> value="2">2</option>
							<option <?php if ($product['quantity'] == 3) echo "selected "; ?> value="3">3</option>
							<option <?php if ($product['quantity'] == 4) echo "selected "; ?> value="4">4</option>
							<option <?php if ($product['quantity'] == 5) echo "selected "; ?> value="5">5</option>
						</select>
					</form>
					</td>
					
					<td class="alignright pricecol"><?php echo " $".number_format((float)$price, 2, '.', ''); ?></td>
					
					
						
				</tr>
				
				<?php
				
				$grosstotal += ($product['price'] * $product['quantity']);
				$nettotal += ($price);
				$savings = $grosstotal - $nettotal;
//				$_SESSION['itemsquantity'] = $itemsquantity;
				
				$_SESSION['carttotal'] = $nettotal;
				}
				?>
				
				<tr>
					<td class="alignleft"><span style="padding: 0 1rem;"><strong># Of Items</strong></span> <?php echo $itemsquantity ?></td>
					<td></td>
					<td colspan="1"  class="alignright unitpricecol"><span style="padding: 0 1rem;"><strong>You Save</strong></span> <?php echo "NZD $".number_format((float)$savings, 2, '.', ''); ?></td>
					<td colspan="2" class="alignright pricecol"><strong><span style="padding-right: 1rem;">Subtotal</span></strong> <?php echo "NZD $".number_format((float)$nettotal, 2, '.', ''); ?></td>
				</tr>
				
<!--			</tbody>-->
			</table>
	<form method="post" action="controller.php">
				<div class="submitorder alignright">
				<div>
					<strong><label for="ordernumber">Order Number:</label>
					<input type="number" name="ordernumber" value="<?php echo $currentorderid+1 ?>" readonly/></strong>
				</div>
				<input type="hidden" name="action" value="submitorder"/>
				<button type="submit" class="submitorderbtn">Submit Order</button>
					</div>
			</form>
<div> <?php echo bin2hex(random_bytes(10)); ?></div>
			<?php
			} else {
				echo "<h3>Your cart is empty</h3>";
				if (isset($_SESSION['orderprocessed'])) {
					echo $_SESSION['orderprocessed'];
				}
				echo "<form action='controller.php' method='post'><button class='button1' type='submit' name='homecancel'>Browse Products</button>
				</form>";
			}
			?>
		</div>
		
			
	</div>
</body>
<?php 
	unset($_SESSION['orderprocessed']);
	
?>
</html>