<?php
include 'connection.php';
include 'configController.php';
if (isset($_POST['fcm_token'])) {
  $config = new configController();
  $result = $config->changeConfig('fcm_token', $_POST['fcm_token']);
  if ($result['status']) {
    $data = [
      "status" => true,
      "message" => "token update success"
    ];
  }else{
    $data = [
      "status" => false,
      "message" => "token update fail"
    ];
  }
}else{
  $data = [
    "status" => false,
    "message" => "no fcm token"
  ];
}
echo json_encode($data);
?>
