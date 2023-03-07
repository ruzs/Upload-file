<?php
/**
 * 1.建立表單
 * 2.建立處理檔案程式
 * 3.搬移檔案
 * 4.顯示檔案列表
 */
include_once "./api/base.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>檔案上傳</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <style>
        .list{
            text-align: center;
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
        .list-item div:nth-child(1){
            width:30%;
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
 <h1 class="header">檔案上傳練習</h1>
 <!----建立你的表單及設定編碼----->

<form action="./api/upload.php" method="post" enctype="multipart/form-data" style="text-align:center">
<?php
if(isset($_GET['upload']) && $_GET['upload']=='success')
echo "<div style='color:green'>上傳成功</div>";
?>
    <ul>
        <li>描述:<input type="text" name="description" id="description"></li>
        <li>檔案:<input type="file" name="file_name" id="upload"style="padding:10px" ></li>
        <!-- <li><input type="submit" value="上傳"style="padding:10px"></li> -->
        <li><input type="button" value="上傳" id="uploadBtn"style="padding:10px"></li>
        <img src=""id="preview" alt="">
    </ul>
</form>
<script>
    let e=10;
    $("input[type='file']").on("change",function (e) {
        console.log(e);
        let file=e.target.files[0]
        console.log(file)
    let reader=new FileReader();
    let b64=reader.readAsDataURL(file)
    reader.onload=()=>{
        base64Image=reader.result;
        $("#preview").attr('src',base64Image)

    }
})

$("#uploadBtn").on('click',function(e){
    let form=new FormData();
/*     console.log($("input[type='file']").prop('files')) */
    let img=$("input[type='file']").prop('files');
    let img_name=img[0].name;
    let reader=new FileReader();
    let b64=reader.readAsDataURL(img[0])
    reader.onload=()=>{
        base64Image=reader.result;
//        console.log('ba64',base64Image);
        $.post("./api/upload2.php",
                {'description':$("#description").val(),
                 "file_name":base64Image,
                 'img_name':img_name,
                 'img_type':img[0].type,
                 'img_size':img[0].size
                },
                 (res)=>{
                    console.log(res)
                    $(".list").append(res)
                    //location.reload()
                })
    }


/*     form.append('description',$("#description").val())
    form.append('file_name',img)
    $.ajax({
        url:'./api/upload.php',
        type:'POST',
        data:form,
        contentType:false,
        processData:false,
        mimeType:"multipart/form-data",
        success:()=>{
            location.reload()
        }
    }) */
    })
</script>
<!----建立一個連結來查看上傳後的圖檔---->  
<?php
$files=all('upload');
if(count($files)>0){
echo "<ul class='list'>";
echo "<li class='list-item'>";
echo "<div>縮圖</div>";
echo "<div>描述</div>";
echo "<div>檔名</div>";
echo "<div>大小</div>";
echo "<div>類型</div>";
echo "<div>操作</div>";
echo "</li>";
    foreach($files as $file){
        echo "<li class='list-item'>";
            echo "<div>";
            if(is_image($file['type'])){
                echo "<img src='./upload/{$file['file_name']}'>";
            }else{
                $icon=dummy_icon($file['type']);
                echo "<img src='./material/{$icon}' style='width:80px'>";
            }
            echo "</div>";
            echo "<div>";
            echo $file['description'];
            echo "</div>";
            echo "<div>";
            echo $file['file_name'];
            echo "</div>";
            echo "<div>";
            echo floor($file['size']/1024) . 'KB';
            echo "</div>";
            echo "<div>";
            echo $file['type'];
            echo "</div>";
            echo "<div>";
            echo "<a href='edit_form.php?id={$file['id']}'>編輯</a>";
            echo "<a href='./api/del.php?id={$file['id']}'>刪除</a>";
            echo "</div>";
            echo "</div>";
        echo "</li>";
    }
echo "</ul>";
}else{
    echo "目前尚無上傳資料";
}

?>
</body>
</html>