<?php
/**
 *
 */
class detailPesananController
{

  function __construct(){}

  function getDetailPesananByPesanan($post){
    $sql = "SELECT detail_pesanan.*, barang.nama_barang, barang.harga
    FROM detail_pesanan
    INNER JOIN barang ON detail_pesanan.id_barang = barang.id_barang
    WHERE tanggal = '".$post['tanggal']."' AND no = ".$post['no']."
    ORDER BY barang.nama_barang desc";
    $result = $GLOBALS['mysqli']->query($sql);

    $arr = array();
    $i=0;
    while ($data = mysqli_fetch_assoc($result)) {
      $arr[$i]=$data;
      $i++;
    }

    return $arr;
  }

  function api_addDetailPesanan($post){
    $sql = "insert into detail_pesanan (`tanggal`,`id_barang`,`jumlah_barang`) values ";
    foreach ($post['item'] as $key => $value) {
      $sql = $sql."(current_date,".$value['id_barang'].",".$value['jumlah_barang']."),";
    }
    $sql = substr($sql,0,strlen($sql)-1);
    $result = $GLOBALS['mysqli']->query($sql);
    return $sql;
  }

  function api_getDetailPesananByPesanan($post){
      $data = $this->getDetailPesananByPesanan($post);

      $result = array();

      if (count($data)!=0) {
        $result['empty']=false;
        $result['data']=$data;
      }else{
        $result['empty']=true;
      }

      return $result;
  }

  function getDetailByBarangTerjual(){
    $sql = "
    SELECT
        SUM(jumlah_barang) as jumlah_barang,
        barang.nama_barang
    FROM detail_pesanan
    INNER JOIN pesanan ON
    	pesanan.tanggal = detail_pesanan.tanggal AND
        pesanan.no = detail_pesanan.no
    INNER JOIN barang ON
    	barang.id_barang = detail_pesanan.id_barang
    WHERE YEAR(pesanan.tanggal) = YEAR(getNow())
    GROUP BY detail_pesanan.id_barang
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
