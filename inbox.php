



<head>

	<?php

		include 'Utility/connect_database.php';
		include 'Utility/auto_check.php';
		session_start();

		$query="SELECT * FROM inbox WHERE username='{$_SESSION['username']}'";
		$result=mysqli_query($con,$query);
		$message_number=0;
		while($row=mysqli_fetch_array($result)){
			if($row['readindex']==0){
				$message_number+=1;
			}
		}

	
	?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, maximum-scale=1">

	<title>Inbox</title>
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
		th,td{ 
			font-size: 75%;
		}

		th{
			text-align: center;
			padding:1.4%;
			background-color: lightblue;
		}
		
		td{
			padding-top:1.4%;
			padding-bottom: 1.4%;
		}

		tr,th,td{
			border-collapse: collapse;
			border:1px solid black;
		}

	</style>
</head>

<body>
	<header class="header" id="header">
		<!--header-start-->
		<div class="container">
		
			<h1 class="animated fadeInDown delay-07s">MANDIRI INBOX</h1>
		
		</div>
	</header>
	<!--header-end-->

	<nav class="main-nav-outer" id="test">
		<!--main-nav-start-->
		<div class="container" id="navigation">
			<ul class="main-nav">
				<li><a href="mainpage.php">Back</a></li>
			</ul>
			<a class="res-nav_click" href="#"><i class="fa fa-bars"></i></a>
		</div>
	</nav>
	<!--main-nav-end-->
	

	<section class="main-section team">
		<!--main-section team-start-->
		
		<div class="container">
			<h2>Your Mailbox</h2>
			<h6>You have <?php echo $message_number;?> unread message(s)</h6>
			<center>
			<div class="row">
				
				<div class="wow fadeInUp delay-05s" style="width:100%">
					<div class="form">

						<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" role="form">
							<?php

									$query="SELECT * FROM inbox WHERE username='{$_SESSION['username']}' ORDER BY id desc";
									$result=mysqli_query($con,$query);
									
									

									echo "<div class=\"form-group\">";
									echo "<table>
											<tr>
												<th>Date</th>
												<th>Time</th>
												<th>Message</th>
											</tr>";
									while($row=mysqli_fetch_array($result)){
										if($row['readindex']!=0){
											echo "<tr>";
											echo "<td>{$row['tanggal']}</td>";
											echo "<td>{$row['jam']}</td>";
											echo "<td>{$row['message']}</td>";
											echo "</tr>";
										}else{
											echo "<tr>";
											echo "<td><b>{$row['tanggal']}</b></td>";
											echo "<td><b>{$row['jam']}</b></td>";
											echo "<td><b>{$row['message']}</b></td>";
											echo "</tr>";
										}
									}

									echo "</table>";
									echo "</div>";
							

									$query="UPDATE inbox SET readindex='1' WHERE username='{$_SESSION['username']}'";
									$result=mysqli_query($con,$query);
								
							?>
						</form>
					</div>
				</div>
			</div>
			</center>
		</div>
	
	</section>
	<!--main-section team-end-->



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


