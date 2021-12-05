<?php
/**
 *
 */
class userController
{

  function __construct(){

  }

  function login($username,$password){
    $sql = "select * from kasir where username = '".$username."' and password = md5('".$password."')";
    $result = $GLOBALS['mysqli']->query($sql);

    if(mysqli_num_rows($result)==1){
      $_SESSION = mysqli_fetch_assoc($result);
      $data = true;
    }else{
      $data = false;
    }
    $GLOBALS['mysqli']->close();

    return $data;
  }
}

?>
