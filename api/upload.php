<?php
if($_FILES['file_name']['error']==0){
  move_uploaded_file($_FILES['file_name']['tmp_name'],"../upload/".$_FILES['file_name']['name']);
  header('location:../upload.php?upload=success');
}else{
  echo "上傳失敗，請檢察檔案是否正確，或網路是否連線或聯絡網站管理員";
}
?>