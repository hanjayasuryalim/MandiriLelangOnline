<!doctype html>
<html>

<?php
	
	include 'Utility/connect_database.php';
	include 'Utility/create_xml.php';
	include 'Utility/create_xml_for_vehicle.php';
	include 'Utility/auto_check.php';
	session_start();

	if(isset($_SESSION['police_number']) && isset($_SESSION['vehicle_type'])){
		unset($_SESSION['police_number']);
		unset($_SESSION['vehicle_type']);
	}

	if(isset($_SESSION['biddeal'])){
		echo "<script>alert(\"congratulations your bid was succeed\")</script>";
		unset($_SESSION['biddeal']);
	}

	$username=$_SESSION['username'];
	$query="SELECT * FROM user_ WHERE username='".$username."'";
	$result=mysqli_query($con,$query);
	while($row=mysqli_fetch_array($result)){
		$norek=$row['norek'];
		$region=$row['region'];
	}

	$query="SELECT * FROM rekening WHERE norek='".$norek."'";
	$result=mysqli_query($con,$query);
	while($row=mysqli_fetch_array($result)){
		$namalengkap=$row['nama_lengkap'];
		$saldo=$row['saldo'];
	}
	$_SESSION['saldo']=$saldo;

	if(!isset($_POST['mp'])){
		$regionmp=$region;
	}else{
		$regionmp=$_POST['region_mp'];
	}
?>

<?php
	// for inbox
	$query="SELECT * FROM inbox WHERE username='{$_SESSION['username']}'";
	$result=mysqli_query($con,$query);
	$message_number=0;
	while($row=mysqli_fetch_array($result)){
		if($row['readindex']==0){
			$message_number+=1;
		}
	}
	
?>

<head>
	<meta charset= harset="utf-8">
	<meta name="viewport" content="width=device-width, maximum-scale=1">

	<title>Main Page</title>
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

	<style type="text/css">
		.red{
			color:red;
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
			<h1 class="animated fadeInDown delay-07s">Mandiri Online Auction</h1>
		
			<a class="link animated fadeInUp delay-1s servicelink" href="#start">Get Started</a>
		</div>
	</header>
	<!--header-end-->

	<nav class="main-nav-outer" id="test">
		<!--main-nav-start-->
		<div class="container" id="navigation">
			<ul class="main-nav">
				<li><a href="#"><?php echo $namalengkap; ?></a></li>
				<li><a href="#">Saldo :<?php echo $saldo; ?></a></li>
				<li><a href="inbox.php"><span class="<?php if($message_number!=0){echo "red";} ?>">Inbox &nbsp;&nbsp;<?php if($message_number!=0){echo $message_number;}?></span></a></li>
				<li><a href="#anchor_region">View Region:<?php echo $regionmp;?></a></li>
				<li><a href="index.php?status=logout">Log out</a></li>
			</ul>
			<a class="res-nav_click" href="#"><i class="fa fa-bars"></i></a>
		</div>
	</nav>
	<!--main-nav-end-->


	<section class="main-section paddind" id="Portfolio">
		<!--main-section-start-->
		<div class="container">
			<h2>Lelang Corner</h2>
			<h6>You are currently viewing lelang on region <?php echo $regionmp;?></h6>
			<h6>Click the image for bid</h6>
			<h6 id="anchor_region"><i>look for another region ?</i></h6>
			<center>
			<div class="wow fadeInUp delay-05s" style="width:50%">
				<div class="form">
					<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" role="form">
						<div class="form-group">
							<select class="form-control" name="region_mp">
									<option value="Jawa">Jawa</option>
									<option value="Sumatra">Sumatra</option>
									<option value="Kalimantan">Kalimantan</option>
									<option value="Sulawesi">Sulawesi</option>
									<option value="Papua">Papua</option>
									<option value="Bali">Bali</option>
									<option value="Nusa Tenggara">Nusa Tenggara</option>
							</select>
							<br>
							<div id="start" class="text-center"><input type="submit" name="mp" value="look"></div>
						</div>
					</form>
				</div>
			</div>
		</center>
			<div class="portfolioFilter">
				<ul class="Portfolio-nav wow fadeIn delay-02s">
					<li><a href="#" data-filter="*" class="current">All</a></li>
					<li><a href="#" data-filter=".mobil">Cars</a></li>
					<li><a href="#" data-filter=".motor">Bikes</a></li>
				</ul>
			</div>

		</div>
		<div class="portfolioContainer wow fadeInUp delay-04s">
			<?php
				$xml=simplexml_load_file("Utility/xml/kendaraan.xml");
				$row=$xml->Region;
				for($i=0;$i<count($row);$i++){
					if($row[$i]->attributes()->name==$regionmp){
						foreach ($row[$i] as $data) {

							if($data->bid==0){

								echo "<div class=\"Portfolio-box {$data->getName()}\">";
								echo "<a href=\"kendaraan.php?police_number={$data->no_polisi}&vehicle_type={$data->getName()}\">";
								echo "<img src=\"{$data->photo}\">";
								echo "<h3>{$data->merk}-{$data->tahun}</h3>";
								echo "<p>last bid : {$data->last_bid}</p>";
								echo"</a>";
								echo"</div>";
								
							}
							
							
						}

					}
				}
				
			?>
		</div>
	</section>
	<!--main-section-end-->


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

</html>
