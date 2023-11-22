<div class="navbackground">
		<div class="nav">
			<div class="logo">
				<a class="logoinner" href="index.php">Syndicate Games<span class="logotext">quality single-player games</span></a>
				<form action="searchindex.php" method="get">
				<div class="searchdiv">
					<input class="searchbox" type="text" placeholder="Search Catalogue" name="searchinput" value="<?php if(isset($_GET['searchinput'])) echo $_GET['searchinput']; ?>" onfocus="this.select()" autofocus>
					<button type="submit" class="searchbtn"><img src="siteimages/001-search.png" alt=""></button>
				</div>
			</form>
			</div>
			
			<div class="links">
				<a class="logoutbtn" href="searchindex.php">Browse Catalogue</a>
				<?php if (isset($_SESSION['loggedin'])) {
						echo "<div style='visibility: hidden'></div>
						<form action='controller.php' method='post'>
							<button id='logoutbtn' class='logoutbtn alignright' name='logout'>Logout</button>
						</form>
						<a class='profilebtn' href='myprofile.php'><img src='siteimages/profileicon.png' alt=''></a>";
					} else {
						echo "<div style='visibility: hidden'></div><a class='registerbtn' id='registerbtn' href='register.php'>Register</a>
						<a class='loginbtn' id='loginbtn' href='login.php'>Login</a>
						";
					}
				?>
				
				<a class="cartbtn" href="cart.php"><img src="siteimages/cart.png" alt=""><p class="cartcount"> <?php echo $_SESSION['itemsquantity'] ?></p></a>
			</div>
		</div>
		</div>
<?php if (empty($_SESSION['cart'])) $_SESSION['itemsquantity'] = 0; ?>