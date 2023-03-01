<?php

/****
 * 1.建立資料庫及資料表
 * 2.建立上傳圖案機制
 * 3.取得圖檔資源
 * 4.進行圖形處理
 *   ->圖形縮放
 *   ->圖形加邊框
 *   ->圖形驗證碼
 * 5.輸出檔案
 */

if (!empty($_FILES['img']['tmp_name'])) {
  move_uploaded_file($_FILES['img']['tmp_name'], './upload/' . $_FILES['img']['name']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>文字檔案匯入</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1 class="header">圖形處理練習</h1>
  <!---建立檔案上傳機制--->
  <form action="?" method="post" enctype="multipart/form-data">
    <input type="file" name="img" id="img">
    <input type="submit" value="上傳">
  </form>
  <?php
  if (file_exists('./upload/' . $_FILES['img']['name'])) {
    echo "<img src='./upload/{$_FILES['img']['name']}'>";
  };
  ?>
  <!----縮放圖形----->
  <?php
  //要使用imagecreatefromjpeg()必須開啟 GD 要把php.ini的extension=gd的註解取消, php.ini的開頭必須是[PHP]
  $image = imagecreatefromjpeg("./upload/" . $_FILES['img']['name']);
  $w = 150;
  $h = 150;
  $dst = imagecreatetruecolor($w, $h);
  $imageinfo = getimagesize("./upload/" . $_FILES['img']['name']);
  /* echo "<pre>";
  print_r($imageinfo);
  echo "</pre>"; */
  imagecopyresampled($dst, $image, 0, 0, 0, 0, $w, $h, $imageinfo[0], $imageinfo[1]);
  imagejpeg($dst, 'dst.jpg');
  ?>
  <img src="dst.jpg" alt="">
  <!----圖形加邊框----->
  <?php
  $w = $imageinfo[0] + 20;
  $h = $imageinfo[1] + 20;
  $dst = imagecreatetruecolor($w, $h);
  $color = imagecolorallocate($dst, 255, 155, 55);
  imagefill($dst, 0, 0, $color);
  /* echo "<pre>";
  print_r($imageinfo);
  echo "</pre>"; */
  imagecopyresampled($dst, $image, 10, 10, 0, 0, $imageinfo[0], $imageinfo[1], $imageinfo[0], $imageinfo[1]);
  imagejpeg($dst, 'border.jpg');
  ?>
  <img src="border.jpg" alt="">

  <!----產生圖形驗證碼----->
  <?php
  /**
   * 1.長度大概是4~6個字
   * 2.可能有數,大小寫英文
   */
  echo cert_to_png(0, 5);
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