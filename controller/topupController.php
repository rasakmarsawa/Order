<?php
/**
 *
 */
class topupController
{
  function __construct(){}

  function addTopup($post){
    $sql = "insert into topup (jumlah_topup,id_kasir,id_pelanggan)
    values (
      ".$post['jumlah_topup'].",
      '".$post['id_kasir']."',
      '".$post['id_pelanggan']."'
      )";
    $result = $GLOBALS['mysqli']->query($sql);

    return $result;
  }
}

?>
