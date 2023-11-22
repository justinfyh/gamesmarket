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
<title>Editing Developers/Publishers</title>
	<link rel="stylesheet" href="css/adminstyles.css?<?php echo time(); ?>">
	<link rel="stylesheet" href="css/editproductstyles.css?<?php echo time(); ?>">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
		<?php include 'adminnav.php'; ?>
		
		<div class="container2">
			<div class="devcontainer">
				<form action="controller.php" method="post">
					<input type="hidden" name="table" value="developers">
					<h3>Edit Developers</h3>
					<table class="genretable">
						<tbody>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Developers</th>
						</tr>
						<?php foreach($developers as $developer) { ?>
						<tr>
							<td><?php echo $developer['developerid']; ?></td>
							<td>
								<input type="hidden" name="entryid[]" value="<?php echo $developer['developerid']; ?>">
								<input type="hidden" name="singularid" value="<?php echo $developer['developerid']; ?>">
								<input class="genreinput" type="text" name="entryname[]" value="<?php echo $developer['developername']; ?>">
							</td>
							<td>
								<button class="gdpbutton" name="gdpdelete" onClick="return confirm('Are you sure you want to delete this?')">Delete</button>
							</td>
							</tr>
					<?php
					}
					?>
						</tbody>
					</table>
					<button class="genrebtn genresave" type="submit" name="editdata">Save Developers</button>
					
					<h3>Add a Developer</h3>
					<label for="newdeveloper" class="newgenrelabel">Enter Developer Name</label>
						<input class="genreinput addgenre" type="text" name="newentry" value="<?php if(isset($_POST['newdeveloper'])) { echo htmlentities($_POST['newdeveloper']); } ?>">
					<button class="genrebtn" type="submit" name="addentry">Add Developer</button>
				</form>
			</div>
			
			<div class="pubcontainer">
				<form action="controller.php" method="post">
					<input type="hidden" name="table" value="publishers">
					<h3>Edit Publishers</h3>
						<table class="genretable">
					<tbody>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Publisher</th>
						</tr>
						<?php foreach($publishers as $publisher) { ?>
						<tr>
							<td><?php echo $publisher['publisherid']; ?></td>
							<td>
								<input type="hidden" name="entryid[]" value="<?php echo $publisher['publisherid']; ?>">
								<input type="hidden" name="singularid" value="<?php echo $publisher['publisherid']; ?>">
								<input class="genreinput" type="text" name="entryname[]" value="<?php echo $publisher['publishername']; ?>">
							</td>
							<td>
								<button class="gdpbutton" name="gdpdelete" onClick="return confirm('Are you sure you want to delete this?')">Delete</button>
							</td>
						</tr>
					<?php
					}
					?>
						
						</tbody>
					</table>
					<button class="genrebtn genresave" type="submit" name="editdata">Save Publishers</button>
					<h3>Add a Publisher</h3>
					<label for="newpublisher" class="newgenrelabel">Enter Publisher Name</label>
						<input class="genreinput addgenre" type="text" name="newentry" value="<?php if(isset($_POST['newpublisher'])) { echo htmlentities($_POST['newpublisher']); } ?>">
					<button class="genrebtn" type="submit" name="addentry">Add Publisher</button>
				</form>
			</div>
		
		</div>
	
	</div>
</body>
</html>