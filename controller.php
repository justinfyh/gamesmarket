<?php

//------------------- PHPMAILER --------------------
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:\wamp64\composer\vendor\autoload.php';

$mail = new PHPMailer(true);
//--------------------------------------------------

// NOTE: 'GDP' REFERS TO GENRES DEVELOPERS AND PUBLISHERS AS A GROUPING

// Start the session if it is not already started
if ( !isset( $_SESSION ) ) {
	session_start();
}

spl_autoload_register( function ( $class ) {
	include_once( 'db.php' );
} );

$obj = new db_gamesmarket;

//------------------- INSERTING DATA -------------------
// to add a new product
if (isset($_POST['addproduct'])) {
	extract($_POST);
	
	// if no genres are chosen for the new product, create error message and reload the page, exiting this function. 
	if(!isset($_POST['genreschosen'])) {
		print("No genres");
		$_SESSION["errormsg"] = true;
		include("addnewproduct.php");
		exit();
	}
	
	// set all the variables requried for all the data to be inserted into the database
	$genreschosen = $_POST['genreschosen'];
	$developerid = $_POST['developer'];
	$publisherid = $_POST['publisher'];
	$productcode = $obj->test_input($_POST["productcode"]);
	$producttitle = $obj->test_input($_POST["producttitle"]);
	$productprice = $obj->test_input($_POST["productprice"]);
	$discountedprice = $obj->test_input($_POST["discountedprice"]);
	$releasedate = $obj->test_input($_POST["releasedate"]);
	$productdescription = $obj->test_input($_POST["productdescription"]);
	$videolink = $obj->test_input($_POST["videolink"]);
	
	// check if the onsale checkbox is checked or not.  if so, then set onesale to be true, othewise false. 
	if(!isset($_POST['onsale'])) {
		$onsale = 0;
	} else {
		$onsale = 1;
	}
	
//	print_r($genreschosen);
//	print($developer);
//	exit();

//	print($productcode ."<br>");
//	print($productname ."<br>");
//	print($productprice ."<br>");
//	print($productstock ."<br>");
//	print($productdescription ."<br>");
	
	if (!empty($_FILES ["file"] ["name"])) {
//		if ($_FILES["file"] ["error"] > 0) {
//			echo "Error: ". $_FILES["file"] ['error'] ."<br>";
//		}
//		else {
//			echo "File Name: " . $_FILES["file"]["name"] . "<br>";
//			echo "File Type: " . $_FILES["file"]["type"] . "<br>";
//			echo "File Size: " . ( $_FILES["file"]["size"] / 1024 ) . " KB<br>";
//			echo "Stored in: " . $_FILES["file"]["tmp_name"] . "<br>";
//		}
		//path to where the file is 
		$targetDir = "productimages/";
		$fileName = $_FILES["file"]["name"];
		$targetFilePath = $targetDir.$fileName;
		$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
		
		//allow certain file formats
		$allowTypes = array('jpg', 'jpeg', 'gif', 'png', 'pdf');
		
		if (in_array ($fileType, $allowTypes)) {
			//upload the file to the correct location in our site
			move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath);
		}
	}
	else {
		$targetFilePath = null;
	}
	
	// send all the data to a function
	$obj->insertproductdata($productcode, $producttitle, $productprice, $discountedprice, $releasedate, $productdescription, $onsale, $genreschosen, $targetFilePath, $developerid, $publisherid, $videolink);
	
	// display landing page for administrative pages
	header("Location: displaycatalogue.php");
	exit();
}


