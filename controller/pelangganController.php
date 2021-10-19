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
}

?>
