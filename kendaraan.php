<!doctype html>
<html>

<?php
	include 'Utility/connect_database.php';
	include 'Utility/auto_check.php';
	session_start();
	
	if(isset($_SESSION['police_number'])){
		$police_number=$_SESSION['police_number'];
	}else{
		$police_number=$_GET['police_number'];
		$_SESSION['police_number']=$police_number;
	}

	if(isset($_SESSION['vehicle_type'])){
		$type=$_SESSION['vehicle_type'];
	}else{
		$type=$_GET['vehicle_type'];
		$_SESSION['vehicle_type']=$type;
	}
	
	

	$query="SELECT * FROM kendaraan WHERE no_polisi='".$police_number."'";
	$result=mysqli_query($con,$query);
	while($row=mysqli_fetch_array($result)){
		$photo=$row['photo'];
		$brand=$row['merk'];
		$region=$row['region'];
		$standard=$row['last_bid'];
	}

	$query="SELECT * FROM user_ WHERE username='".$_SESSION['username']."'";
	$result=mysqli_query($con,$query);
	while($row=mysqli_fetch_array($result)){
		$iduser=$row['id_user'];
	}

	$query="SELECT * FROM rekening WHERE id_user='".$iduser."'";
	$result=mysqli_query($con,$query);
	while($row=mysqli_fetch_array($result)){
		$saldouser=$row['saldo'];
	}


?>
<?php
	$bid_error=false;
	if(isset($_POST['bid'])){
		if(empty($_POST['mybid'])){
			echo "<script>alert(\"bid value is empty\")</script>";
			$bid_error=true;
		}else{
			$bid_value=$_POST['mybid'];
			if((int)$bid_value <= (int)$standard){
				$bid_error=true;
				echo "<script>alert(\"bid value is less than previously bidded value\")</script>";
			}else{

				if((int)$bid_value > (int)$saldouser ){
					$bid_error=true;
					echo "<script>alert(\"your saldo is insufficient\")</script>";
				}else{
					$hasil=(int)$saldouser - (int)$bid_value;
					
					//get last_bidder

							$super_xml=simplexml_load_file("Utility/xml/kendaraan.xml");
							$thisregion=$super_xml->Region;
							for($i=0;$i<count($thisregion);$i++){
								if($thisregion[$i]->attributes()->name==$region){
									foreach ($thisregion[$i]->children() as $row) {
										if($row->getName()==$type){
											if($row->no_polisi==$police_number){
												$last_bidder=$row->last_bidder;
												$last_bid=$row->last_bid;
												break;
											}

										}
									}
								}
							}

					
					if(strcmp($last_bidder, "Not yet bidded")!=0){
						$msg="your vehicle ".$brand." - ".$region." has been bidded by someone else";
						$tanggal=date("Y-m-d");
						$jam=date("h:i:sa");
						
						$query="INSERT INTO inbox(username,tanggal,jam,message) VALUES ('{$last_bidder}','{$tanggal}','{$jam}','{$msg}')";
						$result=mysqli_query($con,$query) or die(mysqli_error($con));
						
					}

					

					
					$msg="You have bidded for {$brand}-{$region}, please wait for 2 days.If no other bidder then we will give you confirmation";
					$tanggal=date("Y-m-d");
					$jam=date("h:i:sa");

					$query="INSERT INTO inbox(username,tanggal,jam,message) VALUES ('{$_SESSION['username']}','{$tanggal}','{$jam}','{$msg}')";
					$result=mysqli_query($con,$query);

					$check=1;
					$query="UPDATE kendaraan SET last_bidder='{$_SESSION['username']}',last_bid={$bid_value},bid_date='{$tanggal}',bid_check='{$check}' WHERE no_polisi='{$police_number}'";
					$result=mysqli_query($con,$query);


					include 'Utility/create_xml.php';
					include 'Utility/create_xml_for_vehicle.php';
					$_SESSION['biddeal']="set";
					header('location:mainpage.php');
				}
				
			}
		}
	}