//------------------- REGISTRATION -------------------
//to add a new user details when they register
if (isset($_POST['register'])) {
	
	//recaptcha v2
	 if(isset($_POST['g-recaptcha-response'])) {
          $captcha=$_POST['g-recaptcha-response'];
        }
     if(!$captcha) {
          $_SESSION['captchaerror'] = "Please complete the captcha form";
			include 'register.php';
          exit();
	 }
        $secretKey = "6LcgsM0ZAAAAACJ8ro7ICXF9kmo9ZfO3SIfy3pIH";
        $ip = $_SERVER['REMOTE_ADDR'];
        // post request to server
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response,true);
        // should return JSON with success as true
        if($responseKeys["success"]) {
			$_SESSION['loginstatus'] = "Registration successful!";
			unset( $_SESSION['captchaerror']);
        } else {
			$_SESSION['registrationerror'] = true;;
        }
	
	// get the inputted username to check if there is already a user with the same username. if so, create error messages and exit. 
	$username = $obj->test_input($_POST["username"]);
	$results = $obj->getuserdatawithusername($username);
	if ($results != false) {
		$_SESSION['usernameerror'] = true;
		$_SESSION['registrationerror'] = true;
		include 'register.php';
		exit();
	}
	
	// create all the variables requried for all the input data
	$firstname = $obj->test_input($_POST["firstname"]);
	$lastname = $obj->test_input($_POST["lastname"]);
	$email = $obj->test_input($_POST["email"]);
	$streetadd = $obj->test_input($_POST["streetadd"]);
	$suburb = $obj->test_input($_POST["suburb"]);
	$city = $obj->test_input($_POST["city"]);
	$postcode = $obj->test_input($_POST["postcode"]);
	$password = $obj->test_input($_POST["password"]);
	$confirmpassword = $obj->test_input($_POST["confirmpassword"]);
	
//	print($username);
//	exit();
	
	// checking if passwords match || if password field is empty
	// if password field is empty, set error session and error message, if it is not empty, do not set error session and unset error message
	if ($password == "") {
		$_SESSION['registrationerror'] = true;
		$_SESSION['passwordempty'] = true;
		unset($_SESSION['passwordmismatch']);
	} else if ($password != "") {
		$_SESSION['registrationerror'] = false;
		unset($_SESSION['passwordempty']);
	}
	
	// if password does not match the confirmpassword input, then set error session and error message. otherwise if they do match, make error session = false and unset error message
	if ($password != $confirmpassword) {
		$_SESSION['registrationerror'] = true;
		$_SESSION['passwordmismatch'] = true;
	}
	else if (($password != "") && ($password == $confirmpassword)) {
		$_SESSION['registrationerror'] = false;
		unset($_SESSION['passwordmismatch']);
	}
	
//	if (count($_SESSION['registrationerrors']) != 0) {
//		$_SESSION['registrationerror'] = true;
//	}
	
	// if error session is set, include the same page and exit the function
	if ($_SESSION['registrationerror'] == true) {
		include "register.php";
		exit();
	}
	else {
		// if there are no issues, send data to a function that will insert the data into the database
		$obj->insertuserdata($username, $firstname, $lastname, $email, $streetadd, $suburb, $city, $postcode, $password);
		// then get the userid to set the default role of 'user'
		$results = $obj->getuserdatawithusername($username);
		$userid = $results[0]['userid'];
		$obj->setdefaultrole($userid);
		
		// to send order confirmation email to the user
//			$mail->isSMTP();
//			$mail->Host = 'smtp.gmail.com';
//			$mail->SMTPAuth = true;
////			$mail->SMTPSecure = 'tls';
//			$mail->SMTPSecure = 'ssl';
//			$mail->Port = 465; // or 587 465
//			$mail->IsHTML(true);
//		
//			$mail->Username = 'syndicategamesinfo@gmail.com';
//			$mail->Password = 'GITntN40QIbx';
//		
//			$mail->setFrom('syndicategamesinfo@gmail.com');
//			$mail->addAddress($email);
//			$mail->Subject = 'Syndicate Games Account Registration';
//			$mail->Body = 'Thank you '.$firstname.' for registering an account with Syndicate Games! Your Registration has been successful! <br> Login to start browsing our catalogue! http://localhost/gamesmarket/login.php';
//			$mail->send();
		
	}
	header("Location: index.php");
	exit();
}






