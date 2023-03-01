<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>文字圖形處理練習</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
  <style>
    #uploadForm {
      width: 400px;
      margin: 1rem auto;
      font-size: 1.25rem;
      padding: 1rem;
    }

    #list {
      border-collapse: collapse;
      box-shadow: 0 0 10px #ccc;
      margin: 1rem auto;
    }

    #list img {
      width: 150px;
    }

    #list td,
    #list th {
      border: 1px solid #ccc;
      padding: 0.5rem 1.1rem;
      font-size: 1.15rem;
    }

    #list tr:hover {
      background: lightgreen;
      transform: scale(1.1);
    }

    .reload {
      display: block;
      margin: 1rem auto;
      padding: 0.5rem 1.5rem;
      font-size: 1.2rem;
    }
  </style>
</head>

<body>
  <h1 class="header">文字圖形處理練習</h1>
  <!---建立檔案上傳機制--->

  <!-- <form id="uploadForm" action="?" method="post" enctype="multipart/form-data">
    <div>
        長度: <input type="number" name="length" value="4">
    </div>
    <div>
        <input type="number" step="1" name="size" value="24">
    </div>   
    <div>
        <select name="color" >
            <option value="blue">藍色</option>
            <option value="red">紅色</option>
            <option value="green">綠色</option>
        </select>
    </div>   
    <input type="submit" value="產生驗證碼">
