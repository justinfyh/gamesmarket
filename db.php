<?php 

//------------------- PHPMAILER --------------------
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:\wamp64\composer\vendor\autoload.php';

$phpmailer = new PHPMailer(true);
//--------------------------------------------------

class db_gamesmarket {
	
//	private $host="justinhuang.student.liston.school.nz";
//	private $user="justinhu_admin";
//	private $db="justinhu_gamesmarket";
//	private $pass="Liston2020";
	
	private $host="localhost";
    private $user="root";
    private $db="gamesmarket";
    private $pass="";
	
	private $conn;
	
	public function __construct() {
		try {
			$this->conn = new PDO( "mysql:host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->pass );
//			print("connected");
//			exit();
		} catch ( PDOException $e ) {
			print("Unable to connect to the database server.");
			exit();
		}
	}
	
	//to test any input data and validate it
	public function test_input($data) {
		$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		$data = trim($data);
		$data = stripslashes($data);
		return $data;
	}
	
	
	
	
	
	
	//GETTING DATA SECTION
	// gets all the data from a specified table and puts it into an array
	public function getalldata($table) {
		$sql = "SELECT * FROM $table";
		$q = $this->conn->query($sql) or die("failed query in getalldata");
		while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $r;
		}
//		print_r($results);
//		exit();
		return $results;
		exit();
	}
	
	//getting id for the current product
	// get the product id for the most recent product inserted into the database
	public function getcurrentproductid() {
		$sql = "SELECT productid FROM products ORDER BY productid DESC LIMIT 1";
		$q = $this->conn->query($sql) or die ("failed getting product id in getcurrentproductid");
		while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $r;
		}
//		print_r($results);
//		exit();
		$productid = $results[0]['productid'];
		return $productid;
	}
	
	//getting selected product data
	// get the data for a specific product using productid
	public function getselectedproductdata($productid) {
		$sql = "SELECT * FROM products WHERE productid = $productid";
		$q = $this->conn->query($sql) or die("failed in getting this product data in getselectedproductdata function");
		while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $r;
		}
//		print_r($results);
//		exit();
		return $results;
		exit();
	}
	
	//getting selected user's data
	// get the data for a specific user using userid
	public function getselecteduserdata($userid) {
		$sql = "SELECT * FROM users WHERE userid = $userid";
		$q = $this->conn->query($sql) or die("failed in getting this user data in getselecteduserdata function");
		while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $r;
		}
