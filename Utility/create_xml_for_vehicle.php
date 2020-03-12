<?php

	$mobil=array();
	$motor=array();

	$query="SELECT * FROM mobil";
	$result=mysqli_query($con,$query);
	while($row=mysqli_fetch_array($result)){
		array_push($mobil,$row);
	}

	$query="SELECT * FROM motor";
	$result=mysqli_query($con,$query);
	while($row=mysqli_fetch_array($result)){
		array_push($motor,$row);
	}

	//creating XML
	createMobilXML($mobil);
	createMotorXML($motor);
	
	function createMobilXML($mobil){

		$filepath="Utility/xml/mobil.xml";
		$dom=new DOMdocument('1.0','utf-8');
		$root=$dom->createElement('mobil');

		for($i=0;$i<sizeof($mobil);$i++){
			$nopolisi=$dom->createElement('no_polisi');
			$nopolisi->setAttribute('no',$mobil[$i]['no_polisi']);
			$root->appendChild($nopolisi);

			$kondisi=$dom->createElement('kondisi',$mobil[$i]['kondisi']);
			$tahun=$dom->createElement('tahun',$mobil[$i]['tahun']);
			$transmisi=$dom->createElement('transmisi',$mobil[$i]['transmisi']);
			$bahanbakar=$dom->createElement('bahanbakar',$mobil[$i]['bahanbakar']);
			$kilometer=$dom->createElement('kilometer',$mobil[$i]['kilometer']);
			$warna=$dom->createElement('warna',$mobil[$i]['warna']);
			$tempatduduk=$dom->createElement('tempatduduk',$mobil[$i]['tempatduduk']);
			$pintu=$dom->createElement('pintu',$mobil[$i]['pintu']);
			$panjang=$dom->createElement('panjang',$mobil[$i]['panjang']);
			$lebar=$dom->createElement('lebar',$mobil[$i]['lebar']);
			$tinggi=$dom->createElement('tinggi',$mobil[$i]['tinggi']);

			$nopolisi->appendChild($kondisi);
			$nopolisi->appendChild($tahun);
			$nopolisi->appendChild($transmisi);
			$nopolisi->appendChild($bahanbakar);
			$nopolisi->appendChild($kilometer);
			$nopolisi->appendChild($warna);
			$nopolisi->appendChild($tempatduduk);
			$nopolisi->appendChild($pintu);
			$nopolisi->appendChild($panjang);
			$nopolisi->appendChild($lebar);
			$nopolisi->appendChild($tinggi);

		}

		$dom->appendChild($root);
		$dom->save($filepath);

	}

	function createMotorXML($motor){

		$filepath="Utility/xml/motor.xml";
		$dom=new DOMdocument('1.0','utf-8');
		$root=$dom->createElement('motor');

		for($i=0;$i<sizeof($motor);$i++){
			$nopolisi=$dom->createElement('no_polisi');
			$nopolisi->setAttribute('no',$motor[$i]['no_polisi']);
			$root->appendChild($nopolisi);

			$kondisi=$dom->createElement('kondisi',$motor[$i]['kondisi']);
			$tahun=$dom->createElement('tahun',$motor[$i]['tahun']);
			$transmisi=$dom->createElement('transmisi',$motor[$i]['transmisi']);
			$bahanbakar=$dom->createElement('bahanbakar',$motor[$i]['bahanbakar']);
			$kilometer=$dom->createElement('kilometer',$motor[$i]['kilometer']);
			$warna=$dom->createElement('warna',$motor[$i]['warna']);
			$maxspeed=$dom->createElement('maxspeed',$motor[$i]['maxspeed']);
			$suspension=$dom->createElement('suspension',$motor[$i]['suspension']);
			$panjang=$dom->createElement('panjang',$motor[$i]['panjang']);
			$lebar=$dom->createElement('lebar',$motor[$i]['lebar']);
			$tinggi=$dom->createElement('tinggi',$motor[$i]['tinggi']);

			$nopolisi->appendChild($kondisi);
			$nopolisi->appendChild($tahun);
			$nopolisi->appendChild($transmisi);
			$nopolisi->appendChild($bahanbakar);
			$nopolisi->appendChild($kilometer);
			$nopolisi->appendChild($warna);
			$nopolisi->appendChild($maxspeed);
			$nopolisi->appendChild($suspension);
			$nopolisi->appendChild($panjang);
			$nopolisi->appendChild($lebar);
			$nopolisi->appendChild($tinggi);

		}

		$dom->appendChild($root);
		$dom->save($filepath);

	}

?>