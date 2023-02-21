<?php

/**
 * 1.建立資料庫及資料表來儲存檔案資訊
 * 2.建立上傳表單頁面
 * 3.取得檔案資訊並寫入資料表
 * 4.製作檔案管理功能頁面
 */


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>檔案管理功能</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1 class="header">檔案管理練習</h1>
  <!----建立上傳檔案表單及相關的檔案資訊存入資料表機制----->
  <?php

  $handle = opendir('upload');
  $dataset = [];
  while ($file = readdir($handle)) {
    if ($file == '.'  || $file == '..') {
      continue;
    }

    if (is_file('./upload/' . $file)) {
      $sub = explode('.', $file)[1];
      switch ($sub) {
        case "ai":
          $icon = './material/file-ai.png';
          break;
        case "txt":
          $icon = './material/file-txt.png';
          break;
        default:
          $icon = 'img';
      }
      if ($icon != 'img') {
        $dataset[] = ['type' => 'file', 'icon' => $icon, 'filename' => $file];
      } else {
        $dataset[] = ['type' => 'file', 'icon' => './upload/' . $file, 'filename' => $file];
      }
    } else {
      $dataset[] = ['type' => 'dir', 'icon' => './material/directory.png', 'filename' => $file];
    }
  }

  ?>
  <style>
    * {
      box-sizing: border-box;
    }

    .wrapper {
      width: 80%;
      margin: auto;
      max-width: 1400px;
      min-height: 300px;
      border: 3px double #999;
      box-shadow: 1px 1px 3px #ccc;
      display: flex;
      justify-content: center;
      text-align: center;
      flex-wrap: wrap;
      padding: 20px;
    }

    .item {
      width: 100px;
      margin: 1rem;
      box-shadow: 2px 2px 10px #ccc;
      transform: scale(1);
      transition: all 0.5s;
    }

    .item:hover {
      border: 2px solid blue;
      transform: scale(1.15);
      transition: all 0.5s;
    }

    .item img {
      width: 100%;
    }

    .item div:nth-child(2) {
      word-break: break-all;
      height: 45px;
    }
  </style>
  <div class="wrapper">
    <?php
    foreach ($dataset as $item) {
      echo "<div class='item'>";
      echo "<div><img src='{$item['icon']}'></div>";
      echo "<div>{$item['filename']}</div>";
      echo "<div><button>刪除</button></div>";
      echo "</div>";
    }
    ?>
  </div>


  <!----透過資料表來顯示檔案的資訊，並可對檔案執行更新或刪除的工作----->




</body>

</html>