//		print_r($results);
//		exit();
		return $results;	
		exit();
	}
	
	//getting user data using username
	// getting a specific user's data using their username
	public function getuserdatawithusername($username) {
		try {
			$sql = "SELECT * FROM users WHERE username=:username";
			$q = $this->conn->prepare($sql);
			$q->execute(array('username' => $username));
			
			while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
				$results[] = $r;
			}
		if(empty($results)) {
			return false;
		}
			
		} catch(PDOException $e) {
			print('Unable to get user\'s data');
			exit();
		};
		return $results;
	}
	
	
	
	
	//getting product's genres
	// getting a specific product's assigned genres using their product id. marking genres as selected in an array where the product is of that genre
	public function getproductgenres($productid) {
		try {
			$sql = "SELECT genreid FROM productgenre WHERE productid=:productid";
			$q = $this->conn->prepare($sql);
			$q->execute(array('productid' => $productid));
		}
		catch(PDOException $e) {
			print('Unable to get current genres');
			exit();
		};
		$selectedgenres = array();
		foreach($q as $row) {
			$selectedgenres[] = $row['genreid'];
		}
		
//		print_r($selectedgenres);
//		exit();
		
		try {
			$result = $this->conn->query('SELECT genreid, genrename FROM genres');
		}
		catch(PDOException $e) {
			print('Error fetching list of genres');
			exit();
		};
		
		foreach ($result as $row) {
			$genres[] = array('genreid' =>$row['genreid'], 'genrename' =>$row['genrename'], 'selected'=>in_array($row['genreid'], $selectedgenres));
		};
		
		return $genres;
		
	}
	
	// to get the developer for a product
	// get a product's developer using the product's id, getting the developer's name using developer id
	public function getproductdeveloper($productid) {
		try {
			$sql = "SELECT developerid FROM productdev WHERE productid=:productid";
			$q = $this->conn->prepare($sql);
			$q->execute(array('productid' => $productid));
			$developerid = $q->fetch(PDO::FETCH_ASSOC);
//			print_r($developerid);
//			exit();
		} catch(PDOException $e) {
			print("Unable to get product's developer");
			exit();
		};
		
		try {
			$sql = "SELECT * FROM developers WHERE developerid=:developerid";
			
			$q = $this->conn->prepare($sql);
			$q->execute(array('developerid' => $developerid['developerid']));
			
//			while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
				$results = $q->fetch(PDO::FETCH_ASSOC);
//			}
		}
		catch(PDOException $e) {
			print('Error getting developer name');
			exit();
		};
//		print_r($results);
//		exit();
		return $results;
	}
	
	// to get the publisher for a product
	// get a product's publisher using the product's id, getting the publisher's name using publisher id
	public function getproductpublisher($productid) {
		try {
			$sql = "SELECT publisherid FROM productpub WHERE productid=:productid";
			$q = $this->conn->prepare($sql);
			$q->execute(array('productid' => $productid));
			$publisherid = $q->fetch(PDO::FETCH_ASSOC);
//			print_r($publisherid);
//			exit();
		} catch(PDOException $e) {
			print("Unable to get product's publisher");
			exit();
		};
		
		try {
			$sql = "SELECT * FROM publishers WHERE publisherid=:publisherid";
			
			$q = $this->conn->prepare($sql);
			$q->execute(array('publisherid' => $publisherid['publisherid']));
			
//			while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
				$results = $q->fetch(PDO::FETCH_ASSOC);
//			}
		}
		catch(PDOException $e) {
			print('Error getting publisher name');
			exit();
		};
//		print_r($results);
//		exit();
		return $results;
	}
	
	
	
	//getting a user's roles
	// to get a user's role using thier userid, then getting all roles from the roles table and marking roles that the user has as 'selected' in an array
	public function getuserroles($userid) {
		try {
			$sql = "SELECT roleid FROM userroles WHERE userid=:userid";
			$q = $this->conn->prepare($sql);
			$q->execute(array('userid' => $userid));
		}
		catch(PDOException $e) {
			print("Unable to get user's role data");
			exit();
		};
		$selectedroles = array();
		foreach($q as $row) {
			$selectedroles[] =	$row['roleid'];
		}
		
		try {
			$result = $this->conn->query('SELECT roleid, rolename FROM roles');
		}
		catch(PDOException $e) {
			print('Error fetching list of roles');
			exit();
		};
		
		foreach ($result as $row) {
			$userroles[] = array('roleid' =>$row['roleid'], 'rolename' =>$row['rolename'], 'selected'=>in_array($row['roleid'], $selectedroles));
		};

		return $userroles;
	}
	
	
	
	
	// to get the products of a refined genre
	// to get all the products of a specific genre using genreid of that genre
	public function getselectedgenredata($genreid) {
		try {
			$sql = "SELECT * FROM products INNER JOIN productgenre ON products.productid = productgenre.productid INNER JOIN genres ON productgenre.genreid = genres.genreid WHERE genres.genreid=:genreid";
			
			$q = $this->conn->prepare($sql);
			$q->execute(array('genreid' => $genreid));
			
			while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
				$results[] = $r;
			}
			
		}
		catch(PDOException $e) {
			print('Unable to get product data for selected genre');
			exit();
		};
		return $results;
		exit();
	}
	
	// to get the products using a search input
	//get all the products from the products table where the product's title contains the search value inputted by the user, if there are no matching products, return false
	public function getsearchedproducts($producttitle) {
		try {
			$producttitle = html_entity_decode($producttitle);
//			strval($producttitle);
			$sql = "SELECT * FROM products WHERE title LIKE '%$producttitle%'";
			$q = $this->conn->prepare($sql);
			$q->execute(array('producttitle' => $producttitle));
			
			while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
				$results[] = $r;
			}
		}
		catch(PDOException $e) {
			print('Unable to search for products');
			exit();
		};
//		print_r($results);
//		exit();
		if (empty($results)) {
			return false;
		}
		else {
		return $results;
		exit();
		}
	}
	
	// to get all the products that are on sale
	// get all the products from the products table that are currently on sale, with their 'onsale' field maked as true (1) boolean
	public function getonsaleproducts() {
		try {
			$onsale = 1;
			$sql = "SELECT * FROM products WHERE onsale=:onsale";
			$q = $this->conn->prepare($sql);
			$q->execute(array('onsale' => $onsale));
			
			while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
				$results[] = $r;
			}
		}
		catch(PDOException $e) {
			print('Unable to search for products');
			exit();
		};
