<?php

if ( !isset( $_SESSION ) ) {
	session_start();
}

spl_autoload_register( function ( $class ) {
	include_once( 'db.php' );
} );

$obj = new db_gamesmarket;

$results = $obj->getalldata("products");
$genres = $obj->getalldata("genres");




/// Pagination
//How many products per page
$productspp = 5;

//Check for set page
isset ($_GET['page']) ? $page = $_GET['page'] : $page = 0;

//Calculate the starting position records we want
if ($page > 1) {
	$start = $page * $productspp - $productspp;
}
else {
	$start = 0;
}

$numrows = count($results);

//Get total number of pages
$totalpages = $numrows / $productspp;
if ($numrows % $productspp != 0) {
	$totalpages += 1;
}

//setting results to the limited set of products
$results = $obj->getfinitesetofdata('products', $start, $productspp);

unset($_SESSION['cart']);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Product Catalogue</title>
<link rel="stylesheet" href="css/adminstyles.css?<?php echo time(); ?>">
<link rel="stylesheet" href="css/tablestyles.css?<?php echo time(); ?>">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
		<?php include 'adminnav.php'; ?>
		
		<div class="catalogue">
			<div class="catalogue-header">
				<h1>Current Product Catalogue</h1>
				<div class="search-bars">
					<div class="refine-genre">
						<form action="controller.php" method="post">
							<h4>Refine Genre</h4>
							<select class="selectgenre" name="genreid">
								<option value="">Select Genre</option>
								<?php for ($i=0; $i < count($genres); $i++): ?>
								<option value="<?php echo $genres[$i] ['genreid']; ?>">
									<?php echo $genres[$i] ['genrename']; ?>
								</option>
								<?php endfor; ?>
							</select>
					</div>
						<button class="searchbtn" type="submit" name="refinegenre"><img src="siteimages/001-search.png" alt=""></button>
						</form>
					
				
				<div class="search-item">
					<form action="controller.php" method="post">	
						<div class="searchproducts"> 
							<h4>Search for an Item</h4>
							<input type="text" name="searchvalue">
						</div>
				</div>
					<button class="searchbtn" type="submit" name="searchproducts"><img src="siteimages/001-search.png" alt=""></button>
					</form>
				</div>
					
			</div>
			
			<div class="catalogue-main">
				<div class="catalogue-table">
			<table class="products">
				<tbody>
				<tr>
					<th scope='col'>ID</th>
					<th scope='col'>Image</th>
					<th scope='col'>Title</th>
					<th scope='col'>Code</th>
					<th scope='col'>Release Date</th>
					<th scope='col'>Price</th>
					<th scope='col'>Description (hover to view in full)</th>
					<th scope='col'>Image Path</th>
					<th scope='col'>Edit</th>
				</tr>
					<?php
					foreach($results as $result) { ?>
					
					<tr>
						<td><?php echo $result['productid']; ?></td>
						<td><?php echo  "<img class='image' src=" . $result['image'] . ">"?></td>
						<td><?php echo $result['title']; ?></td>
						<td><?php echo $result['code']; ?></td>
						<td><?php echo $result['releasedate']; ?></td>
						<td><?php echo $result['price']; ?></td>
						<td class="description"><?php echo $result['description']; ?></td>
						<td><?php echo $result['image']; ?></td>
						<td>
							<form action="controller.php" class="table_form" method="post">
								<div class="editbutton">
									<input type="hidden" name="productid" value="<?php echo $result['productid']; ?>">
									<input class="editbutton" type="image" name="edit" src="siteimages/editwhite.png" value="Edit">
								</div>
							</form>
						</td>
					</tr>
					
					<?php
					}
					?>
					
				</tbody>
			</table>
			<div class="pagelinks">
			<?php
				for($p = 1; $p <= $totalpages; $p++) {
					echo "<a href='?page=$p'>$p</a>";
				}
			?>
			</div>
		</div>
			</div>
			
		</div>

	
	
	
	
	</div>
	<div>Icons made by <a href="https://www.flaticon.com/authors/google" title="Google">Google</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>
</body>
</html>