// ADDING EDITING AND DELETING GENRES DEVELOPERS AND PUBLISHERS
// to add a new developer/publisher/genre
if (isset($_POST['addentry'])) {
	$entry = $_POST['newentry'];
	$table = $_POST['table'];
	$obj->addnewgdpdata($table, $entry);
	header("Location: displaycatalogue.php");
}

//to edit an existing developer/publisher/genre
if (isset($_POST['editdata'])) {
	$entryid = $_POST['entryid'];
	$entryname = $_POST['entryname'];
//	print_r($entryid);
//	print_r($entryname);
//	exit();
	$table = $_POST['table'];
	$obj->updategdpdata($table, $entryid, $entryname);
	header("Location: displaycatalogue.php");
}

//to delete an existing developer/publisher/genre
if (isset($_POST['gdpdelete'])) {
	$table = $_POST['table'];
	$entryid = $_POST['singularid'];
//	print($entryid);
//	exit();
	$obj->removegdpdata($table, $entryid);
	header("Location: displaycatalogue.php");
}

//--------------------------------------------------------------


//BUTTON DETECTION
// --------------------- EDITING PRODUCTS ----------------------
// detection to edit a product
if (isset($_POST['edit_x'])) {
	$productid = $_POST['productid'];
	$results = $obj->getselectedproductdata($productid);
	// craete functions for these
	$developer = $obj->getproductdeveloper($productid);
	$publisher = $obj->getproductpublisher($productid);
	$genres = $obj->getproductgenres($productid);
	$allgenres = $obj->getalldata('genres');
	include('editproduct.php');
	exit();
}

//if the save information to edit product button is clicked
if (isset($_POST['editproduct'])) {
	$productid = $_POST['productid'];
	$productcode = $_POST['productcode'];
	$producttitle = $_POST['producttitle'];
	$productprice = $_POST['productprice'];
	$discountedprice = $_POST['discountedprice'];
	$releasedate = $_POST['releasedate'];
	$developerid = $_POST['developer'];
	$publisherid = $_POST['publisher'];
	$productdescription = $_POST['productdescription'];
	$genreschosen = $_POST['genreschosen'];
	
	$videolink = $_POST['videolink'];
	$targetFilePath = null;
	
	if(!isset($_POST['onsale'])) {
		$onsale = 0;
	} else {
		$onsale = 1;
	}
	

	if (!empty($_FILES ["file"] ["name"])) {
		//path to where the file is 
		$targetDir = "productimages/";
		$fileName = $_FILES["file"]["name"];
		$targetFilePath = $targetDir.$fileName;
		$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
		
		//allow certain file formats
		$allowTypes = array('jpg', 'jpeg', 'gif', 'png', 'pdf');
		
		if (in_array ($fileType, $allowTypes)) {
			//upload the file to the correct location in our site
			move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath);
		}
	}
	
	$obj->updateproductdata($productid, $productcode, $producttitle, $productprice, $discountedprice, $releasedate, $developerid, $publisherid, $productdescription, $targetFilePath, $genreschosen, $onsale, $videolink);
	
	header("Location: displaycatalogue.php");
	exit();
}

//--------------------------------------------------------------

// ---------------------- EDITING USERS ------------------------
//detection to edit a user
if (isset($_POST['edituser_x'])) {
	$userid = $_POST['userid'];
	$roles = $obj->getuserroles($userid);
	$results = $obj->getselecteduserdata($userid);
	include('edituser.php');
	exit();
}

