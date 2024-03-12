<?php

header('Content-type:text/html;charset=utf-8');

$link=@mysqli_connect('localhost','root','0213','',3306);

mysqli_set_charset($link,'utf8');

mysqli_select_db($link,"fly_bird");

// echo $_POST["mode"];

if ($_POST["mode"] == "read") {
    //读取排名模式
    $query = 'select * from score order by score DESC limit 10';
    $result = mysqli_query($link,$query);

    $tmp = [];
    for($i=0;$i<mysqli_num_rows($result);$i++){
        $tmp[$i] = mysqli_fetch_assoc($result);
    }

    echo json_encode($tmp);
} else if ($_POST["mode"] == "up") {
    //上传成绩模式
    // echo $_POST["player"].$_POST["score"];
    if($_POST["player"] == ""){
        exit("上传失败，用户名为空");
    } else {
        // echo $_SERVER["REMOTE_ADDR"];
        $query2 = "select * from score where addr='".$_SERVER["REMOTE_ADDR"]."'";
        $result2 = mysqli_query($link,$query2);
        
        if(mysqli_num_rows($result2) >= 1){
            // echo "用户ip已存在";
            // $query3 = "update score set name='bbb',score='33' where addr='114.114.114.114'";
            $query3 = "update score set name='".$_POST["player"]."',score='".$_POST["score"]."' where addr='".$_SERVER["REMOTE_ADDR"]."'";
            if(mysqli_query($link,$query3) != null){
                echo "修改成绩成功";
            }else {
                echo "修改成绩失败";
            }
        } else {
            // echo "用户ip不存在";
            //$query3 = "insert into score(name,score,addr) values('aaa','11','114.114.114.114')";
            $query3 = "insert into score(name,score,addr) values('".$_POST["player"]."','".$_POST["score"]."','".$_SERVER["REMOTE_ADDR"]."')";
            if(mysqli_query($link,$query3) != null){
                echo "新增成绩成功";
            }else {
                echo "新增成绩失败";
            }
        }
    }
}


mysqli_close($link);