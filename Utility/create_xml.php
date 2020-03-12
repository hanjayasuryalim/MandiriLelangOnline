
<?php
	//create xml

	$query="SELECT * FROM kendaraan";
	$result=mysqli_query($con,$query);
	$kendaraanArray=array();

	while($row=mysqli_fetch_array($result)){
		array_push($kendaraanArray,$row);
	}

	//$kendaraanArray[0]['region']);

	createXML($kendaraanArray);

	function createXML($kendaraanArray){

		$filepath="Utility/xml/kendaraan.xml";
		$dom=new DOMdocument('1.0','utf-8');
		$root=$dom->createElement('lelang');

		//separate by region
		$jawa=array();
		$sumatra=array();
		$kalimantan=array();
		$sulawesi=array();
		$papua=array();
		$nusatenggara=array();
		$bali=array();

		for($i=0;$i<sizeof($kendaraanArray);$i++){
			if($kendaraanArray[$i]['region']=='Jawa'){
				array_push($jawa,$kendaraanArray[$i]);
			}else if($kendaraanArray[$i]['region']=='Sumatra'){
				array_push($sumatra, $kendaraanArray[$i]);
			}else if($kendaraanArray[$i]['region']=='Kalimantan'){
				array_push($kalimantan,$kendaraanArray[$i]);
			}else if($kendaraanArray[$i]['region']=='Sulawesi'){
				array_push($sulawesi,$kendaraanArray[$i]);
			}else if($kendaraanArray[$i]['region']=='Papua'){
				array_push($papua,$kendaraanArray[$i]);
			}else if($kendaraanArray[$i]['region']=='Nusa Tenggara'){
				array_push($nusatenggara,$kendaraanArray[$i]);
			}else if($kendaraanArray[$i]['region']=='Bali'){
				array_push($bali,$kendaraanArray[$i]);
			}
		}

		//creating xml

			//jawa
		$jawaXML=$dom->createElement('Region');
		$jawaXML->setAttribute('name','Jawa');
		$root->appendChild($jawaXML);

		for($i=0;$i<sizeof($jawa);$i++){
			if($jawa[$i]['type']=='motor'){
				$type=$dom->createElement('motor');
			}else{
				$type=$dom->createElement('mobil');
			}

			$nopolisi=$dom->createElement('no_polisi',$jawa[$i]['no_polisi']);
			$lastbid=$dom->createElement('last_bid',$jawa[$i]['last_bid']);
			$photo=$dom->createElement('photo',$jawa[$i]['photo']);
			$merk=$dom->createElement('merk',$jawa[$i]['merk']);
			$bid=$dom->createElement('bid',$jawa[$i]['bid']);
			$tahun=$dom->createElement('tahun',$jawa[$i]['tahun']);
			

			$jawaXML->appendChild($type);
			$type->appendChild($nopolisi);
			$type->appendChild($lastbid);
			$type->appendChild($photo);
			$type->appendChild($merk);
			$type->appendChild($bid);
			$type->appendChild($tahun);
			

			if($jawa[$i]['last_bidder']==null){
				$lastbidder=$dom->createElement('last_bidder',"Not yet bidded");
			}else{
				$lastbidder=$dom->createElement('last_bidder',$jawa[$i]['last_bidder']);
			}
			$type->appendChild($lastbidder);

		}

			//sumatra
		$sumatraXML=$dom->createElement('Region');
		$sumatraXML->setAttribute('name','Sumatra');
		$root->appendChild($sumatraXML);

		for($i=0;$i<sizeof($sumatra);$i++){
			if($sumatra[$i]['type']=='motor'){
				$type=$dom->createElement('motor');
			}else{
				$type=$dom->createElement('mobil');
			}

			$nopolisi=$dom->createElement('no_polisi',$sumatra[$i]['no_polisi']);
			$lastbid=$dom->createElement('last_bid',$sumatra[$i]['last_bid']);
			$photo=$dom->createElement('photo',$sumatra[$i]['photo']);
			$merk=$dom->createElement('merk',$sumatra[$i]['merk']);
			$bid=$dom->createElement('bid',$sumatra[$i]['bid']);
			$tahun=$dom->createElement('tahun',$sumatra[$i]['tahun']);
			

			$sumatraXML->appendChild($type);
			$type->appendChild($nopolisi);
			$type->appendChild($lastbid);
			$type->appendChild($photo);
			$type->appendChild($merk);
			$type->appendChild($bid);
			$type->appendChild($tahun);


			if($sumatra[$i]['last_bidder']==null){
				$lastbidder=$dom->createElement('last_bidder',"Not yet bidded");
			}else{
				$lastbidder=$dom->createElement('last_bidder',$sumatra[$i]['last_bidder']);
			}
			$type->appendChild($lastbidder);
		}

			//kalimantan
		$kalimantanXML=$dom->createElement('Region');
		$kalimantanXML->setAttribute('name','Kalimantan');
		$root->appendChild($kalimantanXML);

		for($i=0;$i<sizeof($kalimantan);$i++){
			if($kalimantan[$i]['type']=='motor'){
				$type=$dom->createElement('motor');
			}else{
				$type=$dom->createElement('mobil');
			}

			$nopolisi=$dom->createElement('no_polisi',$kalimantan[$i]['no_polisi']);
			$lastbid=$dom->createElement('last_bid',$kalimantan[$i]['last_bid']);
			$photo=$dom->createElement('photo',$kalimantan[$i]['photo']);
			$merk=$dom->createElement('merk',$kalimantan[$i]['merk']);
			$bid=$dom->createElement('bid',$kalimantan[$i]['bid']);
			$tahun=$dom->createElement('tahun',$kalimantan[$i]['tahun']);
			

			$kalimantanXML->appendChild($type);
			$type->appendChild($nopolisi);
			$type->appendChild($lastbid);
			$type->appendChild($photo);
			$type->appendChild($merk);
			$type->appendChild($bid);
			$type->appendChild($tahun);
			

			if($kalimantan[$i]['last_bidder']==null){
				$lastbidder=$dom->createElement('last_bidder',"Not yet bidded");
			}else{
				$lastbidder=$dom->createElement('last_bidder',$kalimantan[$i]['last_bidder']);
			}
			$type->appendChild($lastbidder);
		}

			//sulawesi
		$sulawesiXML=$dom->createElement('Region');
		$sulawesiXML->setAttribute('name','Sulawesi');
		$root->appendChild($sulawesiXML);

		for($i=0;$i<sizeof($sulawesi);$i++){
			if($sulawesi[$i]['type']=='motor'){
				$type=$dom->createElement('motor');
			}else{
				$type=$dom->createElement('mobil');
			}

			$nopolisi=$dom->createElement('no_polisi',$sulawesi[$i]['no_polisi']);
			$lastbid=$dom->createElement('last_bid',$sulawesi[$i]['last_bid']);
			$photo=$dom->createElement('photo',$sulawesi[$i]['photo']);
			$merk=$dom->createElement('merk',$sulawesi[$i]['merk']);
			$bid=$dom->createElement('bid',$sulawesi[$i]['bid']);
			$tahun=$dom->createElement('tahun',$sulawesi[$i]['tahun']);
			

			$sulawesiXML->appendChild($type);
			$type->appendChild($nopolisi);
			$type->appendChild($lastbid);
			$type->appendChild($photo);
			$type->appendChild($merk);
			$type->appendChild($bid);
			$type->appendChild($tahun);
			

			if($sulawesi[$i]['last_bidder']==null){
				$lastbidder=$dom->createElement('last_bidder',"Not yet bidded");
			}else{
				$lastbidder=$dom->createElement('last_bidder',$sulawesi[$i]['last_bidder']);
			}
			$type->appendChild($lastbidder);
		}

			//papua
		$papuaXML=$dom->createElement('Region');
		$papuaXML->setAttribute('name','Papua');
		$root->appendChild($papuaXML);

		for($i=0;$i<sizeof($papua);$i++){
			if($papua[$i]['type']=='motor'){
				$type=$dom->createElement('motor');
			}else{
				$type=$dom->createElement('mobil');
			}

			$nopolisi=$dom->createElement('no_polisi',$papua[$i]['no_polisi']);
			$lastbid=$dom->createElement('last_bid',$papua[$i]['last_bid']);
			$photo=$dom->createElement('photo',$papua[$i]['photo']);
			$merk=$dom->createElement('merk',$papua[$i]['merk']);
			$bid=$dom->createElement('bid',$papua[$i]['bid']);
			$tahun=$dom->createElement('tahun',$papua[$i]['tahun']);


			$papuaXML->appendChild($type);
			$type->appendChild($nopolisi);
			$type->appendChild($lastbid);
			$type->appendChild($photo);
			$type->appendChild($merk);
			$type->appendChild($bid);
			$type->appendChild($tahun);
			

			if($papua[$i]['last_bidder']==null){
				$lastbidder=$dom->createElement('last_bidder',"Not yet bidded");
			}else{
				$lastbidder=$dom->createElement('last_bidder',$papua[$i]['last_bidder']);
			}
			$type->appendChild($lastbidder);
		}

			//nusatenggara
		$nusatenggaraXML=$dom->createElement('Region');
		$nusatenggaraXML->setAttribute('name','Nusa Tenggara');
		$root->appendChild($nusatenggaraXML);

		for($i=0;$i<sizeof($nusatenggara);$i++){
			if($nusatenggara[$i]['type']=='motor'){
				$type=$dom->createElement('motor');
			}else{
				$type=$dom->createElement('mobil');
			}

			$nopolisi=$dom->createElement('no_polisi',$nusatenggara[$i]['no_polisi']);
			$lastbid=$dom->createElement('last_bid',$nusatenggara[$i]['last_bid']);
			$photo=$dom->createElement('photo',$nusatenggara[$i]['photo']);
			$merk=$dom->createElement('merk',$nusatenggara[$i]['merk']);
			$bid=$dom->createElement('bid',$nusatenggara[$i]['bid']);
			$tahun=$dom->createElement('tahun',$nusatenggara[$i]['tahun']);
			

			$nusatenggaraXML->appendChild($type);
			$type->appendChild($nopolisi);
			$type->appendChild($lastbid);
			$type->appendChild($photo);
			$type->appendChild($merk);
			$type->appendChild($bid);
			$type->appendChild($tahun);
			

			if($nusatenggara[$i]['last_bidder']==null){
				$lastbidder=$dom->createElement('last_bidder',"Not yet bidded");
			}else{
				$lastbidder=$dom->createElement('last_bidder',$nusatenggara[$i]['last_bidder']);
			}
			$type->appendChild($lastbidder);

		}

			//bali
		$baliXML=$dom->createElement('Region');
		$baliXML->setAttribute('name','Bali');
		$root->appendChild($baliXML);

		for($i=0;$i<sizeof($bali);$i++){
			if($bali[$i]['type']=='motor'){
				$type=$dom->createElement('motor');
			}else{
				$type=$dom->createElement('mobil');
			}

			$nopolisi=$dom->createElement('no_polisi',$bali[$i]['no_polisi']);
			$lastbid=$dom->createElement('last_bid',$bali[$i]['last_bid']);
			$photo=$dom->createElement('photo',$bali[$i]['photo']);
			$merk=$dom->createElement('merk',$bali[$i]['merk']);
			$bid=$dom->createElement('bid',$bali[$i]['bid']);
			$tahun=$dom->createElement('tahun',$bali[$i]['tahun']);
			

			$baliXML->appendChild($type);
			$type->appendChild($nopolisi);
			$type->appendChild($lastbid);
			$type->appendChild($photo);
			$type->appendChild($merk);
			$type->appendChild($bid);
			$type->appendChild($tahun);
			

			if($bali[$i]['last_bidder']==null){
				$lastbidder=$dom->createElement('last_bidder',"Not yet bidded");
			}else{
				$lastbidder=$dom->createElement('last_bidder',$bali[$i]['last_bidder']);
			}
			$type->appendChild($lastbidder);

		}



		$dom->appendChild($root);
		$dom->save($filepath);
	}
	


?>