// if the save information for editing user details is clicked
if (isset($_POST['edituserdata'])) {
	$userid = $_POST['userid'];
	$username = $_POST['username'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$streetadd = $_POST['streetadd'];
	$suburb = $_POST['suburb'];
	$city = $_POST['city'];
	$postcode = $_POST['postcode'];
	$password = $_POST['password'];
	$confirmpassword = $_POST["confirmpsw"];
	
	// identify from which page the function is being called
	$page = $_POST['pageident'];
	
	if ($page == 'home') {
		$results = $obj->getselecteduserdata($userid);
		$status = $results[0]['status'];
		$userroles = $obj->getuserroles($userid);
	}
	else if ($page == 'admin') {
		$status = $_POST['status'];
		$userroles = $_POST['userroles'];
	}
	
	if ($password != $confirmpassword) {
		$_SESSION['registration-error'] = true;
		$_SESSION['passwordmatch-error'] = true;
	}
	else if ($password == $confirmpassword) {
		$_SESSION['registration-error'] = false;
		unset($_SESSION['passwordmatch-error']);
	}
	
	if ($_SESSION['registration-error'] == true) {
//		$roles = $obj->getcurrentroles($userid);
//		$results = $obj->gethisuserdata("users", $userid);
//		$active = $obj->getcurrentactivity($userid);
//		$_SESSION['passwordmatch-error'] = "Passwords do not match";
		if ($page == 'home') {
			include 'myprofile.php';
			exit();
		}
		else {
			include "edituser.php";
			exit();
		}
		
	}
	else if ($_SESSION['registration-error'] == false) {
	$obj->updateuserdata($userid, $username, $firstname, $lastname, $email, $status, $streetadd, $suburb, $city, $postcode, $password, $userroles);
		unset($_SESSION['registration-error']);
		unset($_SESSION['uniqueemail-error']);
		unset($_SESSION['passwordmatch-error']);
		unset($_POST['username']);
		unset($_POST['firstname']);
		unset($_POST['lastname']);
		unset($_POST['streetadd']);
		unset($_POST['suburb']);
		unset($_POST['city']);
		unset($_POST['postcode']);
		unset($_POST['email']);
		unset($_POST['status']);
		unset($_POST['userdetails']);
		$_SESSION['userdata'] = $obj->getuserdatawithusername($username);
		$_SESSION['username'] = $username;
	}
	if ($page == 'home') {
			header("Location: index.php");
			exit();
		}
	else {
			header("Location: displayusers.php");
			exit();
		}
}

if (isset($_POST['deactivateaccount'])) {
	$userid = $_POST['userid'];
	$deactivate = $obj->setuserinactive($userid);
	if($deactivate) {
		unset($_SESSION['loggedin']);
		unset($_SESSION['username']);
		unset($_SESSION['password']);
		unset($_SESSION['userdata']);
		unset($_SESSION['userid']);
		unset($_SESSION['loginerror']);
		unset($_SESSION['loginsuccess']);
		unset($_SESSION['systemerror']);
		$_SESSION['systemerror'] = "Your account has been deactivated";
	}
	header("Location: index.php");
	exit();
}

//--------------------------------------------------------------






// LOGIN VALIDATION AND OUTPUT
// to log a user in
if (isset($_POST['login'])) {
	// if fields are empty, print error message and exit function
	if (!isset($_POST['username']) || $_POST['username'] == '' || !isset($_POST['password']) || $_POST['password'] == '' ) {
		$_SESSION['loginerror'] = "Please fill in both fields";
		header("Location: login.php");
		exit();
	}
	
	// set inputs to variables
	$username = $obj->test_input($_POST['username']);
	$password = $obj->test_input($_POST['password']);
	//as username is unique, will get user's password using username
	$userdata = $obj->getuserdatawithusername($username);
	
	//check if the results are empty, then there is no account associated with the username, print error and exit
	if (empty($userdata)) {
		$_SESSION['invalidusername'] = "Could not find account associated with that <br>username";
		include 'login.php';
		exit();
	} 
	// check if the user's account has been deactivated, if so, print error and exit
	if ($userdata[0]['status'] == 0) {
		$_SESSION['loginerror'] = "This account has been deactivated.<br> Please register or login with another account.";
		header("Location: login.php");
		exit();
	}
	
	// get the user's actual password to be compared with the inputted password
	$truepassword = $userdata[0]['password'];
	
	// check if the two passwords match, if the inputted password matches the encrypted password, log the user in, create logged in session variables and unset error messages
	if (password_verify($password, $truepassword)) {
		if (!isset($_SESSION)) {
			session_start();
		}
		$_SESSION['loggedin'] = true;
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $truepassword;
		$_SESSION['userdata'] = $userdata;
		$_SESSION['userid'] = $userdata[0]['userid'];
		unset($_SESSION['loginerror']);
		$_SESSION['loginstatus'] = 'Login successful';
		header("Location: index.php");
		return true;
		exit();
	}
	
	// if the passwords do not match, print error message and exit
	else {
		if (!isset($_SESSION)) {
			session_start();
		}
		unset($_SESSION['loggedin']);
		unset($_SESSION['username']);
		unset($_SESSION['password']);
		$_SESSION['incorrectpassword'] = 'Password entered is incorrect';
		header("Location: login.php");
		return false;
		exit();
	}
	
}


// if the logout button is pressed, unset all sesssion variables related to a user's account and log them out
if (isset($_POST['logout'])) {
	session_start();
	unset($_SESSION['loggedin']);
	unset($_SESSION['username']);
	unset($_SESSION['password']);
	unset($_SESSION['userdata']);
	unset($_SESSION['userid']);
	unset($_SESSION['loginerror']);
	unset($_SESSION['loginsuccess']);
	unset($_SESSION['systemerror']);
	$_SESSION['loginstatus'] = "Logout successful";
	header('location:index.php');
	exit();
}

// if the cancel button is clicked
// in the admin pages
if (isset($_POST['cancel'])) {
	header("Location: displaycatalogue.php");
}

//in the homepages
if (isset($_POST['homecancel'])) {
	unset($_SESSION['passwordmismatch']);
	unset($_SESSION['passwordmatch-error']);
	unset($_SESSION['loginstatus']);
	header("Location: index.php");
}


//---------------------------- SEARCHING & REFINING ----------------------------------
//to get products with a specific genre
if (isset($_POST['refinegenre'])) {
	$genreid = $_POST['genreid'];
	
	$results = $obj->getselectedgenredata($genreid);
	$genrename = $results [0] ['genrename'];
	
//	$results = $obj->getselectedgenresubsetdata($genreid);
	include 'chosengenre.php';
	
}

// to get products with a search input
if(isset($_POST['searchproducts'])) {
	$producttitle = htmlentities($_POST['searchvalue']);
//	print($producttitle);
//	exit();
	$results = $obj->getsearchedproducts($producttitle);
	
//	if($results == null) {
//		include 'displaycatalogue.php';
//		exit();
//	}
//	
//	else {
		include 'searchedproducts.php';
		
//	}
	
}

// to get users with a search input
if(isset($_POST['searchusers'])) {
	$username = $_POST['searchvalue'];
	
//	print($username);
//	exit();
	
	$results = $obj->getsearchedusers($username);
	
	include 'searchedusers.php';
	
}


//---------------------------- CART ----------------------------------
//adding an item to cart
if (isset($_POST['addtocart'])) {
	$productid = $_POST['productid'];
	$results = $obj->getselectedproductdata($productid);
	
	foreach ( $results as $row ) {
		$productid = $row[ 'productid' ];
		$title = $row[ 'title' ];
		$code = $row[ 'code' ];
		$price = $row[ 'price' ];
		$onsale = $row['onsale'];
		$discountedprice = $row['discountedprice'];
		$image = $row[ 'image' ];
	}

	$cartarray = array( $code => array( 'productid' => $productid, 'title' => $title, 'code' => $code, 'price' => $price, 'discountedprice' => $discountedprice, 'quantity' => 1, 'onsale' => $onsale, 'image' => $image ));
	
	if ( empty( $_SESSION[ "cart" ] ) ) {
		$_SESSION[ "cart" ] = $cartarray;
//		print_r( $_SESSION[ "cart" ] );
		$cartstatus = "Product has been added to your cart!";
	} else {
//		print_r( $_SESSION[ "cart" ] );
		$array_keys = array_keys( $_SESSION[ "cart" ] );
//		print( "array Keys" );
//		print_r( $array_keys );
		if ( in_array( $code, $array_keys ) ) {
			$cartstatus = "<div style='color:red;'>Product has already added to your cart!</div>";
		} else {
			$_SESSION[ "cart" ] = array_merge( $_SESSION[ "cart" ], $cartarray );
			$cartstatus = "<div class='box'>Product has been added to your cart.</div>";

		}
	}
	
	include 'cart.php';
}



if (isset($_POST['action']) && ($_POST['action'] === "change")) {
	
	foreach ($_SESSION["cart"] as & $value) {
		if ($value['code'] === $_POST['code']) {
			$value['quantity'] = $_POST['quantity'];
			break; //Stop the loop after we've found the product
		}
	}
	
//	print("Shopping Cart after quantity changed </br>");
//	print_r($_SESSION["cart"]);
//	exit();
	header("Location:cart.php");
	exit();
}





//removing an item from cart
if (isset($_POST['action']) && ($_POST['action'] === "remove")) {
	if (!empty($_SESSION["cart"])) {

	foreach ($_SESSION["cart"] as $key => $value) {

		if ($_POST["code"] == $key) {
			unset($_SESSION["cart"][$key]);
			$_SESSION['itemsquantity'] -= 1;
			$cartstatus = "Product has been removed from your cart!";
		}
		if (empty($_SESSION["cart"])) {
			$_SESSION["cartstatus"] = "";
			unset($_SESSION["cart"]);
		}
	}
}
	
	include('cart.php');
	exit();
}

// submitting an order within the cart
if (isset($_POST['action']) && ($_POST['action'] == 'submitorder')) {
	$orderid = $_POST['ordernumber'];
	$userid = $_SESSION['userid'];
	if (empty($_SESSION['cart'])) {
		$_SESSION['cartstatus'] = "<div class='box'>You cannot submit an order with no products.</div>";
	}
	else {
		$_SESSION['cartstatus'] = "";
		
		$orderarray = array();


		foreach ($_SESSION['cart'] as $value) {
			$productid = $value['productid'];
			$producttitle = $value['title'];
			$quantity = $value['quantity'];
//			print($quantity);
//			exit();
			array_push($orderarray, $producttitle);
//			print_r($orderarray);
//			print($orderarray[1]);
//			exit();
			$ordersubmitted = $obj->submitorder($orderid, $productid, $userid, $quantity);
		}
		
			$username = $_SESSION['username'];
			$email = $_SESSION['userdata'][0]['email'];
			$firstname = $_SESSION['userdata'][0]['firstname'];
			$ordertotal = $_SESSION['carttotal'];
			
		// to send order confirmation email to the user
//			$mail->isSMTP();
//			$mail->Host = 'smtp.gmail.com';
//			$mail->SMTPAuth = true;
////			$mail->SMTPSecure = 'tls';
//			$mail->SMTPSecure = 'ssl';
//			$mail->Port = 465; // or 587 465
//			$mail->IsHTML(true);
//		
//			$mail->Username = 'syndicategamesinfo@gmail.com';
//			$mail->Password = 'GITntN40QIbx';
//		
//			$mail->setFrom('syndicategamesinfo@gmail.com');
//			$mail->addAddress($email);
//			$mail->Subject = 'Syndicate Games Order Confirmation';
//			$mail->Body = 'Thank you '.$firstname.' for purchasing from Syndicate Games! Redeem the codes below to start playing! <br><br>';
//		
//			foreach ($orderarray as $item) {
//				$mail->Body .= '<strong>'.$item.' (x)</strong>'.': '.bin2hex(random_bytes(10)).'<br>';
//			}
//			
//			$mail->Body .= '<br><strong>Order Total (NZD):</strong> $'.$ordertotal;
//			$mail->send();
//			
	}
		
	if ($ordersubmitted) {
		$_SESSION['orderprocessed'] = "<div class='orderstatus'>Your order has been successfully processed! Please check your email for your codes.</div>";
		unset($_SESSION['cart']);
		$_SESSION['itemsquantity'] = 0;
		include('cart.php');
		exit();
	}
}


if (isset($_POST['verified'])) {
//	session_start();
	$_SESSION['verified'] = true;
	header("Location: index.php");
	exit();
}


?>