<?php

if ( !isset( $_SESSION ) ) {
	session_start();
}

spl_autoload_register( function ( $class ) {
	include_once( 'db.php' );
} );

$obj = new db_gamesmarket;

$status = "";

$productid = $_GET['productid'];
$results = $obj->getselectedproductdata($productid);
$developer = $obj->getproductdeveloper($productid);
$publisher = $obj->getproductpublisher($productid);
$genres = $obj->getproductgenres($productid);

if ($results[0]['onsale'] == 1) {
	$price = $results[0]['discountedprice'];
} else {
	$price = $results[0]['price'];
}


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Games Market</title>
<link rel="stylesheet" href="css/indexstyles.css?<?php echo time(); ?>">
<link rel="stylesheet" href="css/productstyles.css?<?php echo time(); ?>">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
	<div class="coverimg">
	<div class="wrapper">
		<?php include 'nav.php'; ?>
		
		<div class="sectionheader">
			<p><?php echo $results[0]['title']; ?></p>
			<div class="productgenres">
			<?php for($i = 0; $i < count($genres); $i++) {
					if ($genres[$i]['selected']) {
						echo "<a href='genreindex.php?genreid=" . $genres[$i]['genreid'] . "&genrename=" . $genres[$i]['genrename'] . "'><p class='productgenre'>".$genres[$i]['genrename']."</p></a>";
					}
				}
			?>
				</div>
		</div>
		
		<div class="productsection">
			<div class="videocontainer">
				<?php echo "<iframe width='100%' height='100%' src=' https://www.youtube.com/embed/". $results[0]['videolink'] ."?autoplay=1' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>"?>
			</div>
			<div class="details">
				<p><?php echo $results[0]['description']; ?></p>
				<br>
				<p>Release Date | <?php echo $results[0]['releasedate']; ?></p>
				<br>
				<p>Developer | <?php echo $developer['developername']; ?></p>
				<br>
				<p>Publisher | <?php echo $publisher['publishername']; ?></p>
			<form class="addtocartform" action="controller.php" method="post">
				<input type="hidden" name="productid" value="<?php echo $results[0]['productid']; ?>">
				<p style="color: red; text-decoration: line-through; padding-right: 1rem;"><?php if($results[0]['onsale'] == 1) echo 'NZ $'.$results[0]['price']; ?></p>
				<p class="pricetag">NZ $<?php echo $price ?></p>
				<button type="submit" class="addtocart" name="addtocart">Add to Cart</button>
			</form>
			</div>
			<div class="disclaimer"><?php echo $results[0]['title']; ?> is a registered copyright of <?php echo $developer['developername']; ?> <?php echo $publisher['publishername']; ?>. All rights reserved. Content on this page is thereby property of their respective owners. </div>
		</div>
		
	</div>
		
	</div>
		
	
	</body>
	<style>
		.coverimg {
			position: relative;
			overflow: hidden;
			height: 100vh;
			width: 100%;
		}
		
		.coverimg::before {
			content: "";
			background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url(<?php echo $results[0]['image']; ?>);
			background-size: cover;
			position: absolute;
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
			height: 100vh;
		}
	</style>
</html>
	