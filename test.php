<?php
$sql = "select DATE(getNow()) as today";
$today = $GLOBALS['mysqli']->query($sql);
if (mysqli_num_rows($today)==1) {
  $data = mysqli_fetch_assoc($today);
  print_r($data);
}
?>
