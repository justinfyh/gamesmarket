<?php
// if the session has not been started, start session
if ( !isset( $_SESSION ) ) {
	session_start();
}

spl_autoload_register( function ( $class ) {
	include_once( 'db.php' );
} );

$obj = new db_gamesmarket;

$results = $_SESSION['userdata'];

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Games Market</title>
<link rel="stylesheet" href="css/indexstyles.css?<?php echo time(); ?>">
<link rel="stylesheet" href="css/profilestyles.css?<?php echo time(); ?>">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
	<div class="coverimg">
		<div class="wrapper">
<!--			Include the nav html in this part of the page -->
			<?php include 'nav.php'; ?>
			
			<div class="sectionheader">
				<p>Your Details</p>
				<form action="controller.php" class="form" id="form" method="post" enctype="multipart/form-data">
				<button class="deactivatebtn" onClick="return confirm('Are you sure you want to deactivate your account? You will need to contact an administrator to reactivate your account in the future.')" name="deactivateaccount">Deactivate Account</button>
			</div>
			
			<div class="container">
			<div class="formcontainer">
				

					<input type="hidden" name="userid" value="<?php echo $results [0] ['userid']; ?>">
					
					<label for="username">Username</label>
					<input type="text" class="username" name="username" id="username" value="<?php echo $results [0] ['username']; ?>" required>

					<label for="firstname">First Name</label>
					<input type="text" class="firstname" name="firstname" id="firstname" value="<?php echo $results [0] ['firstname']; ?>" required>

					<label for="lastname">Last Name</label>
					<input type="text" class="lastname" name="lastname" id="lastname" value="<?php echo $results [0] ['lastname']; ?>" required>

					<label for="email">Email</label>
					<input type="text" class="email" name="email" id="email" value="<?php echo $results [0] ['email']; ?>" required>

					
					<label for="password">Change Password</label>
					<input type="password" placeholder="Change Password" name="password" id="password" class="<?php if (isset($_SESSION['registration-error']) && (isset($_SESSION['passwordmatch-error']) || isset($_SESSION['psw-error']))) echo " inputerror "; ?>">
					<!--					<div class="errormsg <?php if (isset($_SESSION['registration-error'])) echo " error"; ?>"><?php if (isset($_SESSION['registration-error'])) {if (in_array("psw-error", $_SESSION["registrationerrors"])) echo "You must enter a password";} //if (isset($_SESSION['passwordmatch-error'])) {echo "Passwords do not match";} ?></div>-->


							
			</div>

			<div class="addresscontainer">

				<label for="streetaddress">Street Address</label>
				<input type="text" class="streetaddress" name="streetadd" id="streetaddress" value="<?php echo $results [0] ['streetadd']; ?>">

				<label for="suburb">Suburb</label>
				<input type="text" class="suburb" name="suburb" id="suburb" value="<?php echo $results [0] ['suburb']; ?>">

				<label for="city">City</label>
				<input type="text" class="city" name="city" id="city" value="<?php echo $results [0] ['city']; ?>">

				<label for="streetaddress">Postcode</label>
				<input type="number" class="postcode" name="postcode" id="postcode" value="<?php echo $results [0] ['postcode']; ?>">
				
				<label for="confirmpsw">Confirm Password</label>
					<input type="password" placeholder="Confirm Password" name="confirmpsw" class="<?php if (isset($_SESSION['registration-error']) && isset($_SESSION['passwordmatch-error'])) echo " inputerror "; ?>">
				
					<div class="systemmessage <?php if (isset($_SESSION['registration-error'])) echo " error2 "; ?>">
						<?php 
						if (isset($_SESSION['passwordmatch-error'])) {
							echo "Passwords do not match";
						}
						?>
					</div>	
				
				
			</div>
			<div class="buttondiv">
				<input type="hidden" name="pageident" value="home">
					<button type="submit" name="edituserdata">Save Information</button>
				</form>
				
				<form action="controller.php" method="post"><button type="submit" name="homecancel">Back to Home</button></form>
			</div>
		</div>	
	</div>
</body>
	<?php unset($_SESSION['passwordmatch-error']); unset($_SESSION['registration-error']); ?>
</html>