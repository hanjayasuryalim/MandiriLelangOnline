



<head>

	<?php
	include 'Utility/connect_database.php';
	include 'Utility/auto_check.php';
	session_start();
	
	if(isset($_SESSION['police_number']) && isset($_SESSION['vehicle_type'])){
		unset($_SESSION['police_number']);
		unset($_SESSION['vehicle_type']);
	}
	
	
	if(isset($_SESSION['signup'])){
		echo "<script>alert(\"account added\")</script>";
		session_destroy();
	}

	if(isset($_GET['status'])){
		session_destroy();
	}	

	?>
	
	<!--sign in -->
	<?php
		#boolean for errors
		$username_error=false;
		$pwd_error=false;
		$valid=false;

		if(isset($_POST['signinBtn'])){
			unset($_POST['signinBtn']);
			$username=$_POST['username'];
			$p=$_POST['pwd'];

			if(empty($username)){
				echo "<script>alert(\"username empty\")</script>";
				$username_error=true;
			}else if(empty($p)){
				echo "<script>alert(\"password empty\")</script>";
				$pwd_error=true;
			}else{
				$pwd=md5($p);

				$query="SELECT username,pwd FROM user_";
				$result=mysqli_query($con,$query);
				$recognize=false;

				while($row=mysqli_fetch_array($result)){
					if($row['username']==$username){
						$recognize=true;
						if($row['pwd']==$pwd){
							$_SESSION['username']=$username;
							header('location:mainpage.php');
						}else{
							$pwd_error=true;
							echo "<script>alert(\"password error\")</script>";
							break;
						}
						
					}
				}

				if($recognize==false){
					$username_error=true;
					echo "<script>alert(\"unrecognized username\")</script>";
				}
			}
		}
	?>

	<!--sign up-->
	<?php
		#boolean for errors
		$username_su_error=false;
		$pwd_su_error=false;
		$email_su_error=false;
		$norek_su_error=false;
		$amount_su_error=false;
		$name_su_error=false;

		if(isset($_POST['signupBtn'])){
			unset($_POST['signupBtn']);
			$username_su=$_POST['username-su'];
			$p_su=$_POST['pwd-su'];
			$email_su=$_POST['email-su'];
			$norek_su=$_POST['norek-su'];
			$region_su=$_POST['region-su'];
			$name_su=$_POST['name-su'];
			$amount_su=$_POST['amount-su'];

			//checking emptiness
			if(empty($username_su)){
				$username_su_error=true;
				echo "<script>alert(\"username is empty\")</script>";
			}else if(empty($p_su)){
				$pwd_su_error=true;
				echo "<script>alert(\"password is empty\")</script>";
			}else if(empty($email_su)){
				$email_su_error=true;
				echo "<script>alert(\"email is empty\")</script>";
			}else if(empty($norek_su)){
				$norek_su_error=true;
				echo "<script>alert(\"nomor rekening is empty\")</script>";
			}else if(empty($name_su)){
				$name_su_error=true;
				echo "<script>alert(\"name is empty\")</script>";
			}else if(empty($amount_su)){
				$amount_su_error=true;
				echo "<script>alert(\"amount saldo is empty\")</script>";
			}else{
				//if everything is already fullfiled

				//checking username availability
				$query_check_username="SELECT username FROM user_";
				$check_username=mysqli_query($con,$query_check_username);
				$i=0;
				$username_validity=true;
				while($row=mysqli_fetch_row($check_username)){
					if($row[$i]==$username_su){
						$username_validity=false;
						break;
					}
				}

				if($username_validity==true){

					//checking password validity
					if(strlen($p_su)<8){
						echo "<script>alert(\"password  must be 8 character long\")</script>";
						$pwd_su_error=true;
					}else{
						$pwd_su=md5($p_su);

						//checking email validity
						if(!filter_var($email_su,FILTER_VALIDATE_EMAIL)){
							$email_su_error=true;
							echo "<script>alert(\"invalid email address\")</script>";
						}else{

							//checking norek validity
							$query_check_norek="SELECT norek FROM user_";
							$check_norek = mysqli_query($con,$query_check_norek);
							$i=0;
							$norek_validity=true;
							while($row=mysqli_fetch_row($check_norek)){
								if($row[$i]==$norek_su){
									$norek_validity=false;
									break;
								}
							}

							if(strlen($norek_su)!=13 || $norek_validity==false){
								$norek_su_error=true;
								if(strlen($norek_su)!=13){
									echo "<script>alert(\"nomor rekening mandiri harus 13 digit\")</script>";
								}else{
									echo "<script>alert(\"nomor rekening sudah terdaftar\")</script>";
								}
								

							}else{

								if(is_numeric($amount_su)){

									//input to database
									$query="INSERT INTO user_(username,pwd,email,norek,region) 
									VALUES ('{$username_su}','{$pwd_su}','{$email_su}','{$norek_su}','{$region_su}')";

									$result=mysqli_query($con,$query);

									$query="SELECT * FROM user_ WHERE username ='".$username_su."'";
									$result=mysqli_query($con,$query);
									while($row=mysqli_fetch_array($result)){
										$iduser=$row['id_user'];
									}

									$query="INSERT INTO rekening VALUES ('{$norek_su}','{$name_su}','{$amount_su}','{$iduser}')";

									if(mysqli_query($con,$query)){
										echo "<script>alert(\"saved\")</script>";
									}else{
										die(mysqli_error($con));
									}
									$_SESSION['signup']="set";
									header('location:index.php');

								}else{

									$amount_su_error=true;
									echo "<script>alert(\"saldo amount must be numeric\")</script>";

								}
							}
						}
					}
				}else{
					$username_su_error=true;
					echo "<script>alert(\"username has already been taken\")</script>";

				}

			}
			
		}
	?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, maximum-scale=1">

	<title>Homepage</title>
	<link rel="icon" href="favicon.png" type="image/png">
	<link rel="shortcut icon" href="favicon.ico" type="img/x-icon">

	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,800italic,700italic,600italic,400italic,300italic,800,700,600' rel='stylesheet' type='text/css'>

	<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link href="css/font-awesome.css" rel="stylesheet" type="text/css">
	<link href="css/responsive.css" rel="stylesheet" type="text/css">
	<link href="css/magnific-popup.css" rel="stylesheet" type="text/css">
	<link href="css/animate.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="js/jquery.1.8.3.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/jquery-scrolltofixed.js"></script>
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/jquery.isotope.js"></script>
	<script type="text/javascript" src="js/wow.js"></script>
	<script type="text/javascript" src="js/classie.js"></script>
	<script type="text/javascript" src="js/magnific-popup.js"></script>
	<script src="contactform/contactform.js"></script>

	<style>
		.error{
			border-color: red;
		}
	</style>

