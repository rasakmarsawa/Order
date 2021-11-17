<?php

	//getting the dboperation class
	require_once 'connection.php';

  include 'pelangganController.php';
	include 'barangController.php';
	include 'pesananController.php';
	include 'statusAntrianController.php';
	include 'detailPesananController.php';

	//function validating all the paramters are available
	//we will pass the required parameters to this function
	function isTheseParametersAvailable($params){
		//assuming all parameters are available
		$available = true;
		$missingparams = "";

		foreach($params as $param){
			if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
				$available = false;
				$missingparams = $missingparams . ", " . $param;
			}
		}

		//if parameters are missing
		if(!$available){
			$response = array();
			$response['error'] = 'E1';
			$response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';

			//displaying error
			echo json_encode($response);

			//stopping further execution
			die();
		}
	}



	//an array to display response
	$response = array();

	//if it is an api call
	//that means a get parameter named api call is set in the URL
	//and with this parameter we are concluding that it is an api call
	if(isset($_GET['function'])){

		switch($_GET['function']){

			//the CREATE operation
			//if the api call value is 'createhero'
			//we will create a record in the database
			case 'register':
				isTheseParametersAvailable(array('username','nama_pelanggan','password','email','no_hp'));

				//creating a new record in the database
        $pelanggan = new pelangganController();
				$result = $pelanggan->register($_POST);


				//if the record is created adding success to response
				if($result){
					$response['error'] = 'E0';
					$response['message'] = 'Proses Berhasil';

				}else{
					$response['error'] = 'E2';
					$response['message'] = 'Username sudah digunakan, Silahkan gunakan username lain.';
				}

			break;
			case 'login':
				isTheseParametersAvailable(array('username','password'));

				$pelanggan = new pelangganController();
				$result = $pelanggan->login($_POST);

				if($result['found']){
					$response['error'] = 'E0';
					$response['message'] = 'Proses Berhasil';
					$response['data'] = $result['data'];
				}else {
					$response['error'] = 'E3';
					$response['message'] = 'Data tidak sesuai';
				}
			break;
			case 'reload_user_data':
				isTheseParametersAvailable(array('username'));

				$pelanggan = new pelangganController();
				$result = $pelanggan->getPelangganByUsername($_POST['username']);

				if($result['found']){
					$response['error'] = 'E0';
					$response['message'] = 'Proses Berhasil';
					$response['data'] = $result['data'];
				}else {
					$response['error'] = 'E4';
					$response['message'] = 'Data tidak ditemukan';
				}
			break;
			case 'get_barang':
				$barang = new BarangController();
				$result = $barang->api_getBarang();
				if ($result['empty']) {
					$response['error'] = 'E4';
					$response['message'] = 'Data tidak ditemukan';
				}else{
					$response['error'] = 'E0';
					$response['message'] = 'Proses Berhasil';
					$response['data'] = $result['data'];
				}
				break;
			case 'get_status_antrian':
				$status = new statusAntrianController();
				$response['data'] = $status->api_getLastStatus();;
				break;
			//--add_pesanan--
			case 'add_pesanan':
				$_POST = json_decode($_POST['data'],true);
				$_POST['tanggal'] = date("Y-m-d",strtotime("now"));
				$pesanan = new pesananController();
				$result = $pesanan->api_addPesanan($_POST);
				if ($result) {
					// addPesanan true
					$detailPesanan = new detailPesananController();
					$result2 = $detailPesanan->api_addDetailPesanan($_POST);
					if ($result2) {
						$response['error'] = 'E0';
						$response['message'] = 'Proses Sukses';
					}else {
						$response['error'] = 'E1';
						$response['message'] = 'Gagal Menambahkan Item Pesanan';
					}
				}else{
					// addPesanan false
				}
				break;
			//--add_pesanan--
      default :
        $response['error'] = 'E99';
        $response['message'] = 'Request Fungsi Invalid';
      break;
		}

	}else{
		$response['error'] = '99';
		$response['message'] = 'Request Fungsi Invalid';
	}

	//displaying the response in json structure
	echo json_encode($response);
