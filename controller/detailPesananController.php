<?php
/**
 *
 */
class detailPesananController
{

  function __construct(){}

  function getDetailPesananByPesanan($post){
    $sql = "SELECT detail_pesanan.*, barang.nama_barang
    FROM detail_pesanan
    INNER JOIN barang ON detail_pesanan.id_barang = barang.id_barang
    WHERE tanggal = '".$post['tanggal']."' AND no = ".$post['no'];
    $result = $GLOBALS['mysqli']->query($sql);

    $arr = array();
    $i=0;
    while ($data = mysqli_fetch_assoc($result)) {
      $arr[$i]=$data;
      $i++;
    }

    return $arr;
  }
}

?>
