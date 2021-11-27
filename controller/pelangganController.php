<?php
/**
 *
 */
class pelangganController
{
  function __construct(){}

  function getPelangganById($id){
    $sql = "select * from pelanggan where username = '".$id."'";
    $result = $GLOBALS['mysqli']->query($sql);

    if (mysqli_num_rows($result)==1) {
      $data = mysqli_fetch_assoc($result);
    }else{
      $data = null;
    }
    return $data;
  }

  function getActivity($id){
    $sql = "
    select topup.tanggal, topup.no, topup.jumlah_topup as jumlah, 'Topup' as type
      from topup where topup.id_pelanggan = '".$id."'
    union
    select pesanan.tanggal, pesanan.no, pesanan.total_harga as jumlah, 'Pesanan' as type
      from pesanan where pesanan.id_pelanggan = '".$id."'
    order by tanggal,no asc, type desc
    ";
    $result = $GLOBALS['mysqli']->query($sql);

    $arr = array();
    $i=0;
    while ($data = mysqli_fetch_assoc($result)) {
      $arr[$i]=$data;
      $i++;
    }

    return $arr;
  }

  function register($arr){
    $sql = "insert into pelanggan (username,nama_pelanggan,password,email,no_hp,saldo) values
    ('".$arr['username']."',
    '".$arr['nama_pelanggan']."',
    md5('".$arr['password']."'),
    '".$arr['email']."',
    '".$arr['no_hp']."',
    0)";

    $result = $GLOBALS['mysqli']->query($sql);

    return $result;
  }

  function login($arr){
    $sql = "select * from pelanggan where username = '".$arr['username']."' and password = md5('".$arr['password']."')";
    $result = $GLOBALS['mysqli']->query($sql);

    $data = array();
    if(mysqli_num_rows($result)==1){
      $data['found'] = true;
      $data['data'] = mysqli_fetch_assoc($result);
    }else{
      $data['found'] = false;
    }
    return $data;
  }

  function getPelangganByUsername($username){
    $sql = "select * from pelanggan where username = '".$username."'";
    $result = $GLOBALS['mysqli']->query($sql);

    $data = array();
    if(mysqli_num_rows($result)==1){
      $data['found'] = true;
      $data['data'] = mysqli_fetch_assoc($result);
    }else{
      $data['found'] = false;
    }
    return $data;
  }

  function updateToken($post){
    $this->clearToken($post);

    $sql = "update pelanggan set fcm_token = '".$post['fcm_token']."' where username = '".$post['username']."'";
    $result = $GLOBALS['mysqli']->query($sql);
    return $result;
  }

  function clearToken($post){
    $sql = "update pelanggan set fcm_token = NULL where fcm_token = '".$post['fcm_token']."'";
    $result = $GLOBALS['mysqli']->query($sql);

    return $result;
  }

  function getAllToken(){
    $sql = "select fcm_token from pelanggan where fcm_token is not null";
    $result = $GLOBALS['mysqli']->query($sql);

    $arr = array();
    $i=0;
    while ($data = mysqli_fetch_assoc($result)) {
      $arr[$i]=$data['fcm_token'];
      $i++;
    }

    return $arr;
  }

  function requestHandle($post){
    //get request type
    $sql = "select username,request_type from pelanggan where
     request_key = '".$post['request_key']."' and
     request_create + interval 5 minute >= current_timestamp";
    $result = $GLOBALS['mysqli']->query($sql);

    $data = array();
    $data['found'] = false;

    if(mysqli_num_rows($result)==1){
      $data['found'] = true;
      $data['data'] = mysqli_fetch_assoc($result);
      $data['success'] = false;
    }

    //handle
    if ($data['found']==true) {
      switch ($data['data']['request_type']) {
        case 'REG':
          $sql = "update pelanggan set verify_status = 1,
            request_create = NULL, request_type = NULL, request_key = NULL
            where username = '".$data['data']['username']."'";

          $result = $GLOBALS['mysqli']->query($sql);
          $data['success'] = true;
          break;

        default:
          $data['success'] = false;
          break;
      }
    }
    return $data;
  }

  function clearUnveryfied(){
    $sql = "delete from pelanggan where verify_status = 0 and
    request_create + interval 5 minute < current_timestamp";

    $GLOBALS['mysqli']->query($sql);
  }

  function getPelangganForgot($post){
    $sql = "select * from pelanggan where username = '".$post['username']."'
    and email = '".$post['email']."'";
    $result = $GLOBALS['mysqli']->query($sql);

    $data = array();
    $data['found'] = false;
    if(mysqli_num_rows($result)==1){
      $data['found'] = true;
      $data['data'] = mysqli_fetch_assoc($result);
    }
    return $data;
  }
}

?>
