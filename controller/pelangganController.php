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
    $GLOBALS['mysqli']->close();

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
    $GLOBALS['mysqli']->close();

    return $data;
  }
}

?>
