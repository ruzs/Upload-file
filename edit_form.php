<?php
include_once "./api/base.php";

$file=find('upload',$_GET['id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>檔案上傳</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .list{
            list-style-type:none;
            padding: 0;
            margin:1rem auto;
            padding-top:1px;
            width:80%;

        }
        .list-item{
            display: flex;
            align-items: center;
            border: 1px solid #aaa;
            margin-top:-1px ;
        }
        .list-item:nth-child(1){
            text-align: center;
            background-color: lightgreen;
        }
        .list-item div:nth-child(1){
            width:20%;
        }
        .list-item div:nth-child(1) img{
            width:150px;
            height:100px;
        }
        .list-item div:nth-child(2){
            width:20%;
        }
        .list-item div:nth-child(3){
            width:20%;
        }
        .list-item div:nth-child(4){
            width:10%;
        }
        .list-item div:nth-child(5){
            width:20%;
            overflow: hidden;
        }
        .list-item div:nth-child(6){
            width:10%;
            overflow: hidden;
        }
    </style>
</head>
<body>

<h2>編輯檔案</h2>
<form action="./api/edit.php" method="post" enctype="multipart/form-data">
    <ul>
        <li>描述：<input type="text" name="description" value="<?=$file['description'];?>"></li>
        <li>類型：<?=$file['type'];?></li>
        <li>大小：<?=$file['size'];?>bytes</li>
        <li>
        <?php
            if(is_image($file['type'])){
                echo "<img src='./upload/{$file['file_name']}' style='width:150px'>";
            }else{
                $icon=dummy_icon($file['type']);
                echo "<img src='./material/{$icon}' style='width:80px'>";
            }
        ?>
        </li>
        <li>檔案：<input type="file" name="file_name"></li>
        <input type="hidden" name="id" value="<?=$file['id'];?>">
        <li><input type="submit" value="修改"></li>
    </ul>
</form>
</body>
</html>