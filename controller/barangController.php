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
    $sql = "select * from barang";
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
}

?>
