<?php
/**
 *
 */
class pesananController
{

  function __construct(){}

  function getPesanan(){
    $sql = "SELECT
    pesanan.*,
    pelanggan.nama_pelanggan,
    status_pesanan.nama_status
    FROM pesanan
    INNER JOIN pelanggan ON pesanan.id_pelanggan = pelanggan.username
    INNER JOIN status_pesanan ON pesanan.status = status_pesanan.id_status";

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
    pelanggan.nama_pelanggan,
    status_pesanan.nama_status
    FROM pesanan
    INNER JOIN pelanggan ON pesanan.id_pelanggan = pelanggan.username
    INNER JOIN status_pesanan ON pesanan.status = status_pesanan.id_status
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
    pelanggan.nama_pelanggan,
    pelanggan.fcm_token,
    status_pesanan.*
    FROM pesanan
    INNER JOIN pelanggan ON pesanan.id_pelanggan = pelanggan.username
    INNER JOIN status_pesanan ON pesanan.status = status_pesanan.id_status
    WHERE pesanan.tanggal = '".$post['tanggal']."' AND pesanan.no = ".$post['no'];
    $result = $GLOBALS['mysqli']->query($sql);

    if (mysqli_num_rows($result)==1) {
      $data = mysqli_fetch_assoc($result);
    }else{
      $data = null;
    }

    return $data;
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
    $sql = "insert into pesanan(
      `tanggal`,
      `total_harga`,
      `id_pelanggan`
      )
    values (
      '".$post['tanggal']."',
      ".$post['total_harga'].",
      '".$post['id_pelanggan']."'
    )";
    $result = $GLOBALS['mysqli']->query($sql);
    return $result;
  }

  function api_getAntrianByUser($post){
    $sql = "SELECT
      *,
      status_pesanan.nama_status
    FROM pesanan
    INNER JOIN status_pesanan ON
      pesanan.status = status_pesanan.id_status
    WHERE
      id_pelanggan = '".$post['username']."' AND
      status < 4 order by tanggal desc, no desc";

    $res = $GLOBALS['mysqli']->query($sql);

    $arr = array();
    $i=0;
    while ($data = mysqli_fetch_assoc($res)) {
      $arr[$i]=$data;
      $i++;
    }

    if (count($arr)>0) {
      $result['empty']=false;
      $result['data']=$arr;
    }else{
      $result['empty']=true;
    }

    return $result;
  }

  function api_getHistoryByUser($post){
    $start = $post['start'];
    $end = $start + $post['length'] - 1;

    $sql = "SELECT * FROM (SELECT ROW_NUMBER()
      OVER(ORDER BY tanggal desc, no desc) AS row_no,
      pesanan.* FROM pesanan WHERE id_pelanggan = '".$post['username']."' AND status > 3) AS A
      WHERE row_no >= ".$start." AND row_no <= ".$end;

    $res = $GLOBALS['mysqli']->query($sql);

    $arr = array();
    $i=0;
    while ($data = mysqli_fetch_assoc($res)) {
      $arr[$i]=$data;
      $i++;
    }

    if (count($arr)>0) {
      $result['empty']=false;
      $result['data']=$arr;
    }else{
      $result['empty']=true;
    }

    return $result;
  }

  function api_cancel($post){
    $sql = "update pesanan set pesanan.status = 5 where pesanan.tanggal = '".$post['tanggal']."' and pesanan.no = ".$post['no'];
    $result = $GLOBALS['mysqli']->query($sql);
    return $result;
  }

  function addPesananGuess($post, $barangList){
    $total_harga = 0;

    $dataPesanan = [
      'tanggal' => date("Y-m-d",strtotime("now")),
      'id_pelanggan' => ''
    ];
    $dataDetail = array();
    $i=0;
    foreach ($post as $key => $value) {
      if (is_numeric($key) && $value!=0) {
        $total_harga = $total_harga+($barangList[$key]['harga']*$value);
        $dataDetail[$i]['id_barang'] = $barangList[$key]['id_barang'];
        $dataDetail[$i]['jumlah_barang'] = $value;
        $i++;
      }
    }
    $dataPesanan['total_harga'] = $total_harga;

    $format = [
      "item" => $dataDetail,
      "tanggal" => $dataPesanan['tanggal']
    ];

    $data = [
      "dataPesanan" => $dataPesanan,
      "dataDetail" => $format
    ];

    return $data;
  }
}

?>
