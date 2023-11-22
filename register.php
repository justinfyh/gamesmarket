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
<title>Register</title>
<link rel="stylesheet" href="css/indexstyles.css?<?php echo time(); ?>">
<link rel="stylesheet" href="css/formstyles.css?<?php echo time(); ?>">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
<script src='https://www.google.com/recaptcha/api.js' async defer></script>
</head>

<body>
	<div class="wrapper registerwrapper">
		<div class="innerwrapper">
		<div class="formnav">
			<div class="logo">
				<a href="index.php"><h1>Games Market</h1></a>
			</div>
			<div class="links">
<!--				<a href="register.php">Register</a>-->
				<p>Already have an account?</p>
				<a class="pagelink" href="login.php">Login</a>
<!--				<button type="hidden" name="logout">Logout</button>-->
<!--				<a class="cartbtn" href="cart.php"><img src="productimages/cart.png" alt=""></a>-->
			</div>
		</div>
			
		<div class="header">
			<h3>Register for an account</h3>
		</div>
		
			
				<form action="controller.php" method="post" enctype="multipart/form-data">
					<div class="registerdiv">
					<div class="registerform">
						<label for="username">Create a Username</label>
						<input type="text" class="registerinput <?php if(isset($_SESSION['usernameerror'])) echo " inputerror"; ?>" name="username" value="<?php if(isset($_POST['username'])) {
						echo htmlentities($_POST['username']);
					} ?>" placeholder="Username" required autofocus>
						<div class="systemmessage">
							<?php if(isset($_SESSION['usernameerror'])) echo "This username is taken! Please choose another username"; ?>
						</div>
					
						<label for="firstname">First Name</label>
						<input type="text" class="registerinput" name="firstname" value="<?php if(isset($_POST['firstname'])) {
						echo htmlentities($_POST['firstname']);
					} ?>" placeholder="First Name" required>
					
						<label for="lastname">Last Name</label>
						<input type="text" class="registerinput" name="lastname" value="<?php if(isset($_POST['lastname'])) {
						echo htmlentities($_POST['lastname']);
					} ?>" placeholder="Last Name" required>
					
						<label for="email">Email</label>
						<input placeholder="example@email.com" type="email" class="registerinput" name="email" value="<?php if(isset($_POST['email'])) {
						echo htmlentities($_POST['email']);
					} ?>" required>
					
						<label for="password">Password</label>
						<input type="password" class="registerinput <?php if(isset($_SESSION['passwordmismatch'])) echo " inputerror"; ?>" name="password" placeholder="Password" required>
						<div class="systemmessage">
							<?php if(isset($_SESSION['passwordempty'])) echo "Please enter a password"; ?>
						</div>
						
					
						<label for="confirmpassword">Confirm Password</label>
						<input type="password" class="registerinput <?php if(isset($_SESSION['passwordmismatch'])) echo " inputerror"; ?>" name="confirmpassword" placeholder="Confirm Password" required>
						<div class="systemmessage">
							<?php if(isset($_SESSION['passwordmismatch'])) echo "Passwords do not match"; ?>
						</div>
					</div>
					<div class="addressform">
						<h4>Billing Address</h4>
						
						<label for="streetadd">Street Address</label>
						<input type="text" class="registerinput" name="streetadd" value="<?php if(isset($_POST['streetadd'])) {
						echo htmlentities($_POST['streetadd']);
					} ?>" placeholder="Street Address" required>
						
						<label for="suburb">Suburb</label>
						<input type="text" class="registerinput" name="suburb" value="<?php if(isset($_POST['suburb'])) {
						echo htmlentities($_POST['suburb']);
					} ?>" placeholder="Suburb">
						
						<label for="city">City</label>
						<input type="text" class="registerinput" name="city" value="<?php if(isset($_POST['city'])) {
						echo htmlentities($_POST['city']);
					} ?>" placeholder="City">
						
						<label for="postcode">Postcode</label>
						<input type="number" class="registerinput" name="postcode" value="<?php if(isset($_POST['postcode'])) {
						echo htmlentities($_POST['postcode']);
					} ?>" placeholder="Postcode" required>
						<div class="g-recaptcha <?php if(isset($_SESSION['captchaerror'])) echo " inputerror"; ?>" style="margin-top: 1rem;" data-sitekey="6LcgsM0ZAAAAAFuF1xBF30hRrhwSRubCPfxS-Uvw"></div>
						<div class="systemmessage">
							<?php if(isset($_SESSION['captchaerror'])) echo $_SESSION['captchaerror']; ?>
						</div>
						</div>
					</div>
						
					<div class="buttondiv">
					
					
						<button class="registerbtn" type="submit" name="register">Register</button>
<!--						<input type="hidden" name="recaptcha_response" id="recaptchaResponse">-->
				
						</form>
					<form action="controller.php" method="post"><button  class="cancelbtn" type="submit" name="homecancel">Cancel</button></form>
<!--				-->
					
			</div>
		</div>
	</div>
</body>
	<?php
		unset($_SESSION['captchaerror']);
		unset($_SESSION['passwordempty']);
		unset($_SESSION['passwordmismatch']);
		unset($_SESSION['usernameerror']);
	?>
	
<!--
	 <script src="https://www.google.com/recaptcha/api.js?render=6Ldtr80ZAAAAAF5XfYSB6B_sqjr4hILiZ8n9gomp"></script>
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('YOUR_RECAPTCHA_SITE_KEY', { action: 'contact' }).then(function (token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
            });
        });
    </script>
-->

</html>