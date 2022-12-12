<?php
include_once "base.php";

if($_FILES['file_name']['error']==0){
  $file_str_array=explode(".",$_FILES['file_name']['name']);
  $sub=array_pop($file_str_array);
  $file_name=date("Ymdhis").".".$sub;

  // move_uploaded_file($_FILES['file_name']['tmp_name'],"../upload/".$_FILES['file_name']['name']);
  move_uploaded_file($_FILES['file_name']['tmp_name'],"../upload/".$file_name);
  insert('upload',['description'=>$_POST['description'],
                    'size'=>$_FILES['file_name']['size'],
                    'type'=>$_FILES['file_name']['type'],
                    'file_name'=>$file_name]);
  // $description=$_POST['description'];
  // echo $description;
  // echo "<BR>";
  // echo $file_name;
  // echo "<BR>";
  // echo $_FILES['file_name']['size']." Byte";
  // echo "<BR>";
  // echo $_FILES['file_name']['type'];
  // echo "<BR>";
  header('location:../upload.php?upload=success');
}else{
  echo "上傳失敗，請檢察檔案是否正確，或網路是否連線或聯絡網站管理員";
}
?>