<?php

if ( !isset( $_SESSION ) ) {
	session_start();
}

spl_autoload_register( function ( $class ) {
	include_once( 'db.php' );
} );

$obj = new db_gamesmarket;
unset($_SESSION['systemerror']);

if(isset($_SESSION['cartlogin'])) {
	$carterror = $_SESSION['cartlogin'];
} else {
	$carterror = '';
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Log In</title>
<link rel="stylesheet" href="css/indexstyles.css?<?php echo time(); ?>">
<link rel="stylesheet" href="css/formstyles.css?<?php echo time(); ?>">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>

<body onUnload="<?php unset($_SESSION['cartlogin']); ?>">
	<div class="wrapper loginwrapper">
		<div class="innerwrapper">
		<div class="formnav">
			<div class="logo">
				<a href="index.php"><h1>Games Market</h1></a>
				<p>Don't have an account? <a class="pagelink" href="register.php">Register</a></p>
			</div>
			
		</div>
			
		<div class="header">
			<h3>Log into your account</h3>
			<p class="systemmessage"><?php echo $carterror;
				?></p>
		</div>
				<form action="controller.php" method="post" enctype="multipart/form-data">
					<div class="loginform">
						<label for="username">Username</label>
						<input type="text" class="logininput <?php if (isset($_SESSION['invalidusername']) || isset($_SESSION['loginerror'])) { echo " inputerror";} ?>" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" placeholder="Username" autofocus>
					
						<label for="password">Password</label>
						<input type="password" class="logininput <?php if (isset($_SESSION['incorrectpassword']) || isset($_SESSION['loginerror'])) { echo " inputerror";} ?>" name="password" placeholder="Password">
					</div>
					<div class="systemmessage">
						<?php 
						if(isset($_SESSION['loginerror'])) echo $_SESSION['loginerror'];
						if(isset($_SESSION['incorrectpassword'])) echo $_SESSION['incorrectpassword'];
						if(isset($_SESSION['invalidusername'])) echo $_SESSION['invalidusername'];
						?>
					</div>
					<div class="buttondiv">
						<button class="loginbtn" type="submit" name="login">Log In</button>
				</form>
					<form action="controller.php" method="post"><button class="cancelbtn" type="submit" name="homecancel">Cancel</button></form>
			</div>
		</div>
	</div>
</body>
	<?php 
		unset($_SESSION['loginerror']);
		unset($_SESSION['incorrectpassword']);
		unset($_SESSION['invalidusername']);
	?>
</html>