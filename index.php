<?php
// print_r(traverseDir('./upload'));
$prin = traverseDir('./images');
 
 
$num = count($prin);
 
    
 
/**
 * 遍历指定路径的文件夹中的文件
 * @param $dirPath 文件绝对路径
 * @param $type 遍历方法 默认参数为 $type='all' 返回所有文件作为一维数组返回,如果$type='file'，则与多维数组返回
 * @return array 检索到文件成功返回内部文件路径数组，失败返回false;
 */
function traverseDir($dirPath=false,$type='all'){
    //检测是否为文件夹
    if(!$dirPath||!is_dir($dirPath)){
        return false;
    }
    $files = array();
 
    //增加一个@抑制错误
    if(@$handle = opendir($dirPath)){
       while(($file=readdir($handle))!==false){
           //排除'.'当前目录和'..'上级目录
           if($file != '..' && $file != '.'){
               //只记录文件
               if($type == 'file'){
                   if(is_dir($dirPath.DIRECTORY_SEPARATOR.$file)){
                       //如果是文件夹，则重新遍历该文件的文件
                       $files[$file] = traverseDir($dirPath.DIRECTORY_SEPARATOR.$file,'file');
                       //把文件存入数组中
                        foreach($files[$file] as $k => $v){
                            if(is_file($v)){
                                $files[] = $v;
                                //删除源数组中的对应文件路径
                                unset($files[$file][$k]);
                            }
                        }
 
                       //删除源数组中的对应文件路径数组
                       unset($files[$file]);
                   }else{
                       //如果是文件则直接存入数组
                       $files[] = $dirPath.DIRECTORY_SEPARATOR.$file;
                   }
               }else{//记录含文件
                    if(is_dir($dirPath.DIRECTORY_SEPARATOR.$file)){
                        //如果是文件夹，则重新遍历该文件的文件
                        $files[$file] = traverseDir($dirPath.DIRECTORY_SEPARATOR.$file);
                    }else{
                        //如果是文件则直接存入数组
                        $files[] = $dirPath.DIRECTORY_SEPARATOR.$file;
                    }
               }
           }
       }
		closedir($handle);
    }
    return $files;
}
 
echo '
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>beink</title>
    <link rel="shortcut icon " type="images/x-icon" href="https://beink.cn/4.png">
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        html,body{
            perspective: 800px;
        }
        body{
            background-color: rgba(255, 255, 255, 0.582);
        }
        .all{
            position: relative;
            width: 1000px;
            height: 800px;
            background-color: gray;
            box-shadow: 0 0 10px ;
            border-radius: 20px;
            margin: 50px auto;
        }
        li{
            list-style: none;
        }
        form{
            height: 200px;
            text-align: center;
        }
        input[type="submit"] {
            border: none;
            width: 120px;
            height: 50px;
            background-color: #00a1d6;
            border-radius: 10px;
            transition: .3s;
            color: white;
            
        }
        input[type="submit"]:hover{
            box-shadow: 0 0 10px #03befc;
            font-size: 20px;
            letter-spacing: 3px;
        }
        input[type="file"]{
            font-size: 25px;
            background-color: rgb(98, 98, 230);
            border-radius: 10px;
            transition: .3s;
            
        }
        input[type="file"]:hover{
            background-color: rgb(131, 131, 255);
            letter-spacing:1px;
            color: rgba(56, 54, 54, 0.575);
        }
        lable{
            font-size: 20px;
        }
        ul{
            position: relative;
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
        }
        li{
            margin-top:50px;
        }
        a{
            width: 190px;
            height: 80px;
            text-align: center;
            line-height:80px;
            display: block;
            text-decoration: none;
            color: orange;
            transition: .3s;
            border-radius: 10px;
            overflow:hidden;
        }
        a:hover{
            font-size: 20px ;
            background-color: rgb(107, 93, 93);
            
        }
        .fre{
            background-color: rgb(114, 106, 106);
            width: 100%;
            height: 600px;
            border-radius: 20px;
        }
        img{
            height:100px;
            transition:.3s;
            filter:blur(0.5px);
        }
        img:hover{
            transform:scale(1.5);
            filter:blur(0px);
            
        }
        
    </style>