//		print_r($results);
//		exit();
		
		return $results;
		exit();
	}
	
	// to get the users using a search input
	// get all the users from the users table where either thier usename, first name, or last name are similar to the search value inputted by the user
	public function getsearchedusers($username) {
		try {
			$sql = "SELECT * FROM users WHERE username LIKE '%$username%' OR firstname LIKE '%$username%' OR lastname LIKE '%$username%'";
			$q = $this->conn->prepare($sql);
			$q->execute(array('username' => $username));
			
			while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
				$results[] = $r;
			}
		}
		catch(PDOException $e) {
			print('Unable to search for users');
			exit();
		};
//		print_r($results);
//		exit();
		
		return $results;
		exit();
	}
	
	
	
	
	
	//getting products for pagination
	// get a limited number of set of data from a table to display for pagination
	public function getfinitesetofdata($table, $start, $productspp) {
		$sql = "SELECT * FROM $table LIMIT $start, $productspp";
		$q = $this->conn->query($sql) or die("failed query in getfinitesetofdata");
		while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $r;
		}
//		print_r($results);
//		exit();
		return $results;
		exit();
	}
	
	// to get the order id 
	// to get the most recently inputted orderid in the orders table
	public function getcurrentorderid($table) {
		$sql = "SELECT orderid FROM $table ORDER BY orderid DESC LIMIT 1";
		$q = $this->conn->query($sql) or die ("failed in getting product id in getcurrentorderid function");
		while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $r;
		}
