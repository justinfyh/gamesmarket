<?php 
if (!isset($_SESSION['loggedin'])) {
	$_SESSION['systemerror'] = 'You must be logged in to access these pages';
	header("Location: index.php");
	exit();
}

if ($obj->userhasrole(1) == false) {
	$_SESSION['systemerror'] = 'Only account administrators may access the admin pages';
//	unset($_SESSION['loginSuccess']);
	header("Location: index.php");
	exit();
}

?>


<div class="navbackgroundadmin">
<div class="nav">
			<div class="logo">
				<a href="index.php">
				<h1>Syndicate Games</h1>
				<span>Admin Page</span>
					</a>
			</div>
			<div class="page-links">
				<div>
				<ul>
					<li><a href="index.php">Home</a></li>
					<li><a href="displaycatalogue.php">Display Catalogue</a></li>
					<li><a href="displayusers.php">Display Users</a></li>
					<li>
					</li>
					<li></li>
				</ul></div>
				<div class="dropdiv"><button class="dropbtn">Operations</button>
						<div class="dropcontent">
							<a href="addnewproduct.php">Add New Product</a>
							<a href="editdevpub.php">Developers/Publishers</a>
<!--							<a href="editfeatured.php">Edit Featured</a>-->
						</div>
						</div>
			</div>
			<div class="logout">
				<input type="hidden" name="action" value="logout">
				<input type="hidden" name="goto" value="index.php">
				<form action="controller.php" method="post">
				<button type="submit" class="logoutbtn" name="logout">Logout</button>
					</form>
			</div>
		</div>
	</div>