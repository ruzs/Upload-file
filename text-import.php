<?php
include_once "./api/base.php";
/****
 * 1.建立資料庫及資料表
 * 2.建立上傳檔案機制
 * 3.取得檔案資源
 * 4.取得檔案內容
 * 5.建立SQL語法
 * 6.寫入資料庫
 * 7.結束檔案
 */

if (!empty($_FILES['doc']['tmp_name'])) {
  //move_uploaded_file($_FILES['doc']['tmp_name'], './upload/'.$_FILES['doc']['name']);
  $file=$_FILES['doc']['tmp_name'];

  $resource = fopen($file, 'r');
  $line = fgets($resource);
  while ($line = fgets($resource)) {
    $cols = explode(",", $line);
    $cols[2] = trim(trim($cols[2]), "'");
    $cols[3] = trim(trim($cols[3]), "'");
    $cols[4] = trim(trim($cols[4]), "'");
    insert('students', [
      'name' => $cols[2],
      'no' => $cols[4],
      'birthday' => $cols[3]
    ]);
  }
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
  <h1 class="header">文字檔案匯入練習</h1>
  <form action="?" method='post' enctype="multipart/form-data">
    <input type="file" name="doc" id="doc">
    <input type="submit" value="上傳">
  </form>
  <!----讀出匯入完成的資料----->
  <?php
  $rows = all('students');
  foreach ($rows as $row) {
    echo $row['name'] . "-" . $row['no'] . "-" . $row['birthday'];
    echo "<br>";
  }

  ?>

  <!--匯出資料-->
  <?php
  if (file_exists('export.csv')) {
    unlink('export.csv');
  } else {
    $file = fopen('export.csv', 'w+');
    $rows = all('students', " limit 15");
    fwrite($file, "\xEF\xBB\xBF");
    // \xEF\xBB\xBF microsoft系列檔案開頭必加BOM
    foreach ($rows as $row) {
      $str = join(",", $row);
      fwrite($file, $str);
      fwrite($file, "\r\n");
    }
    fclose($file);
  }
  ?>
  <a href='export.csv' download>檔案下載</a>
</body>

</html>