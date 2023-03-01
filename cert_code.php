<?php
session_start();

if($_GET['cert']==$_SESSION['cert']){
    echo 1;
}else{
    echo 0;
}