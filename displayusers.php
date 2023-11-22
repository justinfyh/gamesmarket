<?php

if ( !isset( $_SESSION ) ) {
	session_start();
}

spl_autoload_register( function ( $class ) {
	include_once( 'db.php' );
} );

$obj = new db_gamesmarket;

$results = $obj->getalldata('users');

//pagination
//How many products per page
$productspp = 10;

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
$results = $obj->getfinitesetofdata('users', $start, $productspp);

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>All Users</title>
<link rel="stylesheet" href="css/adminstyles.css?<?php echo time(); ?>">
<link rel="stylesheet" href="css/tablestyles.css?<?php echo time(); ?>">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
	<?php include 'adminnav.php'; ?>
	
	<div class="catalogue">
			<div class="catalogue-header">
			<h1>Current Users</h1>
				<div class="search-bars">
					
				<div class="search-item">
					<form action="controller.php" method="post">	
						<div class="searchusers"> 
							<h4>Search for a User</h4>
							<input type="text" name="searchvalue">
							
						</div>
					
				</div>
					<button class="searchbtn" type="submit" name="searchusers"><img src="siteimages/001-search.png" alt=""></button></form>
				</div>
			</div>
			<div class="catalogue-main">
				<div class="catalogue-table">
			<table class="products">
				<tbody>
				<tr>
					<th scope='col'>ID</th>
					<th scope='col'>Username</th>
					<th scope='col'>First Name</th>
					<th scope='col'>Last Name</th>
					<th scope='col'>Email</th>
					<th scope='col'>Street Address</th>
					<th scope='col'>Suburb</th>
					<th scope='col'>City</th>
					<th scope='col'>Postcode</th>
					<th scope='col'>Status</th>

					<th scope='col'>Edit</th>
				</tr>
					<?php
					foreach($results as $result) { ?>
					
					<tr>
						
						<td><?php echo $result['userid']; ?></td>
						<td><?php echo $result['username']; ?></td>
						<td><?php echo $result['firstname']; ?></td>
						<td><?php echo $result['lastname']; ?></td>
						<td><?php echo $result['email']; ?></td>
						<td><?php echo $result['streetadd']; ?></td>
						<td><?php echo $result['suburb']; ?></td>
						<td><?php echo $result['city']; ?></td>
						<td><?php echo $result['postcode']; ?></td>
						<td><?php if($result['status'] == 1) {
						echo 'active';
					} else {
						echo 'inactive';
					} ?></td>
						
						<td>
							<form action="controller.php" class="table_form" method="post">
							<div class="editbutton">
								<input type="hidden" name="userid" value="<?php echo $result['userid']; ?>">
								<input class="editbutton" type="image" name="edituser" src="siteimages/editwhite.png" value="Edit">
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
</body>
</html>