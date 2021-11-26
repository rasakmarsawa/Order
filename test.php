<?php
// $to = "somebody@example.com, somebodyelse@example.com";
$to = "marsawa002@gmail.com";
$subject = "Account Verification Email";

$message = '
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <a href="http://onlinetrisha.000webhostapp.com">
      <button type="button" name="button">Click Here</button>
    </a>
  </body>
</html>
';

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <support@trisha.com>' . "\r\n";
// $headers .= 'Cc: myboss@example.com' . "\r\n";

mail($to,$subject,$message,$headers);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <a href="http://onlinetrisha.000webhostapp.com">
      <button type="button" name="button">Click Here</button>
    </a>
  </body>
</html>
