<?php

if ( !isset( $_SESSION ) ) {
	session_start();
}

spl_autoload_register( function ( $class ) {
	include_once( 'db.php' );
} );

$obj = new db_gamesmarket;

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Editing User Details</title>
	<link rel="stylesheet" href="css/adminstyles.css?<?php echo time(); ?>">
	<link rel="stylesheet" href="css/editproductstyles.css?<?php echo time(); ?>">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
		<?php include 'adminnav.php'; ?>


		<div class="containerheader">
			<p class="headertext">Editing User</p>
			<span class="smalltext">Edit the user's details below</span>

		</div>


		<div class="container">
			<div class="formcontainer1">
				<form action="controller.php" class="form" id="form" method="post" enctype="multipart/form-data">

					<div class="productid-div">
						<label for="userid">Current User ID <span class="smalltext">(Read Only)</span></label>
						<input type="text" class="productid" name="userid" id="userid" value="<?php echo $results [0] ['userid']; ?>" readonly>
					</div>

					<label for="username">Edit Username</label>
					<input type="text" class="username" name="username" id="username" value="<?php echo $results [0] ['username']; ?>" required>

					<label for="firstname">Edit First Name</label>
					<input type="text" class="firstname" name="firstname" id="firstname" value="<?php echo $results [0] ['firstname']; ?>" required>

					<label for="lastname">Edit Last Name</label>
					<input type="text" class="lastname" name="lastname" id="lastname" value="<?php echo $results [0] ['lastname']; ?>" required>

					<label for="email">Edit Email</label>
					<input type="text" class="email" name="email" id="email" value="<?php echo $results [0] ['email']; ?>" required>

					<label for="status">Edit Status</label>
					<input type="radio" class="status" name="status" id="status" value="1" <?php if ($results[0]['status'] == 1) { echo ' checked'; } ?>> Active
					<input type="radio" class="status" name="status" id="status" value="0" <?php if ($results[0]['status'] == 0) { echo ' checked'; } ?>> Inactive
					

					<div class="categories-inner <?php if(isset($_SESSION[" errormsg "])) echo ' error';?>">
						<label class="categorylabel">
							Choose the user's role(s) <span class="smalltext">(You must choose at least one)</span>
						</label>
					

						<?php for($i = 0; $i < count($roles); $i++) { ?>
						<div class="categoriescheckbox">
							<input type="checkbox" name="userroles[]" value="<?php echo ($roles[$i] ['roleid']); ?>" <?php if ($roles[$i][ 'selected']) { echo ' checked'; } ?>>
							<?php print($roles[$i]['rolename']); ?>
						</div>
						<?php } ?>
					</div>

					<label for="password">Update the User's Password</label>
					<input type="password" placeholder="Change Password" name="password" id="password" class="<?php if (isset($_SESSION['registration-error']) && (isset($_SESSION['passwordmatch-error']) || isset($_SESSION['psw-error']))) echo " error2 "; ?>">
					<!--					<div class="errormsg <?php if (isset($_SESSION['registration-error'])) echo " error"; ?>"><?php if (isset($_SESSION['registration-error'])) {if (in_array("psw-error", $_SESSION["registrationerrors"])) echo "You must enter a password";} //if (isset($_SESSION['passwordmatch-error'])) {echo "Passwords do not match";} ?></div>-->


					<label for="confirmpsw">Confirm Password</label>
					<input type="password" placeholder="Confirm Password" name="confirmpsw" class="<?php if (isset($_SESSION['registration-error']) && isset($_SESSION['passwordmatch-error'])) echo " error2 "; ?>">
					<div class="errormsg <?php if (isset($_SESSION['registration-error'])) echo " error2 "; ?>">
						<?php if (isset($_SESSION['passwordmatch-error'])) {echo "Passwords do not match";} //if (isset($_SESSION['registration-error'])) echo "Passwords do not match"; ?>
					</div>			
			</div>

			<div class="addresscontainer">
				<h2>Edit User's Address Details</h2>

				<label for="streetaddress">Edit Street Address</label>
				<input type="text" class="streetaddress" name="streetadd" id="streetaddress" value="<?php echo $results [0] ['streetadd']; ?>">

				<label for="suburb">Edit Suburb</label>
				<input type="text" class="suburb" name="suburb" id="suburb" value="<?php echo $results [0] ['suburb']; ?>">

				<label for="city">Edit City</label>
				<input type="text" class="city" name="city" id="city" value="<?php echo $results [0] ['city']; ?>">

				<label for="streetaddress">Edit Postcode</label>
				<input type="number" class="postcode" name="postcode" id="postcode" value="<?php echo $results [0] ['postcode']; ?>">
				
				
			</div>
				<div class="buttondiv">
					<input type="hidden" name="pageident" value="admin">
<button type="submit" name="edituserdata">Save Information</button>
				</form>
				
				<form action="controller.php" method="post"><button type="submit" name="cancel">Cancel</button>
				</form>
				</div>
		</div>

	</div>
</body>
</html>