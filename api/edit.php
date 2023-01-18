<?php
  include_once "base.php";
  $file=find("upload",$_POST['id']);

  if($_FILES['file_name']['error']==0){
    $file_str_array=explode(".",$_FILES['file_name']['name']);
    $sub=array_pop($file_str_array);
    $file_name_array=explode(".",$file['file_name']);
    $file_name=array_shift($file_name_array).".".$sub;
    echo $sub;
    echo $file_name;    
    // move_uploaded_file($_FILES['file_name']['tmp_name'],"../upload/".$_FILES['file_name']['name']);
    if($file['file_name']!==$file_name){
      unlink("../upload/".$file['file_name']);   //刪除舊的檔案
    }
    move_uploaded_file($_FILES['file_name']['tmp_name'],"../upload/".$file_name);
    update('upload',['description'=>$_POST['description'],
                      'file_name'=>$file_name,
                      'size'=>$_FILES['file_name']['size'],
                      'type'=>$_FILES['file_name']['type'],
                      ],$_POST['id']);                
  }else{
    update('upload',['description'=>$_POST['description']],$_POST['id']);
  }
  header('location:../upload.php?edit=success');
?>