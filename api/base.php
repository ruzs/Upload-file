<?php
$dsn="mysql:host=localhost;charset=utf8;dbname=file";
$pdo=new PDO($dsn,'root','');

date_default_timezone_set("Asia/Taipei");

session_start();

function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

/**
 * pram table - 資料表名稱
 * pram args[0] - where 條件(array)或sql字串
 * pram args[1] - order by limit 之類的sql 字串
 */

function all($table,...$args){
    global $pdo;
    $sql="select * from $table ";

    if(isset($args[0])){
        if(is_array($args[0])){
            //是陣列 ['acc'=>'mack','pw'=>'1234'];
            //是陣列 ['product'=>'PC','price'=>'10000'];

            foreach($args[0] as $key => $value){
                $tmp[]="`$key`='$value'";
            }

            $sql=$sql ." WHERE ". join(" && " ,$tmp);
        }else{
            //是字串
            $sql=$sql . $args[0];
        }
    }

    if(isset($args[1])){
        $sql = $sql . $args[1];
    }

    //echo $sql;
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

}


//傳回指定id的資料
                    //['acc'=>'mack','pw'=>1234];
                    // 1,200,312
function find($table,$id){
    global $pdo;
    $sql="select * from `$table` ";

    if(is_array($id)){
        foreach($id as $key => $value){
            $tmp[]="`$key`='$value'";
        }

        $sql = $sql . " where " . join(" && ",$tmp);

    }else{

        $sql=$sql . " where `id`='$id'";
    }
    //echo $sql;
    return $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
}

//給定條件更新資料(多筆或單筆)
function update($table,$col,...$args){
    global $pdo;

    $sql="update $table set ";

    if(is_array($col)){
        foreach($col as $key => $value){
            $tmp[]="`$key`='$value'";
        }

        $sql = $sql .  join(",",$tmp);

    }else{
        echo "錯誤,請提供以陣列型式的更新資料";
    }

    if(isset($args[0])){
        if(is_array($args[0])){
            $tmp=[];
            foreach($args[0] as $key => $value){
                $tmp[]="`$key`='$value'";
            }

            $sql = $sql . " where " . join(" && ",$tmp);

        }else{

            $sql=$sql . " where `id`='{$args[0]}'";
        }
    }


    echo $sql;
    //$t=$pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    //$t=$pdo->exec($sql);

    return $pdo->exec($sql);
}


//新增資料
/**
 * `['school_num'=>'911799',
 *  'class_code'=>'101',
 *  'seat_num'=>51,
 *  'year'=>2000]`
 */
function insert($table,$cols){
    global $pdo;

    $keys=array_keys($cols);
    //dd(join("','",$cols));

    $sql="insert into $table (`" . join("`,`",$keys) . "`) values('" . join("','",$cols) . "')";
    //$sql="insert into $table (`";
    //$sql=$sql . join("`,`",$keys);
    //$sql=$sql . "`) values('";
    //$sql=$sql . join("','",$cols);
    //$sql=$sql . "')";

    //echo $sql;
    return $pdo->exec($sql);
}

//刪除資料
function del($table,$id){
    global $pdo;
    $sql="delete from `$table` ";

    if(is_array($id)){
        foreach($id as $key => $value){
            $tmp[]="`$key`='$value'";
        }

        $sql = $sql . " where " . join(" && ",$tmp);

    }else{

        $sql=$sql . " where `id`='$id'";
    }

    //echo $sql;
    return $pdo->exec($sql);
}

//萬用sql函式
function q($sql){
    global $pdo;
    //echo $sql;
    return $pdo->query($sql)->fetchAll();
}

//header函式
function to($location){
    header("location:$location");
}

function is_image($type){
    switch($type){
        case "image/jpeg":
        case "image/gif":
        case "image/png":
            return true;
        break;
        default:
            return false;
    }
}

function dummy_icon($type){
    switch($type){
        case "text/plain":
            return "file-txt.png";
        break;
        case "application/mspowerpoint":
        case "application/vnd.openxmlformats-officedocument.presentationml.pre":
            return "file-ppt.png";
        break;
        case "application/msword":
            return "file-doc.png";
        break;
        case "application/postscript":
            return "file-ai.png";
        break;
        default:
            return "file-regular.jpg";
    }
}
?>