<?php

if ( !isset( $_SESSION ) ) {
	session_start();
}

spl_autoload_register( function ( $class ) {
	include_once( 'db.php' );
} );

$obj = new db_gamesmarket;

$genreid = $_GET[ 'genreid' ];
$genrename = $_GET[ 'genrename' ];
$results = $obj->getselectedgenredata( $genreid );
$genres = $obj->getalldata( 'genres' );
shuffle( $results );

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
				<?php echo $genrename; ?> Games</p>

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

		<div class="catalogue">
			<?php foreach ($results as $result) {
					$result['image'] = str_replace('.jpg', 'preview.jpg', $result['image']);
	
					echo "<div class='itemwrapper'>
						
							<img class='productimg' src=" . $result['image'] . " alt='Cover image for ". $result['title'] ."'>
						
						<div class='innerwrapper'>
							<a class='producttitle' href='product.php?productid=".$result['productid']."'><p>".$result['title']."</p></a>"; 
	
					if ($result['onsale'] == 1) { 
						echo "<div><br><p class='productprice'>NZD $".$result['discountedprice']." <span class='price'>NZ $" . $result['price'] . "</span></p></div>";
					} 
					else {
						echo "<p class='productprice'><br>NZD $".$result['price']."</p>";
					}
					
					echo "</div>
							<p class='releasedate'>Released: ".$result['releasedate']."</p>
						</div>";
				}
			?>
		</div>
		<div class="footer">
			<a href="#top">Back to top</a>
		</div>
	</div>