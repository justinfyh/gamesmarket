<?php

if ( !isset( $_SESSION ) ) {
	session_start();
}

spl_autoload_register( function ( $class ) {
	include_once( 'db.php' );
} );

$obj = new db_gamesmarket;

$developers = $obj->getalldata('developers');
$publishers = $obj->getalldata('publishers');

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Editing a Product</title>
	<link rel="stylesheet" href="css/adminstyles.css?<?php echo time(); ?>">
	<link rel="stylesheet" href="css/editproductstyles.css?<?php echo time(); ?>">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
	<div class="wrapper">
	<?php include 'adminnav.php'; ?>
		
		
		<div class="containerheader">
		<p class="headertext">Editing a Product</p>
			<span class="smalltext">Edit the product details below</span>
			
		</div>
		
		
		<div class="container">
			<div class="formcontainer1">
				<form action="controller.php" class="form" id="form" method="post" enctype="multipart/form-data">
					<div class="productid-div">
						<label for="productid">Current Product ID <span class="smalltext">(Read Only)</span></label>
						<input type="text" class="productid" name="productid" id="productid" value="<?php echo $results [0] ['productid']; ?>" readonly>
					</div>
	
					<label for="productcode">Edit the Product Code</label>
					<input type="text" class="productcode" name="productcode" id="productcode" value="<?php echo $results [0] ['code']; ?>" placeholder="Code" required>
					
					<label for="producttitle">Edit the Product Title</label>
					<input type="text" class="producttitle" name="producttitle" id="producttitle" value="<?php echo $results [0] ['title']; ?>" placeholder="Title" required>
					
					<label for="productprice">Edit the Product Price</label>
					<input type="number" min="0" step="0.01" class="productprice" name="productprice" id="productprice" value="<?php echo $results [0] ['price']; ?>" placeholder="Price" required>
					
					<div>
					<label for="onsale">Is the Product Currently On Sale?</label>
					<input type="checkbox" name="onsale" value="<?php echo $results [0] ['onsale']; ?>" <?php if ($results[0]['onsale'] == 1) {
						echo 'checked';
} ?>> <span class="smalltext">(Select if applicable)</span></div>
					
					<label for="discountedprice">Edit the Discounted Price</label>
					<input type="number" min="0" step="0.01" class="discountedprice" name="discountedprice" id="discountedprice" value="<?php echo $results [0] ['discountedprice']; ?>" placeholder="Price After Discount">
					
					
					<label for="releasedate">Edit the Product Release Date </label>
					<span class="smalltext"> Format: (DD Month YYYY)</span>
					<input type="text" class="releasedate" name="releasedate" id="releasedate" value="<?php echo $results [0] ['releasedate']; ?>" placeholder="e.g. 19 November 2020" required>
					
					<div class="genrecontainer <?php if(isset($_SESSION["errormsg"])) echo ' error';?>">
						<label class="genreheading">
							Edit Product Genres <span class="smalltext">(You must choose at least one)</span>
						</label>
						
						
						<?php for($i = 0; $i < count($genres); $i++) { ?>
						
							<div class="genrescheckbox">
						<input type="checkbox" name="genreschosen[]" value="<?php echo ($genres[$i] ['genreid']); ?>"
							<?php 
								if ($genres[$i]['selected']) {
									echo ' checked';
								}
							?>>
							<?php print($genres[$i]['genrename']); ?>
								
						</div>
						<?php } ?>
							
							
					</div>
					
					</div>
					<div class="formcontainer2">
					<label for="productdeveloper">Edit Developer</label>
					<select name="developer">
				<option value=""><?php echo $developer['developername']; ?></option>
				<?php for ($i=0; $i < count($developers); $i++): ?>
				<option value="<?php echo $developers[$i] ['developerid']; ?>">
					<?php echo $developers[$i] ['developername']; ?>
				</option>
				<?php endfor; ?>
				</select>
					
					<label for="productpublisher">Edit Publisher</label>
					<select name="publisher">
				<option value=""><?php echo $publisher['publishername']; ?></option>
				<?php for ($i=0; $i < count($publishers); $i++): ?>
				<option value="<?php echo $publishers[$i] ['publisherid']; ?>">
					<?php echo $publishers[$i] ['publishername']; ?>
				</option>
				<?php endfor; ?>
				</select>
					
					<label for="productdescription">Edit Product Description</label>
					<textarea class="productdescription" name="productdescription" id="productdescription" placeholder="Description" required><?php echo $results[0]['description'] ?></textarea>
					
					<label>Edit Cover Image (HD 1080p)</label>
					<input type="file" name="file" id="imginput">
						
					<label for="">Image Preview:</label>
<!--					<div class="imgpreview">-->
						<img id='imgpreview' class='image' src="<?php echo $results[0] ['image']; ?>" >
<!--
						<span class="smalltext">
							<?php echo $results [0] ['image']; ?>
						</span>
-->
<!--					</div>-->
										
					<label for="videolink">Edit Link to Game Trailer</label>
						 <span class="smalltext">(Youtube Video ID)</span>
					<div class="videolinkdiv">
						<p>https://www.youtube.com/embed/</p><input type="text" class="videolink" name="videolink" id="videolink" value="<?php echo $results[0]['videolink'] ?>" placeholder="Video ID" required>
					</div>
					
					
				
					
			</div>
				<div class="buttondiv">
			<button type="submit" name="editproduct">Save Information</button>
					</form>
					<form action="controller.php" method="post"><button type="submit" name="cancel">Cancel</button></form>
					
				
				</div>
			
			<div class="genrecontainer">
				<form action="controller.php" method="post">
					<input type="hidden" name="table" value="genres">
					<h3>Edit Genres</h3>
						<table class="genretable">
					<tbody>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Genre</th>
						</tr>
						<?php for($i = 0; $i < count($allgenres); $i++) { ?>
						<tr>
							<td><?php echo $allgenres[$i]['genreid']; ?></td>
							<td>
								<input type="hidden" name="entryid[]" value="<?php echo $allgenres[$i]['genreid']; ?>">
								<input type="hidden" name="singularid" value="<?php echo $allgenres[$i]['genreid']; ?>">
								<input class="genreinput" type="text" name="entryname[]" value="<?php echo $allgenres[$i]['genrename']; ?>"></td>
							<td>
								<button class="gdpbutton" name="gdpdelete" onClick="return confirm('Are you sure you want to delete this?')">Delete</button>
							</td>
						</tr>
					
					<?php
					}
					?>
						</tbody>
					</table>
					<button class="genrebtn genresave" type="submit" name="editdata">Save Genres</button>
					
					<h3>Add a Genre</h3>
					<label for="newgenre" class="newgenrelabel">Enter Genre Name</label>
						<input class="genreinput addgenre" type="text" name="newentry" value="<?php if(isset($_POST['newgenre'])) { echo htmlentities($_POST['newgenre']); } ?>" placeholder="Genre Name">
					<button class="genrebtn" type="submit" name="addentry">Add Genre</button>
				</form>
			</div>
		</div>
	</div>
</body>
	<script>
		function readURL(input) {
	  		if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function(e) {
		  			$('#imgpreview').attr('src', e.target.result);
				}

			reader.readAsDataURL(input.files[0]); // convert to base64 string
			}
		}

	$("#imginput").change(function() {
	  readURL(this);
	});
	</script>
</html>