//		print_r($results);
//		exit();
		$orderid = $results[0]['orderid'];
		return $orderid;
		exit();
		
	}
	
	
	//INSERTING DATA
	//adding a new product to the database 
	// inserts a new set of product data into the products table, also setting the product's genres, developer and publisher in the associated tables. (productgenre etc..)
	public function insertproductdata($productcode, $producttitle, $productprice, $discountedprice, $releasedate, $productdescription, $onsale, $genreschosen, $targetFilePath, $developerid, $publisherid, $videolink) {
		try {
			$sql = "INSERT INTO products SET title=:title, code=:code, price=:price, discountedprice=:discountedprice, releasedate=:releasedate, description=:description, onsale=:onsale, videolink=:videolink";
			$q = $this->conn->prepare($sql) or die("failed in insertproductdata");
			$q->execute(array('title' => $producttitle, 'code' => $productcode, 'price' => $productprice, 'discountedprice' => $discountedprice, 'releasedate' => $releasedate, 'description' => $productdescription, 'onsale' => $onsale, 'videolink' => $videolink));
			
			$productid = $this->getcurrentproductid();
			
			if ($targetFilePath != null) {
				$sql = "UPDATE products SET image=:image WHERE productid=:productid";
				$q = $this->conn->prepare($sql);
				$q->execute(array('productid'=>$productid, 'image'=>$targetFilePath));
			}
				
			for ($i = 0; $i < count($genreschosen); $i++) {
				$sql = "INSERT INTO productgenre SET productid=:productid, genreid=:genreid";
				$q = $this->conn->prepare($sql);
				$q->execute(array('productid'=>$productid, 'genreid'=>$genreschosen[$i]));
			}
			
			$sql = "INSERT INTO productdev SET productid=:productid, developerid=:developerid";
			$q = $this->conn->prepare($sql);
			$q->execute(array('productid'=>$productid, 'developerid'=>$developerid));
			
			$sql = "INSERT INTO productpub SET productid=:productid, publisherid=:publisherid";
			$q = $this->conn->prepare($sql);
			$q->execute(array('productid'=>$productid, 'publisherid'=>$publisherid));
			
		}
		catch(PDOException $e) {
				print('Unable to insert product data');
//				exit();
			};

		return true;
		exit();
	}
	
	//adding a new user to the database 
	// inserts a new set of data for a user from the register form into the users table, also encrypts the password before inserting into the database
	public function insertuserdata($username, $firstname, $lastname, $email, $streetadd, $suburb, $city, $postcode, $password) {
		try {
			$password = password_hash($password, PASSWORD_DEFAULT);
			
			$sql = "INSERT INTO users SET username=:username, firstname=:firstname, lastname=:lastname, streetadd=:streetadd, suburb=:suburb, city=:city, postcode=:postcode, email=:email, password=:password";
			
			$q = $this->conn->prepare($sql);
				
			$q->execute(array('username' => $username, 'firstname' => $firstname, 'lastname' => $lastname, 'streetadd' => $streetadd, 'suburb' => $suburb, 'city' => $city, 'postcode' => $postcode, 'email' => $email, 'password' => $password));
				
		} catch(PDOException $e) {
				print('Unable to insert user data');
				exit();
			};
		
		return true;
	}
	
	
	// sets the default role of 'user' for a new user registration using the new user's userid
	public function setdefaultrole($userid) {
		try {
			$roleid = 2;
			$sql = "INSERT INTO userroles SET roleid=:roleid, userid=:userid";
			
			$q = $this->conn->prepare($sql);
				
			$q->execute(array('roleid' => $roleid, 'userid' => $userid));
				
		} catch(PDOException $e) {
				print('Unable to insert user data');
				exit();
			};
		
		return true;
	}
	
	
	//to add new developer/publisher/genre
	// inserts a new genre/publisher/developer into their respective tables
	public function addnewgdpdata($table, $entry) {
		try {
			if ($table == 'developers') {
				$sql = "INSERT INTO $table SET developername=:developername";
				$q = $this->conn->prepare($sql);
				$q->execute(array('developername' => $entry));
			}
			else if ($table == 'publishers') {
				$sql = "INSERT INTO $table SET publishername=:publishername";
				$q = $this->conn->prepare($sql);
				$q->execute(array('publishername' => $entry));
			}
			else if ($table == 'genres') {
				$sql = "INSERT INTO $table SET genrename=:genrename";
				$q = $this->conn->prepare($sql);
				$q->execute(array('genrename' => $entry));
			}
			else {
				exit();
			}
		}
		catch(PDOException $e) {
			print('Unable to insert new developer/publisher data');
				exit();
		};
	}
	
	
	// deletes a genre/publisher/developer from their respective tables using their ids
	public function removegdpdata($table, $entryid) {
		try {
			if ($table == 'developers') {
				$sql = "DELETE FROM $table WHERE developerid=:developerid";
				$q = $this->conn->prepare($sql);
				$q->execute(array('developerid' => $entryid));
			}
			else if ($table == 'publishers') {
				$sql = "DELETE FROM $table WHERE publisherid=:publisherid";
				$q = $this->conn->prepare($sql);
				$q->execute(array('publisherid' => $entryid));
			}
			else if ($table == 'genres') {
				$sql = "DELETE FROM $table WHERE genreid=:genreid";
				$q = $this->conn->prepare($sql);
				$q->execute(array('genreid' => $entryid));
			}
			else {
				exit();
			}
			
		}
		catch ( PDOException $e ) {
			print("Unable to insert order information");
			exit();
		}
		return true;
	}
	
	//submitting an order
	// to submit and store an order in the orders table 
	public function submitorder($orderid, $productid, $userid, $quantity) {
		try {
			$sql = "INSERT INTO orders SET orderid=:orderid, productid=:productid, userid=:userid, quantity=:quantity";
			$q = $this->conn->prepare($sql);
			$q->execute(array('orderid' => $orderid, 'productid' => $productid, 'userid' => $userid, 'quantity' => $quantity));
			
			
		}
		catch ( PDOException $e ) {
			print("Unable to insert order information");
			exit();
		}
		return true;
	}
	
	//UPDATING DATA
	//updating existing product data in the database
	// to update an existing product in the database using data from the edit product form. also updates product's genres in the productgenre table ny first deleting all instances of the productid and inserting the new selected genres. updates developer and publisher in there respective associative tables. 
	public function updateproductdata($productid, $productcode, $producttitle, $productprice, $discountedprice, $releasedate, $developerid, $publisherid, $productdescription, $targetFilePath, $genreschosen, $onsale, $videolink) {
		try {
			$sql = "UPDATE products SET code=:code, title=:title, price=:price, discountedprice=:discountedprice, releasedate=:releasedate, description=:description, onsale=:onsale, videolink=:videolink WHERE productid=:productid";
			$q = $this->conn->prepare($sql);
			$q->execute(array('productid' => $productid, 'code' => $productcode, 'title' => $producttitle, 'price' => $productprice, 'discountedprice' => $discountedprice, 'releasedate' => $releasedate, 'description' => $productdescription, 'onsale' => $onsale, 'videolink' =>$videolink)); 
			
			if($targetFilePath !== null) {
				$sql = "UPDATE products SET image=:image WHERE productid=:productid";
				$q = $this->conn->prepare($sql);
				$q->execute(array('productid' => $productid, 'image'=>$targetFilePath));
			}
			
			$sql = "DELETE FROM productgenre WHERE productid=:productid";
			$q = $this->conn->prepare($sql);
			$q->execute(array("productid" => $productid));
			
			for($i = 0; $i < count($genreschosen); $i++) {
				$sql = "INSERT INTO productgenre SET productid=:productid, genreid=:genreid";
				$q = $this->conn->prepare($sql);
				$q->execute(array('productid' => $productid, 'genreid' => $genreschosen[$i]));
			}
			
			if($developerid !== '') {
				$sql = "UPDATE productdev SET developerid=:developerid WHERE productid=:productid";
				$q = $this->conn->prepare($sql);
				$q->execute(array("productid" => $productid, 'developerid' => $developerid));
			}
			
			if($publisherid !== '') {
				$sql = "UPDATE productpub SET publisherid=:publisherid WHERE productid=:productid";
				$q = $this->conn->prepare($sql);
				$q->execute(array("productid" => $productid, 'publisherid' => $publisherid));
			}
			
		}
		catch(PDOException $e) {
			print('Unable to update product data');
			exit();
		};

		return true;
	}
	

	// updating developers/publishers/genres
	// updates developers/publishers/genres in their respective tables using a table value and the input value from the updating forms.
	public function updategdpdata($table, $entryid, $entryname) {
		try {
			if ($table == 'developers') {
				for ($i = 0; $i < count($entryid); $i++) {
					$sql = "UPDATE $table SET developername=:developername WHERE developerid=:developerid";
					$q = $this->conn->prepare($sql);
					$q->execute(array('developerid'=>$entryid[$i], 'developername'=>$entryname[$i]));
					}
			}
			else if ($table == 'publishers') {
				for ($i = 0; $i < count($entryid); $i++) {
					$sql = "UPDATE $table SET publishername=:publishername WHERE publisherid=:publisherid";
					$q = $this->conn->prepare($sql);
					$q->execute(array('publisherid'=>$entryid[$i], 'publishername'=>$entryname[$i]));
					}
			}
			else if ($table == 'genres') {
				for ($i = 0; $i < count($entryid); $i++) {
					$sql = "UPDATE $table SET genrename=:genrename WHERE genreid=:genreid";
					$q = $this->conn->prepare($sql);
					$q->execute(array('genreid'=>$entryid[$i], 'genrename'=>$entryname[$i]));
					}
			}
			else {
				exit();
			}
		}
		catch(PDOException $e) {
			print('Unable to update dev/pub data');
			exit();
		};
	}
	
	
	
	//updating user details
	// updates the data for an existing user in the users table, updating the password only if it has been changed
	public function updateuserdata($userid, $username, $firstname, $lastname, $email, $status, $streetadd, $suburb, $city, $postcode, $password, $userroles) {
		try {
//			print($status);
//			exit();
			$sql = "UPDATE users SET userid=:userid, username=:username, firstname=:firstname, lastname=:lastname, email=:email, status=:status, streetadd=:streetadd, suburb=:suburb, city=:city, postcode=:postcode WHERE userid=:userid";
			$q = $this->conn->prepare($sql);
			$q->execute(array('userid' => $userid, 'username' => $username, 'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'status' => $status, 'streetadd' => $streetadd, 'suburb' => $suburb, 'city' => $city, 'postcode' => $postcode)); 
			
			for($i = 0; $i < count($userroles); $i++) {
				$sql = "INSERT INTO userroles SET roleid=:roleid, userid=:userid";
				$q = $this->conn->prepare($sql);
				$q->execute(array('roleid' => $userroles[$i], 'userid' => $userid));
			}
			
			if ($password !== "") {
				$password = password_hash($password, PASSWORD_DEFAULT);
				$sql = "UPDATE users SET password=:password WHERE userid=:userid";
				$q = $this->conn->prepare($sql);
			$q->execute(array('userid' => $userid, 'password' => $password)); 
			}
		}
		catch(PDOException $e) {
			print('Unable to update user data');
			exit();
		};
		
		return true;
	}
	
	
	
	// sets a user's status to inactive using their userid in the users table, making status 'false' (0)
	public function setuserinactive($userid) {
		try {
			$sql = "UPDATE users SET status=0 WHERE userid=:userid";
			$s = $this->conn->prepare($sql);
			$s->execute(array('userid' => $userid));
			
		}
		catch (PDOException $e) {
			print("Unable to deactivate account");
			include 'index.php';
			exit();
		}
		return true;
	}
	
	
	// checking if user has administrator role
	// selects instances of where a user has a role in the userroles table using roleid and the session set userid. if there are instances, return true, if not, return false
	public function userhasrole($roleid) {
		try {
			$sql = "SELECT COUNT(*) FROM userroles WHERE userid=:userid AND roleid=:roleid";
			$s = $this->conn->prepare($sql);
			$s->execute(array('userid' => $_SESSION['userid'], 'roleid' => $roleid));
			
		}
		catch (PDOException $e) {
			$error = "Error searching for userroles";
			include 'index.php';
			exit();
		}
		
		$row = $s->fetch();
		
		if ($row[0] > 0) {
			return true;
			exit();
		}
		else {
			return false;
			exit();
		}
	}
	
	
}







?>