</head>
<body>
    <div class="all">
        <form action="form.php" method="post" onsubmit="return checkinput();" enctype="multipart/form-data">
            <br><br><br><input type="file" name="file" id="file"><br><br><br>
            <input type="submit" class="submit"  onclick="validate()" name="submit" value="上  传">
        </form>
            <script>
                var a = true;
                function validate(){
                    var file = document.getElementById("file").value;
                    if(file==""){
                        const int = document.querySelector(".submit");
                        int.style.backgroundColor="red";
                        int.style.fontSize = "25px";
                        int.value = "失  败"
                        function move(){
                            int.style.backgroundColor="#00a1d6";
                            int.value = "上  传"
                            int.style.fontSize = "16px";
                        }
                        setTimeout(move,2000);
                        a=false;
                        return;
                    }else{
                        a=true;
                    }
                }
                function checkinput(){
                    return a;
                }
            </script>
        <div class="fre">';
        for($i=0;$i<$num;++$i){
            if($i%5==0){
                echo '</ul><ul>';
            }
            $name = substr($prin[$i],9);
            if(strpos($name,'.png')!== false || strpos($name,'.jpg')!== false){
                echo  '<li><img src=" '.$prin[$i].' "></li>';
            }
            else{
                echo  '<li><a href="'.$prin[$i].'">'.$name.'</a></li>';
            }
            
        }
 
        echo '</div>
    </div>
</body>
</html>
';
 
    if($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST["file"]) !== false){
        $allowedExts = array("gif", "jpeg", "jpg", "png","zip","rar","tar",'tgz',"txt","xml","html","css","js");
        $temp = explode(".", $_FILES["file"]["name"]);
        // echo $_FILES["file"]["size"];
        $extension = end($temp);     // 获取文件后缀名
        if ((($_FILES["file"]["type"] == "image/gif")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/jpg")
        || ($_FILES["file"]["type"] == "image/pjpeg")
        || ($_FILES["file"]["type"] == "image/x-png")
        || ($_FILES["file"]["type"] == "image/png")
        || ($_FILES["file"]["type"] == "application/octet-stream")
        || ($_FILES["file"]["type"] == "application/x-tar")
        || ($_FILES["file"]["type"] == "application/x-compressed")
        || ($_FILES["file"]["type"] == "application/x-zip-compressed")
        || ($_FILES["file"]["type"] == "text/plain")
        || ($_FILES["file"]["type"] == "text/xml")
        || ($_FILES["file"]["type"] == "text/html")
        || ($_FILES["file"]["type"] == "text/css")
        || ($_FILES["file"]["type"] == "text/javascript")
        )
        && ($_FILES["file"]["size"] < 20480000)   
        && in_array($extension, $allowedExts)){
        	if ($_FILES["file"]["error"] > 0){
        		echo "错误：: " . $_FILES["file"]["error"] . "<br>";
        	}
        	else{
        	    echo '
                <script>
                    const int = document.querySelector(".submit");
                    int.style.backgroundColor="gold";
                    int.style.fontSize = "25px";
                    int.value = "成  功"
                    function move(){
                        location = "原来的网址";
                    }
                    setTimeout(move,2000);
                </script>
            ';
        		move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
        	}
        }
        else{
            echo '
                <script>
                    const int = document.querySelector(".submit");
                    int.style.backgroundColor="red";
                    int.style.fontSize = "25px";
                    int.value = "失  败"
                    function move(){
                        location = "原来的网址";
                    }
                    setTimeout(move,1000);
                </script>
            ';
        }
    }
 
 
?>
