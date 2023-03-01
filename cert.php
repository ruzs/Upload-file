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
  echo cert_to_png(6, 9); //驗證碼的長短

  function cert_to_png($start, $length)
  {
    $cert = cert_str($start, $length);
    $info=imageftbbox(18,15,'./fonts/arial.ttf',$cert);
    $x_left=min($info[0],$info[2],$info[4],$info[6]);
    $y_top=min($info[1],$info[3],$info[5],$info[7]);
    $x_right=max($info[0],$info[2],$info[4],$info[6]);
    $y_bottom=max($info[1],$info[3],$info[5],$info[7]);
    $border=0;
    $width = ($x_right-$x_left) + $border * 2;
    $height = ($y_bottom-$y_top) + $border * 2;
    $png = imagecreatetruecolor($width, $height);
    $white = imagecolorallocate($png, 255, 255, 255);
    $black = imagecolorallocate($png, 0, 0, 0);
    imagefill($png, 0, 0, $white);
    // echo "<pre>";
    // print_r($info);
    // echo "</pre>";
    $y = $info[1] - $info[7];
    $x_start = 0;
    $y_start = 0;
    imagefttext($png,18,15,0 + $x_start - $x_left +$border,$y_start-$y_top , $black,'./fonts/arial.ttf',$cert);
    for ($i = 0; $i < 5; $i++) {
      $line_left_x = rand(0, 20);
      $line_left_y = rand(0, $height);
      $line_right_x = rand($width - 20, $width);
      $line_right_y = rand(0, $height);
      $line_color = imagecolorallocate($png, rand(100, 200), rand(100, 200), rand(100, 200));
      imageline($png, $line_left_x, $line_left_y, $line_right_x, $line_right_y, $line_color);
    }
    /*
    for ($i = 0; $i < strlen($cert); $i++) {
      $c = mb_substr($cert, $i, 1);
      imagestring($png, 5, $x_start, rand(10, 30), $c, $white);
      $gap = rand(5, 15);
      $x_start = $x_start + 10 + $gap;
    }*/
    imagepng($png, './cert.png');
    return $cert;
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
<img src="cert.png" alt="" style="border:2px solid green">
</body>
</html>