</head>

<body>
	<header class="header" id="header">
		<!--header-start-->
		<div class="container">
			<figure class="logo animated fadeInDown delay-07s">
				<a href="#"><img src="img/mandiri.png" alt=""></a>
			</figure>
			<h1 class="animated fadeInDown delay-07s">Welcome To Mandiri Online Auction</h1>
			<ul class="we-create animated fadeInUp delay-1s">
				<li>We provide you platform to bid on vehicle on every mandiri region</li>
			</ul>
			<a class="link animated fadeInUp delay-1s servicelink" href="#signin">Get Started</a>
		</div>
	</header>
	<!--header-end-->

	<nav class="main-nav-outer" id="test">
		<!--main-nav-start-->
		<div class="container">
			<ul class="main-nav">
			
				<li><a href="#signin">Sign in</a></li>
				<li class="small-logo"><a href="#header"><img src="img/small-logo.png" alt=""></a></li>
				<li><a href="#signup">Sign up</a></li>
	
			</ul>
			<a class="res-nav_click" href="#"><i class="fa fa-bars"></i></a>
		</div>
	</nav>
	<!--main-nav-end-->



	<section class="main-section team" id="signin">
		<!--main-section team-start-->
		
		<div class="container">
			<h2>Sign In</h2>
			<h6>Doesn't have any account ? <a href="#signuptitle">Click here</a></h6>
			<center>
			<div class="row">
				
				<div class="wow fadeInUp delay-05s" style="width:50%">
					<div class="form">

						<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" role="form">
							<div class="form-group">
								<input type="text" name="username" class="form-control input-text <?php if($username_error==true){echo "error"; }?>" placeholder="username" value="<?php if(isset($username)){echo $username;}?>">
							</div>
							<div class="form-group">
								<input type="password" class="form-control input-text <?php if($pwd_error==true){echo "error";} ?>" name="pwd"  placeholder="password" value="<?php if(isset($p)){echo $p;}?>">
							</div>

							<div class="text-center"><input type="submit" value="Sign In" name="signinBtn" class="input-btn"></div>
						</form>
					</div>
				</div>
			</div>
			</center>
		</div>
	
	</section>
	<!--main-section team-end-->



	<section class="business-talking">
		<!--business-talking-start-->
		<div class="container" id="signuptitle">
			<h2>Join us ! Apply now</h2>
		</div>
	</section>
	<!--business-talking-end-->
	<div class="container">
		<section class="main-section contact" id="signup">
			<h2>Sign up</h2>
			<div class="row">
				<div class="col-lg-6 col-sm-7 wow fadeInLeft">
					<div class="contact-info-box address clearfix">
						<i><p><b>Mandiri Lelang Online</b> is your ultimate destination for buying auction cars</p>
							<br>
						<p>it's easy to navigate by vehicle type, category of items, or brand and type of car</p>
							<br>
						<p> allowing you to save thousands while purchasing and shipping your vehicles through one, convenient portal. We don’t just ensure a better 
						bidding experience but we're committed to change the car auction process for the better</p></i>
					</div>
					
				</div>
				<div class="col-lg-6 col-sm-5 wow fadeInUp delay-05s">
					<div class="form">

						<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" role="form">
							<div class="form-group">
								<input type="text" name="username-su" value="<?php if(isset($username_su)){echo $username_su;}?>" class="form-control input-text <?php if($username_su_error==true){echo "error"; } ?>" placeholder="username">
							</div>
							<div class="form-group">
								<input type="text" name="name-su" value="<?php if(isset($name_su)){echo $name_su;}?>" class="form-control input-text <?php if($name_su_error==true){echo "error"; } ?>" placeholder="name">
							</div>
							<div class="form-group">
								<input type="password" value="<?php if(isset($p_su)){echo $p_su;}?>" class="form-control input-text <?php if($pwd_su_error==true){echo "error"; } ?>" name="pwd-su" placeholder="password">
							</div>
							<div class="form-group">
								<input type="email" value="<?php if(isset($email_su)){echo $email_su;}?>" class="form-control input-text <?php if($email_su_error==true){echo "error"; } ?>" name="email-su" placeholder="email">
							</div>
							<div class="form-group">
								<input type="text" value="<?php if(isset($norek_su)){echo $norek_su;}?>" class="form-control input-text <?php if($norek_su_error==true){echo "error"; } ?>" name="norek-su" placeholder="mandiri auction account number">
							</div>
							<div class="form-group">
								<input type="text" name="amount-su" value="<?php if(isset($amount_su)){echo $amount_su;}?>" class="form-control input-text <?php if($amount_su_error==true){echo "error"; } ?>" placeholder="Current action saldo amount">
							</div>
							<div class="form-group">
								<b>Select your Region :</b>
								<select class="form-control" name="region-su">
									<option value="Jawa">Jawa</option>
									<option value="Sumatra">Sumatra</option>
									<option value="Kalimantan">Kalimantan</option>
									<option value="Sulawesi">Sulawesi</option>
									<option value="Papua">Papua</option>
									<option value="Bali">Bali</option>
									<option value="Nusa Tenggara">Nusa Tenggara</option>
								</select>
							</div>
							<div class="text-center"><input type="submit" name="signupBtn" value="Sign Up" class="input-btn"></div>
						</form>
					</div>
				</div>
			</div>
		</section>
	</div>
	<footer class="footer">
		<div class="container">
			<div class="footer-logo"><a href="#"><img src="img/mandiri.png" alt=""></a></div>
			<span class="copyright">&copy; Mandiri Lelang Online. All Rights Reserved</span>
			<div class="credits">
			</div>
		</div>
	</footer>


	<script type="text/javascript">
		$(document).ready(function(e) {

			$('#test').scrollToFixed();
			$('.res-nav_click').click(function() {
				$('.main-nav').slideToggle();
				return false

			});

      $('.Portfolio-box').magnificPopup({
        delegate: 'a',
        type: 'image'
      });

		});
	</script>

	<script>
		wow = new WOW({
			animateClass: 'animated',
			offset: 100
		});
		wow.init();
	</script>


	<script type="text/javascript">
		$(window).load(function() {

			$('.main-nav li a, .servicelink').bind('click', function(event) {
				var $anchor = $(this);

				$('html, body').stop().animate({
					scrollTop: $($anchor.attr('href')).offset().top - 102
				}, 1500, 'easeInOutExpo');
				/*
				if you don't want to use the easing effects:
				$('html, body').stop().animate({
					scrollTop: $($anchor.attr('href')).offset().top
				}, 1000);
				*/
				if ($(window).width() < 768) {
					$('.main-nav').hide();
				}
				event.preventDefault();
			});
		})
	</script>

	<script type="text/javascript">
		$(window).load(function() {


			var $container = $('.portfolioContainer'),
				$body = $('body'),
				colW = 375,
				columns = null;


			$container.isotope({
				// disable window resizing
				resizable: true,
				masonry: {
					columnWidth: colW
				}
			});

			$(window).smartresize(function() {
				// check if columns has changed
				var currentColumns = Math.floor(($body.width() - 30) / colW);
				if (currentColumns !== columns) {
					// set new column count
					columns = currentColumns;
					// apply width to container manually, then trigger relayout
					$container.width(columns * colW)
						.isotope('reLayout');
				}

			}).smartresize(); // trigger resize to set container width
			$('.portfolioFilter a').click(function() {
				$('.portfolioFilter .current').removeClass('current');
				$(this).addClass('current');

				var selector = $(this).attr('data-filter');
				$container.isotope({

					filter: selector,
				});
				return false;
			});

		});
	</script>

</body>


