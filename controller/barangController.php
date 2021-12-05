<?php
/**
 *
 */
class barangController
{

  function __construct(){

  }

  function addBarang($nama,$harga){
    $sql = "insert into barang (nama_barang,harga) values ('".$nama."',".$harga.")";
    $result = $GLOBALS['mysqli']->query($sql);

    return $result;
  }

  function getBarang(){
    $sql = "select * from barang order by nama_barang desc";
    $result = $GLOBALS['mysqli']->query($sql);

    $arr = array();
    $i=0;
    while ($data = mysqli_fetch_assoc($result)) {
      $arr[$i]=$data;
      $i++;
    }

    return $arr;
  }

  function getBarangById($id){
    $sql = "select * from barang where id_barang = ".$id;
    $result = $GLOBALS['mysqli']->query($sql);

    if (mysqli_num_rows($result)==1) {
      $data = mysqli_fetch_assoc($result);
    }else{
      $data = null;
    }

    return $data;
  }

  function deleteBarangById($id){
    $sql = "delete from barang where id_barang=".$id;
    $result = $GLOBALS['mysqli']->query($sql);

    return $result;
  }

  function updateBarang($post){
    $sql = "update barang set nama_barang='".$post['nama_barang']."' , harga=".$post['harga']." where id_barang=".$post['id'];
    $result = $GLOBALS['mysqli']->query($sql);

    return $result;
  }

  function getBarangSaleToday(){
    $sql = "select barang.nama_barang,sum(detail_pesanan.jumlah_barang) as jumlah_barang from barang inner join detail_pesanan on barang.id_barang = detail_pesanan.id_barang inner join pesanan on detail_pesanan.tanggal = pesanan.tanggal and detail_pesanan.no = pesanan.no where detail_pesanan.tanggal = DATE(getNow()) and pesanan.status = 4  group by barang.id_barang";

    $result = $GLOBALS['mysqli']->query($sql);

    $arr = array();
    $i=0;
    while ($data = mysqli_fetch_assoc($result)) {
      $arr[$i]=$data;
      $i++;
    }

    return $arr;
  }

  function getDetailBarang($id){
    $sql = "select * from barang inner join detail_pesanan on detail_pesanan.id_barang = barang.id_barang inner join pesanan on pesanan.tanggal = detail_pesanan.tanggal and pesanan.no = detail_pesanan.no inner join pelanggan on pesanan.id_pelanggan = pelanggan.username where pesanan.status = 4 and barang.id_barang = ".$id;

    $result = $GLOBALS['mysqli']->query($sql);

    $arr = array();
    $i=0;
    while ($data = mysqli_fetch_assoc($result)) {
      $arr[$i]=$data;
      $i++;
    }

    return $arr;
  }

  function api_getBarang(){
    $data = $this->getBarang();
    $result = array();

    if (count($data)!=0) {
      $result['empty']=false;
      $result['data']=$data;
    }else{
      $result['empty']=true;
    }

    return $result;
  }
}

?>
