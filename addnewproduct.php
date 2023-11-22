<?php

if ( !isset( $_SESSION ) ) {
	session_start();
}

spl_autoload_register( function ( $class ) {
	include_once( 'db.php' );
} );

$obj = new db_gamesmarket;

$genres = $obj->getalldata('genres');
$developers = $obj->getalldata('developers');
$publishers = $obj->getalldata('publishers');

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Adding New Product</title>
	<link rel="stylesheet" href="css/adminstyles.css?<?php echo time(); ?>">
	<link rel="stylesheet" href="css/editproductstyles.css?<?php echo time(); ?>">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
	<div class="wrapper">
	 <?php include 'adminnav.php'; ?>
		
		<div class="containerheader">
		<p class="headertext">Adding a New Product</p>
			<span class="smalltext">Enter the product details below</span>
			
			</div>
		
		<div class="container">
			<div class="formcontainer1">
				<form action="controller.php" class="form" id="form" method="post" enctype="multipart/form-data">
					<label for="productcode">Enter the Product Code</label>
					<input type="text" class="productcode" name="productcode" id="productcode" value="<?php if(isset($_POST['productcode'])) { echo htmlentities($_POST['productcode']); } ?>" placeholder="Code" required autofocus>
					
					<label for="producttitle">Enter the Product Title</label>
					<input type="text" class="producttitle" name="producttitle" id="producttitle" value="<?php if(isset($_POST['producttitle'])) { echo htmlentities($_POST['producttitle']); } ?>" placeholder="Title" required>
					
					<label for="productprice">Enter the Product Price</label>
					<input type="number" min="0" step="0.01" class="productprice" name="productprice" id="productprice" value="<?php if(isset($_POST['productprice'])) { echo htmlentities($_POST['productprice']); } ?>" placeholder="Price" required>
					
					<div>
					<label for="onsale">Is the Product Currently On Sale?</label>
					<input type="checkbox" name="onsale" value="" <?php if(isset($_POST['onsale'])) {
						echo 'checked'; }
					 ?>> <span class="smalltext">(Select if applicable)</span></div>
					
					<label for="discountedprice">Edit the Discounted Price </label>
					<span class="smalltext">(If not discounted enter 00.00)</span>
					<input type="number" min="0" step="0.01" class="discountedprice" name="discountedprice" id="discountedprice" value="<?php if(isset($_POST['discountedprice'])) { echo htmlentities($_POST['discountedprice']); } ?>" placeholder="Price After Discount" required>
					
					<label for="releasedate">Enter the Product Release Date</label><span class="smalltext"> Format: (DD Month YYYY)</span>
					<input type="text" class="releasedate" name="releasedate" id="releasedate" value="<?php if(isset($_POST['releasedate'])) { echo htmlentities($_POST['releasedate']); } ?>" placeholder="e.g. 19 November 2020" required>
					

					<div class="container-inner <?php if(isset($_SESSION["errormsg"])) echo ' error';?>">
						<label class="genreheading">
							Edit Product Genres <span class="smalltext">(You must choose at least one)</span>
						</label>
						<?php foreach ($genres as $genre) { ?>
						<div class="genrescheckbox">
							<input type="checkbox" name="genreschosen[]" value="<?php echo $genre['genreid']; ?>">
							<?php echo $genre['genrename']; ?>
						</div>
						<?php } ?>
					</div>
					</div>
					<div class="formcontainer2">
					<label for="productdeveloper">Choose Developer</label>
					<select name="developer">
				<option value="">Select one</option>
				<?php for ($i=0; $i < count($developers); $i++): ?>
				<option value="<?php echo $developers[$i] ['developerid']; ?>">
					<?php echo $developers[$i] ['developername']; ?>
				</option>
				<?php endfor; ?>
				</select>
					
					<label for="productpublisher">Choose Publisher</label>
					<select name="publisher">
				<option value="">Select one</option>
				<?php for ($i=0; $i < count($publishers); $i++): ?>
				<option value="<?php echo $publishers[$i] ['publisherid']; ?>">
					<?php echo $publishers[$i] ['publishername']; ?>
				</option>
				<?php endfor; ?>
				</select>
					
					<label for="productdescription">Enter the Product Description</label>
					<textarea class="productdescription" name="productdescription" id="productdescription" placeholder="Description" required><?php if(isset($_POST['productdescription'])) { echo $_POST['productdescription']; } ?></textarea>
					
					
					
					<label>Upload a Cover Image (HD 1080p)</label>
					<input type="file" name="file" id="imginput">
					
<!--					<div class="imgpreview">-->
						<label for="imgpreview">Image Preview:</label>
						<img id="imgpreview" class="image" src="#" alt="">
<!--					</div>-->
						
						
						
						
					<label for="videolink">Edit Link to Game Trailer</label>
						 <span class="smalltext">(Youtube Video ID)</span>
					<div class="videolinkdiv">
						<p>https://www.youtube.com/embed/</p><input type="text" class="videolink" name="videolink" id="videolink" value="<?php if(isset($_POST['videolink'])) { echo htmlentities($_POST['videolink']); } ?>" placeholder="Video ID" required>
					</div>
					
			</div>
				<div class="buttondiv">
			<button type="submit" name="addproduct">Submit Information</button>
					
				</form>
				<form action="controller.php" method="post"><button type="submit" name="cancel">Cancel</button></form>
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