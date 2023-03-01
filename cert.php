<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>圖形驗證碼</title>
</head>

<body>
  <?php
  /**
   * 1.長度大概是4~6個字
   * 2.可能有數,大小寫英文
   */
  echo cert_to_png(4, 7); //驗證碼的長短
  function cert_to_png($start, $length)
  {
    $cert = cert_str($start, $length);
    $png = imagecreatetruecolor(200, 50);
    $white = imagecolorallocate($png, 255, 255, 255);
    imagestring($png, 5, 10, 10, $cert, $white);
    imagepng($png, './cert.png');
    //    return $cert;
  }
  function cert_str($start, $length)
  {
    $cert = '';
    $l = rand($start, $length);
    for ($i = 0; $i < $l; $i++) {
      $type = rand(1, 3);
      switch ($type) {
        case 1:
          $cert .= rand(0, 9);
          break;
        case 2:
          $cert .= chr(rand(65, 90));
          break;
        case 3:
          $cert .= chr(rand(97, 122));
          break;
      }
    }
    return $cert;
  }
  ?>
  <img src="cert.png" alt="">
</body>

</html>