?>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, maximum-scale=1">

	<title>Vehicle Detail</title>
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
		tr,th,td{
			padding:10%;
		}

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
			<h1 class="animated fadeInDown delay-07s">Vehicle detail page</h1>
		</div>
	</header>
	<!--header-end-->

	<nav class="main-nav-outer" id="test">
		<!--main-nav-start-->
		<div class="container">
			<ul class="main-nav">
				<li><a href="#"><?php echo $brand; ?></a></li>
				<li><a href="#">your saldo :<?php echo $_SESSION['saldo']; ?></a></li>
				<li><a href="mainpage.php">Back</a></li>
			</ul>
			<a class="res-nav_click" href="#"><i class="fa fa-bars"></i></a>
		</div>
	</nav>
	<!--main-nav-end-->

	<div class="container">
		<section class="main-section contact" id="contact">

			<div class="row">
				<div class="col-lg-6 col-sm-7 wow fadeInLeft">
					<img src="<?php echo $photo; ?>">
				</div>
				<div class="col-lg-6 col-sm-5 wow fadeInUp delay-05s">
					<div class="form">
						<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" role="form">
							<div class="form-group">
								<h3>Info</h3>
								<?php
									$super_xml=simplexml_load_file("Utility/xml/kendaraan.xml");
									$thisregion=$super_xml->Region;
									for($i=0;$i<count($thisregion);$i++){
										if($thisregion[$i]->attributes()->name==$region){
											foreach ($thisregion[$i]->children() as $row) {
												if($row->getName()==$type){
													if($row->no_polisi==$police_number){
														$last_bidder=$row->last_bidder;
														$last_bid=$row->last_bid;
														break;
													}

												}
											}
										}
									}


									if($type=="mobil"){
										$xml=simplexml_load_file("Utility/xml/mobil.xml");
										$row=$xml->no_polisi;

										for($i=0;$i<count($row);$i++){
											if($row[$i]->attributes()->no==$police_number){
												$kondisi=$row[$i]->kondisi;
												$tahun=$row[$i]->tahun;
												$transmisi=$row[$i]->transmisi;
												$bahanbakar=$row[$i]->bahanbakar;
												$kilometer=$row[$i]->kilometer;
												$warna=$row[$i]->warna;
												$tempatduduk=$row[$i]->tempatduduk;
												$pintu=$row[$i]->pintu;
												$panjang=$row[$i]->panjang;
												$lebar=$row[$i]->lebar;
												$tinggi=$row[$i]->tinggi;
											}
										}

									}else{
										$xml=simplexml_load_file("Utility/xml/motor.xml");
										$row=$xml->no_polisi;

										for($i=0;$i<count($row);$i++){
											if($row[$i]->attributes()->no==$police_number){
												$kondisi=$row[$i]->kondisi;
												$tahun=$row[$i]->tahun;
												$transmisi=$row[$i]->transmisi;
												$bahanbakar=$row[$i]->bahanbakar;
												$kilometer=$row[$i]->kilometer;
												$warna=$row[$i]->warna;
												$maxspeed=$row[$i]->maxspeed;
												$suspension=$row[$i]->suspension;
												$panjang=$row[$i]->panjang;
												$lebar=$row[$i]->lebar;
												$tinggi=$row[$i]->tinggi;
											}
										}
									}

									echo "<table>";
									
									if($type=="mobil"){
										echo"<tr>
												<th>Condition</th>
												<td>{$kondisi}</td>
											</tr>
											<tr>
												<th>Year</th>
												<td>{$tahun}</td>
											</tr>
											<tr>
												<th>Transmision</th>
												<td>{$transmisi}</td>
											</tr>
											<tr>
												<th>Fuels</th>
												<td>{$bahanbakar}</td>
											</tr>
											<tr>
												<th>Kilometer</th>
												<td>{$kilometer}</td>
											</tr>
											<tr>
												<th>Color</th>
												<td>{$warna}</td>
											</tr>
											<tr>
												<th>Seats</th>
												<td>{$tempatduduk}</td>
											</tr>
											<tr>
												<th>Doors</th>
												<td>{$pintu}</td>
											</tr>
												<th>Length</th>
												<td>{$panjang}mm</td>
											<tr>
												<th>Width</th>
												<td>{$lebar}mm</td>
											</tr>
											<tr>
												<th>Height</th>
												<td>{$tinggi}mm</td>
											</tr>";

									}else{
										echo"<tr>
												<th>Condition</th>
												<td>{$kondisi}</td>
											</tr>
											<tr>
												<th>Year</th>
												<td>{$tahun}</td>
											</tr>
											<tr>
												<th>Transmision</th>
												<td>{$transmisi}</td>
											</tr>
											<tr>
												<th>Fuels</th>
												<td>{$bahanbakar}</td>
											</tr>
											<tr>
												<th>Kilometer</th>
												<td>{$kilometer}</td>
											</tr>
											<tr>
												<th>Color</th>
												<td>{$warna}</td>
											</tr>
											<tr>
												<th>Max Speed</th>
												<td>{$maxspeed}</td>
											</tr>
											<tr>
												<th>Suspension<br>Rear/Front</th>
												<td>{$suspension}</td>
											</tr>
												<th>Length</th>
												<td>{$panjang}mm</td>
											<tr>
												<th>Width</th>
												<td>{$lebar}mm</td>
											</tr>
											<tr>
												<th>Height</th>
												<td>{$tinggi}mm</td>
											</tr>";


									}

									echo "<tr>
											<th>Last bid</th>
											<td>{$last_bid}</td>
										  </tr>
										  <tr>
										  	<th>Last bidder</th>
										  	<td>{$last_bidder}</td>
										  </tr>";

									echo"</table>";
								?>
							</div>
							<div class="form-group">
								<input type="text" name="mybid" class="form-control input-text <?php if($bid_error==true){echo "error"; }?>" placeholder="your bid" value="<?php if(isset($bid_value)){echo $bid_value;}?>">
							</div>
							<div class="text-center"><input type="submit" value="Bid" name="bid" class="input-btn"></div>
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

</html>
