<?php
/**
 *
 */
class statusAntrianController
{

  function __construct(){}

  function getLastStatus(){
    $sql = "select status from status_antrian where tanggal = CURRENT_DATE and no = (select max(no) from status_antrian WHERE tanggal = CURRENT_DATE);";
    $result = $GLOBALS['mysqli']->query($sql);

    if (mysqli_num_rows($result)==1) {
      $data = mysqli_fetch_assoc($result);
    }else{
      $data = array('status'=>'2');
    }
    return $data;
  }

  function statusMeaning($status){
    switch ($status) {
      case '1':
        return 'Buka';
        break;
      default:
        return 'Tutup';
        break;
    }
  }

  function updateStatus($status,$id_kasir){
    $sql = "insert into status_antrian (status,id_kasir) values (".$status.",'".$id_kasir."')";
    $result = $GLOBALS['mysqli']->query($sql);

    return $result;
  }

  function api_getLastStatus(){
    $data = $this->getLastStatus();
    return $data;
  }
}

 ?>
