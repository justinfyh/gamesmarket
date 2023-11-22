<?php

if ( !isset( $_SESSION ) ) {
	session_start();
}

spl_autoload_register( function ( $class ) {
	include_once( 'db.php' );
} );

$obj = new db_gamesmarket;

if ( empty( $_GET[ 'searchinput' ] ) ) {
	$results = $obj->getalldata( 'products' );
	shuffle( $results );
} else {
	$searchinput = $_GET[ 'searchinput' ];
	$searchinput = addslashes($searchinput);
//	print($searchinput);
	$results = $obj->getsearchedproducts( $searchinput );
	$searchinput = stripslashes($searchinput);
}

$genres = $obj->getalldata( 'genres' );
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Games Market</title>
	<link rel="stylesheet" href="css/indexstyles.css?<?php echo time(); ?>">
	<link rel="stylesheet" href="css/cataloguestyles.css?<?php echo time(); ?>">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
		<?php include 'nav.php'; ?>

		<div class="sectionheader">
			<p>
				<?php if($results == null && !empty($searchinput)) {
						echo "No Results Found For '". $searchinput ."' ";
				} 
				else if (empty($searchinput)) {
					echo "Store Catalogue";
				}
				else {
					echo "Search Results For '". $searchinput ."' ";
				}
				
				?>
			</p>

			<div class="selectgenre">
				<button class="genredrop">Genres</button>
				<div class="genredropcontent">
					<?php
					foreach ( $genres as $genre ) {
						echo "<a href='genreindex.php?genreid=" . $genre[ 'genreid' ] . "&genrename=" . $genre[ 'genrename' ] . "'>" . $genre[ 'genrename' ] . "</a>";
					}
					?>
				</div>
			</div>
		</div>

		<?php if ($results == null) {
					echo " <form action='controller.php' method='post'><button class='button1' type='submit' name='homecancel'>Browse Products</button>
					</form>";
					exit();
				}	
		
		
		?>

		<div class="catalogue">
			<?php foreach ($results as $result) {
						$result['image'] = str_replace('.jpg', 'preview.jpg', $result['image']);
//							print($result['image']);
	
					echo "<div class='itemwrapper'>
						
							<img class='productimg' src='" . $result['image'] . "' alt='Cover image for ". $result['title'] ."'>
						
						<div class='innerwrapper'>
							<a class='producttitle' href='product.php?productid=".$result['productid']."'><p>".$result['title']."</p></a>"; 
	
					if ($result['onsale'] == 1) { 
						echo "<div><br><p class='productprice'>NZD $".$result['discountedprice']." <span class='price'>NZ $" . $result['price'] . "</span></p></div>";
					} 
					else {
						echo "<p class='productprice'><br>NZD $".$result['price']."</p>";
					}
					
					echo "</div>
					
							<p class='releasedate'>Release Date: ".$result['releasedate']."</p>
						</div>";
				}
			?>
		</div>
		<div class="footer">
			<a href="#top">Back to top</a>
		</div>
	</div>
</body>