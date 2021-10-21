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
}

?>
