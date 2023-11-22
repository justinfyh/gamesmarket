<?php
// if the session has not been started, start session
if ( !isset( $_SESSION ) ) {
	session_start();
}

spl_autoload_register( function ( $class ) {
	include_once( 'db.php' );
} );

$obj = new db_gamesmarket;

// get all the genres from the database
$genres = $obj->getalldata( 'genres' );
//print_r($genres);
//shuffle($genres);

// get all products that are on sale from the database
$discountedproducts = $obj->getonsaleproducts();
shuffle( $discountedproducts );

// if the cart count has not been set, set it to 0
if ( !isset( $_SESSION[ 'itemsquantity' ] ) ) {
	$_SESSION[ 'itemsquantity' ] = 0;
}

//unset($_SESSION['verified']);

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Home - Syndicate Games</title>
	<link rel="stylesheet" href="css/indexstyles.css?<?php echo time(); ?>">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;700&display=swap" rel="stylesheet">
	<style>
		body {
			background-image: url("siteimages/background.png");
		}
		
		.background-tint {
			background-color: rgba(0, 55, 86, 0.80);
			background-blend-mode: multiply;
		}
	</style>
</head>

<body class="background-tint" onLoad="run(); ">
	<div class="coverimg">
		<div class="wrapper">
			<!--			Include the nav html in this part of the page -->
			<?php include 'nav.php'; ?>

			<div class="sectionheader">
				<p>Featured</p>
				<p id="systemmessage" class="systemmessage green">
					<?php if(isset($_SESSION['loginstatus'])) echo $_SESSION['loginstatus']; ?>
				</p>
				<?php if (isset($_SESSION['systemerror'])) {
							echo "<p id='systemmessage2' class='systemmessage red'>".  $_SESSION['systemerror'] ."</p>";
						} ?>

				<?php if (isset($_SESSION['loggedin'])) {
							echo "<a href='myprofile.php'><p class='bluetext' style='font-size: 0.9rem;'>Logged In: ". $_SESSION['username'] ."</p></a>";
						} ?>
			</div>

			<div class="showcasediv">
				<div class="coverimage">
					<a href="product.php?productid=22">
						<img class="showcaseimg" src="productimages/deathstrandingshowcase.jpg" alt="Cover image for Death Stranding">
					</a>
				

				</div>
				<div class="showcasedetails">
					<h2 class="showcaseheading">Death Stranding</h2>

					<p class="showcasedesciption">From legendary game creator Hideo Kojima comes an all-new, genre-defying experience. Sam Bridges must brave a world utterly transformed by the Death Stranding. Carrying the disconnected remnants of our future in his hands, he embarks on a journey to reconnect the shattered world one step at a time.
					<br><br>
					<span class="bluetext" style="font-size: 1.1rem;">Recommended</span> by our curators</p>

					<div class="popup" onclick="viewtrailer()">View Trailer</div>

					<form class="addtocartform" action="controller.php" method="post">
						<input type="hidden" name="productid" value="22">
						<p class="pricetag">NZ $119.99</p>
						<button type="submit" class="addtocart" name="addtocart">Add to Cart</button>
					</form>

				</div>
			</div>


			<div class="sectionheader">
				<p>Browse Genres</p>
			</div>

			<div class="genrecatalogue">
				<?php 
					foreach ($genres as $genre) {
						echo "<a class='genrelink' href='genreindex.php?genreid=" . $genre['genreid'] . "&genrename=" . $genre['genrename'] . "'><div class='genrewrapper'>
						<p class='card	'>" . $genre['genrename'] . "</p>
						</div></a>";
					}
				?>
			</div>


			<div class="sectionheader">
				<p>Special Offers</p>
			</div>

			<div class="discountedproducts">
				<?php 
					foreach ($discountedproducts as $product) {
						// replace with discounted price
						$product['image'] = str_replace('.jpg', 'preview.jpg', $product['image']);
						
						$percentage = number_format((($product['price']-$product['discountedprice'])/$product['price'])*100);
						echo "<a class='productlink' href='product.php?productid=". $product['productid'] ."'><div class='productwrapper'>
						<div class='imgtext'>
						<img src='". $product['image'] ."' alt='Cover image for ". $product['title'] ."'>
						<p>". $product['title'] ."</p>
						</div>
						<p class='price'>NZ $" . $product['price'] . "</p>
						<p class='discountedprice'>-". $percentage ."% &nbsp; NZ $" . $product['discountedprice'] . "</p>
						</div></a>";
					}
				?>
			</div>

			<div class="footer">
				<a href="documents/privacy.txt" download>Privacy</a>
				<a href="documents/copyright.txt" download>Copyright</a>
				<a href="displaycatalogue.php">Admin Access</a>
			</div>

			<div class="popuptext" id="videopopup">
				<p class="closetrailer" onclick="closetrailer();">Close Trailer</p><iframe class="videopopup" id="videoid" width="100%" height="100%" src="https://www.youtube.com/embed/tCI396HyhbQ?enablejsapi=1" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
			<?php if(!isset($_SESSION['verified'])) {
			
			echo "<div class='ageverification' id='verificationpopup'>
				<p>The content on this website is intended for mature audiences only, please confirm that you are over 18 years of age.</p>
				<form action='controller.php' method='post'>
				<button onclick='closeverification()' name='verified'>I am over 18</button> | <a href='http://www.google.com/'>I am not over 18</a>
				</form>
       
			
			</div>";
				}  ?>
		</div>
	</div>
</body>
<?php 
	unset($_SESSION['loginstatus']);
	unset($_SESSION['systemerror']);
?>
<script>
	function run() {
		setTimeout( function () {
			document.getElementById( "systemmessage" ).innerHTML = "";
			//         document.getElementById("systemmessage2").innerHTML="";
		}, 6000 );
	}

	// add class of show to the popup video player when the function is called
	function viewtrailer() {
		var popup = document.getElementById( "videopopup" );
		popup.classList.toggle( "show" );
	}

	function closetrailer() {
		var popup = document.getElementById( "videopopup" );
		popup.classList.toggle( "show" );
		//		document.getElementById("videoid").stop();
		var iframes = document.getElementsByTagName( "iframe" );
		if ( iframes != null ) {
			for ( var i = 0; i < iframes.length; i++ ) {
				iframes[ i ].src = iframes[ i ].src; //causes a reload so it stops playing, music, video, etc.
			}
		}
	}

	document.addEventListener( 'keydown', function ( event ) {
		const key = event.key;
		if ( key === "Escape" ) {
			window.closetrailer();
		}
	} );
	
	function closeverification() {
		var popup = document.getElementById( "verificationpopup" );
		popup.classList.toggle( "hide" );
		//		document.getElementById("videoid").stop();
	}
</script>

</html>