</form> -->
  <!--使用按鈕每次點擊時重整頁面來重新產生圖形驗證碼-->
  <button onclick="location.reload()" class='reload'>產生驗證碼</button>
  <?php

  //使用亂數來產生驗證碼長度
  $length = rand(4, 8);

  //定義字型大小
  $fontsize = 24;

  //宣告一個空字串，用來存放驗證碼字串
  $gstr = "";

  //使用for迴圈來產生符合$length的驗證碼
  for ($i = 0; $i < $length; $i++) {

    //使用while迴圈來判斷字串是否有重覆的字元
    while (mb_strlen($gstr) < $i + 1) {

      //使用亂數來決定這一次迴圈的字元類型
      $type = rand(1, 3);
      switch ($type) {
        case 1:
          $t = rand(0, 9);       //使用rand()來產生0~9的任一數字
          break;
        case 2:
          $t = chr(rand(65, 90)); //使用chr()函式根據ASCII碼產生大寫字母
          break;
        case 3:
          $t = chr(rand(97, 122)); //使用chr()函式根據ASCII碼產生小寫字母
          break;
      }

      //判斷亂數產生的字元是否已在$gstr字串中，不存在則加入，已存在則重新產生
      if (!mb_strpos($gstr, $t)) {
        $gstr .= $t;
      }
    }
  }
  session_start();
  $_SESSION['cert']=$gstr;
  //建立一個陣列用來儲存每一個字元的圖形資訊
  $text_info = [];

  //建立兩個變數用來計算所有字元的總寬度及最大高度
  $dst_w = 0;
  $dst_h = 0;

  //使用迴圈來逐一分析每個字元的圖形資訊
  for ($i = 0; $i < mb_strlen($gstr); $i++) {

    //使用mb_substr()順序取出每一個字元
    $char = mb_substr($gstr, $i, 1);

    //使用亂數產生一個正負之間的傾斜的角度
    $text_info[$char]['angle'] = rand(-25, 25);

    //使用imagettfbbox()來取得單一字元在大小,角度和字型的影響下，字元圖形的四個角的坐標資訊陣列
    $tmp = imagettfbbox($fontsize, $text_info[$char]['angle'], realpath('./fonts/arial.ttf'), $char);

    //利用字元的資訊，使用x坐標的最大值減最小值來計算出字元寬度，使用y坐標的最大值-最小值來計出字元高度
    //因坐標特性，需要加上1才能得到正確的寬度及高度
    $text_info[$char]['width'] = max($tmp[0], $tmp[2], $tmp[4], $tmp[6]) - min($tmp[0], $tmp[2], $tmp[4], $tmp[6]) + 1;
    $text_info[$char]['height'] = max($tmp[1], $tmp[3], $tmp[5], $tmp[7]) - min($tmp[1], $tmp[3], $tmp[5], $tmp[7]) + 1;

    //累加每個字元的寬度來計算總寬度
    $dst_w += $text_info[$char]['width'];

    //比較每一次字元的高度來決定最大高度
    $dst_h = ($dst_h >= $text_info[$char]['height']) ? $dst_h : $text_info[$char]['height'];

    //根據字型的資訊來取得字元的左上角坐標
    $text_info[$char]['x'] = min($tmp[0], $tmp[2], $tmp[4], $tmp[6]);
    $text_info[$char]['y'] = min($tmp[1], $tmp[3], $tmp[5], $tmp[7]);
  }

  //dd($text_info);
  //exit();

  //建立一個邊框的厚度變數
  $border = 10;

  //使用計算出來的總寬度和最大高度加上邊框厚度來計算驗證碼圖形的完整寬高
  $base_w = $dst_w + ($border * 2);
  $base_h = $dst_h + ($border * 2);

  //根據計算出來的驗證碼圖形完整寬高來建立一個全彩圖形資源
  $dst_img = imagecreatetruecolor($base_w, $base_h);

  //顏色定義區
  $white = imagecolorallocate($dst_img, 255, 255, 255);
  $black = imagecolorallocate($dst_img, 0, 0, 0);
  $blue = imagecolorallocate($dst_img, 0, 0, 255);
  $red = imagecolorallocate($dst_img, 255, 0, 0);
  $green = imagecolorallocate($dst_img, 0, 255, 0);

  //文字顏色陣列
  $colors = [
    imagecolorallocate($dst_img, 255, 127, 80),
    imagecolorallocate($dst_img, 204, 85, 0),
    imagecolorallocate($dst_img, 184, 115, 51),
    imagecolorallocate($dst_img, 204, 119, 34),
    imagecolorallocate($dst_img, 112, 66, 20),
    imagecolorallocate($dst_img, 80, 200, 120),
    imagecolorallocate($dst_img, 222, 49, 99),
    imagecolorallocate($dst_img, 128, 0, 0),
    imagecolorallocate($dst_img, 255, 204, 0),
    imagecolorallocate($dst_img, 128, 128, 0),
    imagecolorallocate($dst_img, 0, 255, 128),
    imagecolorallocate($dst_img, 0, 128, 128),
    imagecolorallocate($dst_img, 0, 0, 128),
    imagecolorallocate($dst_img, 75, 0, 128),
    imagecolorallocate($dst_img, 255, 140, 105),
    imagecolorallocate($dst_img, 218, 112, 214),
    imagecolorallocate($dst_img, 255, 128, 51),
  ];

  //填入底色        
  imagefill($dst_img, 0, 0, $white);

  //建立一個開始繪製文字圖形的起始坐標
  $x_pointer = $border;
  $y_pointer = $border;

  //使用迴圈把驗證碼文字逐一寫入到圖片中
  foreach ($text_info as $char => $info) {

    //計算放置的y坐標範圍，字元的高度加上邊框起始點(5)及總高度-底部坐標終點的限制(5)
    $y = rand($info['height'] + 5, $info['height'] + ($border * 2 - 5 * 2));

    //將字元依照大小，角度，坐標，顏色，字型等資訊畫在畫布上
    imagettftext($dst_img, $fontsize, $info['angle'], $x_pointer, $y, $colors[rand(0, count($colors) - 1)], realpath('./fonts/arial.ttf'), $char);

    //依照字元的寬度及字元的x坐標來產生下一個字元的x坐標起點
    $x_pointer = $x_pointer + $info['width'] + $info['x'] + 1;
  }

  //建立一個線條範圍亂數，決定圖形驗證碼上的干擾線數量
  $lines = rand(3, 6);

  //使用迴圈來產生每一條干擾線
  for ($i = 0; $i < $lines; $i++) {

    //使用亂數來產生起點x坐標，限定範圍為5開始到邊框厚度—5*2之間
    $left_x = rand(5, $border - (5 * 2));

    //使用亂數來產生起點y坐標，限定範圍為5開始到總高度—5之間
    $left_y = rand(5, $base_h - 5);

    //使用亂數來產生終點x坐標，限定範圍為邊框厚度開始到邊框厚度—5*2之間
    $right_x = rand($base_w - $border + 5, $base_w - 5);

    //使用亂數來產生終點y坐標，限定範圍為5開始到總高度—5之間
    $right_y = rand(5, $base_h - 5);

    //根據計算出來的起點和終點坐標來畫出干擾線
    imageline($dst_img, $left_x, $left_y, $right_x, $right_y, $colors[rand(0, count($colors) - 1)]);
  }

  //輸出圖片為jpg檔
  //imagejpeg($dst_img,"cert.jpg",100);
  ob_start(); //開啟緩衝區
  imagepng($dst_img);
  $image_type="data:image/png;base64,";
  $image_data=ob_get_contents();
  //echo base64_encode($dst_img);
ob_end_clean();
  $base_64=base64_encode($image_data);
  //echo $base_64;
  //銷毀圖片資源
  imagedestroy($dst_img);
  ?>
  <div style="width:500px;margin:auto;">
    <h2>加入文字後的圖形<?= $length . "碼"; ?>-<?= $lines . "線"; ?>-<?= $gstr; ?></h2>
    <img src="<?=$image_type;?><?=$base_64;?>" alt="" style="border:2px solid black">
    <input type="text" name="cert" id="cert"><button class='submit-btn'>驗證</button>
  </div>

</body>

</html>

<script>
$(".submit-btn").on("click",function(){
    $.get("cert_code.php",{cert:$("#cert").val()},(ans)=>{
        console.log(ans,$("#cert").val())
        if(parseInt(ans)){
            alert("驗證成功");
        }else{
            alert("失敗");
        }
    })
})
</script>