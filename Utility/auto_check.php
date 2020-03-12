<?php
	
	//this php file is for checking lelang limit, if 2 days already passed then the vehicle will be wiped from database

	$query="SELECT * FROM kendaraan";
	$result=mysqli_query($con,$query);

	$now=date("Y-m-d");	//today's date

	while($row=mysqli_fetch_array($result)){
		if($row['bid_check']==1){
			$target=strtotime($row['bid_date'].' + 3 days');
			$target_date=date("Y-m-d",$target);

			if($target_date <= $now){	//if estimated's date is less than today's date

				//query to minus last_bidder saldo
				$another_query="SELECT * FROM user_ WHERE username='{$row['last_bidder']}'";
				$another_result=mysqli_query($con,$another_query);
				while($another_row=mysqli_fetch_array($another_result)){
					$iduser=$another_row['id_user'];
				}


					//getting older saldo
				$another_query="SELECT * FROM rekening WHERE id_user='{$iduser}'";
				$another_result=mysqli_query($con,$another_query);
				while($another_row=mysqli_fetch_array($another_result)){
					$old_saldo=$another_row['saldo'];
					$norek=$another_row['norek'];
				}

				$hasil=(int)$old_saldo-(int)$row['last_bid'];
				

					//updating database
				$another_query="UPDATE rekening SET saldo='{$hasil}' WHERE norek='{$norek}'";
				$another_result=mysqli_query($con,$another_query) or die(mysqli_error($con));

				
				//query to send message to last bidder
				$tanggal=date("Y-m-d");
				$jam=date("H:i:sa");
				$msg="congratulations your bidded vehicle ".$row['merk']." - ".$row['tahun']." has been confirmed to be yours.Payment has been automatically done.";
				$another_query="INSERT INTO inbox(username,tanggal,jam,message) VALUES('{$row['last_bidder']}','{$tanggal}','{$jam}','{$msg}')";
				$another_result=mysqli_query($con,$another_query);

				//query to release vehicle from web information
				$check=2;
				$appearance=1;
				$another_query="UPDATE kendaraan SET bid_check='{$check}',bid='{$appearance}' WHERE no_polisi='{$row['no_polisi']}'";
				$another_result=mysqli_query($con,$another_query);
				


			}
		}
	}

?>