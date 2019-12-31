<?php  
  error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');
 

//POST 값을 읽어온다.
$country=isset($_POST['name']) ? $_POST['name'] : '';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if ($name !="" ){ 

    $sql="select * from sample where name='$name'";

    $result=mysqli_query($con,$sql);
    $data = array();   
    if($result){  
    while($row=mysqli_fetch_array($result)){
        array_push($data, 
            array(
            'name'=>$row[0],
            'country'=>$row[1]
        ));
    }
header('Content-Type: application/json; charset=utf8');
$json = json_encode(array("webnautes"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
echo $json;
}
else{  
    echo "SQL문 처리중 에러 발생 : "; 
    echo mysqli_error($link);
} 

?>