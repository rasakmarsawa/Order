<?php
/**
 *
 */
class pesananController
{

  function __construct(){}

  function getPesanan(){
    $sql = "SELECT pesanan.*, pelanggan.nama_pelanggan FROM pesanan INNER JOIN pelanggan ON pesanan.id_pelanggan = pelanggan.username";

    $result = $GLOBALS['mysqli']->query($sql);

    $arr = array();
    $i=0;
    while ($data = mysqli_fetch_assoc($result)) {
      $arr[$i]=$data;
      $i++;
    }

    return $arr;
  }

  function getAntrian(){
    $sql = "SELECT
    pesanan.*,
    pelanggan.nama_pelanggan
    FROM pesanan
    INNER JOIN pelanggan ON pesanan.id_pelanggan = pelanggan.username
    WHERE tanggal = current_date and pesanan.status<4";
    $result = $GLOBALS['mysqli']->query($sql);

    $arr = array();
    $i=0;
    while ($data = mysqli_fetch_assoc($result)) {
      $arr[$i]=$data;
      $i++;
    }

    return $arr;
  }

  function getPesananById($post){
    $sql = "SELECT
    pesanan.*,
    pelanggan.nama_pelanggan
    FROM pesanan
    INNER JOIN pelanggan ON pesanan.id_pelanggan = pelanggan.username
    WHERE pesanan.tanggal = '".$post['tanggal']."' AND pesanan.no = ".$post['no'];
    $result = $GLOBALS['mysqli']->query($sql);

    if (mysqli_num_rows($result)==1) {
      $data = mysqli_fetch_assoc($result);
    }else{
      $data = null;
    }

    return $data;
  }

  function statusMeaning($status){
    switch ($status) {
      case '1':
        return 'Menunggu';
        break;
      case '2':
        return 'Dalam Proses';
        break;
      case '3':
        return 'Menunggu Pengambilan';
        break;
      case '4':
        return 'Selesai';
        break;
      case '5':
        return 'Dibatalkan';
        break;
    }
  }

  function next($post){
    $sql = "UPDATE pesanan SET pesanan.status=pesanan.status+1 WHERE pesanan.tanggal = '".$post['tanggal']."' AND pesanan.no = ".$post['no'];
    $result = $GLOBALS['mysqli']->query($sql);

    return $result;
  }

  function getPesananToday(){
    $sql = "select * from pesanan where tanggal = current_date and status = 4";

    $result = $GLOBALS['mysqli']->query($sql);

    $arr = array();
    $i=0;
    while ($data = mysqli_fetch_assoc($result)) {
      $arr[$i]=$data;
      $i++;
    }

    return $arr;
  }

  function api_addPesanan($post){
    $sql = "insert into pesanan(`tanggal`,`total_harga`,`id_pelanggan`) values ('".$post['tanggal']."',".$post['total_harga'].",'".$post['id_pelanggan']."')";
    $result = $GLOBALS['mysqli']->query($sql);
    return $result;
  }

}

?>
