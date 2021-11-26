<?php

	//getting the dboperation class
	require_once 'connection.php';

  include 'pelangganController.php';
	include 'barangController.php';
	include 'pesananController.php';
	include 'statusAntrianController.php';
	include 'detailPesananController.php';
	include 'notification.php';

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
			$response['error'] = 'E01';
			$response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';

			//displaying error
			echo json_encode($response);

			//stopping further execution
			die();
		}
	}

	$response = array();
	if(isset($_GET['function'])){

		switch($_GET['function']){
			case 'register':
				$_POST = json_decode($_POST['data'],true);
				isTheseParametersAvailable(array('username','nama_pelanggan','password','email','no_hp'));

        $pelanggan = new pelangganController();
				$result = $pelanggan->register($_POST);

				if($result){
					$response['error'] = 'E10';
					$response['message'] = 'Proses Berhasil';

				}else{
					$response['error'] = 'E11';
					$response['message'] = 'Username sudah digunakan, Silahkan gunakan username lain.';
				}

			break;
			case 'login'://1
				$_POST = json_decode($_POST['data'],true);
				isTheseParametersAvailable(array('username','password'));

				$pelanggan = new pelangganController();
				$result = $pelanggan->login($_POST);

				if($result['found']){
					$response['error'] = 'E20';
					$response['message'] = 'Proses Berhasil';
					$response['data'] = $result['data'];

					$token = $result['data']['fcm_token'];
					if ($_POST!=$token && $token!=NULL) {
						//force logout in other device
						//send message to fcm
						pushNotification(
							$token,
							"Login Akun",
							"Akun anda telah login di perangkat lain",
							"2",
							null,
							"LoginActivity"
						);
					}

					//Input FCM_TOKEN
					$response['token']=$pelanggan->updateToken($_POST);
				}else {
					$response['error'] = 'E21';
					$response['message'] = 'Data tidak sesuai';
				}
			break;
			case 'reload_user_data'://2
				$_POST = json_decode($_POST['data'],true);
				isTheseParametersAvailable(array('username'));

				$pelanggan = new pelangganController();
				$result = $pelanggan->getPelangganByUsername($_POST['username']);

				if($result['found']){
					$response['error'] = 'E00';
					$response['message'] = 'Proses Berhasil';
					$response['data'] = $result['data'];
				}else {
					$response['error'] = 'E31';
					$response['message'] = 'Data tidak ditemukan';
				}
			break;
			case 'get_barang'://3
				$barang = new BarangController();
				$result = $barang->api_getBarang();
				if ($result['empty']) {
					$response['error'] = 'E41';
					$response['message'] = 'Data tidak ditemukan';
				}else{
					$response['error'] = 'E40';
					$response['message'] = 'Proses Berhasil';
					$response['data'] = $result['data'];
				}
				break;
			case 'get_status_antrian'://4
				$status = new statusAntrianController();
				$response['data'] = $status->api_getLastStatus();;
				break;
			//--add_pesanan--
			case 'add_pesanan'://5
				$_POST = json_decode($_POST['data'],true);
				$_POST['tanggal'] = date("Y-m-d",strtotime("now"));
				$pesanan = new pesananController();
				$result = $pesanan->api_addPesanan($_POST);
				if ($result) {
					// addPesanan true
					$detailPesanan = new detailPesananController();
					$result2 = $detailPesanan->api_addDetailPesanan($_POST);
					if ($result2) {
						$response['error'] = 'E50';
						$response['message'] = 'Proses Sukses';
					}else {
						$response['error'] = 'E52';
						$response['message'] = 'Gagal Menambahkan Item Pesanan';
					}
				}else{
					$response['error'] = 'E51';
					$response['message'] = 'Gagal Menambahkan Pesanan';
				}
				break;
			//--add_pesanan--
			//--getAntrianByUser--
			case 'get_antrian_by_user'://6
				$_POST = json_decode($_POST['data'],true);
				$pesanan = new pesananController();
				$result = $pesanan->api_getAntrianByUser($_POST);
				if ($result['empty']) {
					$response['error'] = 'E61';
					$response['message'] = 'Data tidak ditemukan';
				}else{
					$response['error'] = 'E60';
					$response['message'] = 'Proses Berhasil';
					$response['data'] = $result['data'];
				}
				break;
			//--getAntrianByUser--
			case 'get_detail_pesanan_by_pesanan'://7
				$_POST = json_decode($_POST['data'],true);
				$detail = new detailPesananController();
				$result = $detail->api_getDetailPesananByPesanan($_POST);
				if ($result['empty']) {
					$response['error'] = 'E71';
					$response['message'] = 'Data tidak ditemukan';
				}else{
					$response['error'] = 'E70';
					$response['message'] = 'Proses Berhasil';
					$response['data'] = $result['data'];
				}
				break;
			case 'get_history'://8
				$_POST = json_decode($_POST['data'],true);
				$pesanan = new pesananController();
				$result = $pesanan->api_getHistoryByUser($_POST);
				if ($result['empty']) {
					$response['error'] = 'E81';
					$response['message'] = 'Data tidak ditemukan';
				}else{
					$response['error'] = 'E80';
					$response['message'] = 'Proses Berhasil';
					$response['data'] = $result['data'];
					$response['test'] = $_POST;
				}
				break;
			case 'cancel':
				$_POST = json_decode($_POST['data'],true);
				$pesanan = new pesananController();
				$result = $pesanan->api_cancel($_POST);
				if($result){
					$response['error'] = 'E90';
					$response['message'] = 'Proses Berhasil';
				}else{
					$response['error'] = 'E91';
					$response['message'] = 'Cancel Fail';
				}
				break;
			case 'logout':
				$_POST = json_decode($_POST['data'],true);
				$pelanggan = new pelangganController();
				$result = $pelanggan->clearToken($_POST);
				if($result){
					$response['error'] = 'E100';
					$response['message'] = 'Proses Berhasil';
				}else{
					$response['error'] = 'E101';
					$response['message'] = 'Proses Gagal';
				}
			break;
      default :
        $response['error'] = 'E01';
        $response['message'] = 'Request Fungsi Invalid';
      break;
		}

	}else{
		$response['error'] = 'E01';
		$response['message'] = 'Request Fungsi Invalid';
	}

	echo json_encode($response);
