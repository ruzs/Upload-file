<?php
include_once "base.php";

$description=$_POST['description'];
$file_name=$_POST['file_name'];
$img_name=$_POST['img_name'];
$image=explode(",",$file_name);
/* $file_type=str_replace(['data:',';base64'],'',$image[0]);
echo $file_type;
switch($file_type){
    case 'image/png':
        $sub=".png";
    break;
    case 'image/jpeg':
        $sub=".jpg";
    break;
    case 'image/gif':
        $sub=".gif";
    break;
    case 'image/bmp':
            $sub=".bmp";
    break;
}
$file= */
//echo $img_name;
$file=fopen('../upload/'.$img_name,'w+');
fwrite($file,base64_decode($image[1]));
fclose($file);

insert('upload',['description'=>$_POST['description'],
                 'size'=>$_POST['img_size'],
                 'type'=>$_POST['img_type'],
                 'file_name'=>$img_name]);
$id=q("SELECT max(`id`) as 'id' from `upload`")[0]['id'];
?>
<li class='list-item'>
    <div><img src='./upload/<?=$img_name;?>'></div>
    <div><?=$_POST['description'];?></div>
    <div><?=$_POST['img_name'];?></div>
    <div><?=floor($_POST['img_size']/1024)?>KB</div>
    <div><?=$_POST['img_type'];?></div>
    <div>
    <a href='edit_form.php?id=<?=$id;?>'>編輯</a>
    <a href='./api/del.php?id=<?=$id;?>'>刪除</a>
    </div>
</li>