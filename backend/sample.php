<?php  
  error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');

//POST 값을 읽어온다.
#$name=isset($_POST['name']) ? $_POST['name'] : '';
$name=$_POST['name'];
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if ($name !="" ){ 

    $sql="SELECT * FROM sample WHERE name='$name'";
    $result=mysqli_query($con,$sql);
    $data = array();   
    if($result){  
     $row_count = mysqli_num_rows($result);

        if ( 0 == $row_count ){
            
            array_push($data,
                array( 'name'=>'N',
                'country'=>$country)
            );

            if (!$android) {

                echo "'";
                echo $name;
                echo "'은 찾을 수 없습니다.";

                echo "<pre>"; 
                print_r($data); 
                echo '</pre>';
            }else
            {
                header('Content-Type: application/json; charset=utf8');
                $json = json_encode(array("webnautes"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
                echo $json;
            }

        }
        else{

            while($row=mysqli_fetch_array($result)){
                array_push($data, 
                    array(
                    'name'=>$row["name"],
                    'country'=>$row["country"]
                ));
            }



            if (!$android) {
                echo "<pre>"; 
                print_r($data); 
                echo '</pre>';
            }else
            {
                header('Content-Type: application/json; charset=utf8');
                $json = json_encode(array("webnautes"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
                echo $json;
            }
        }


        mysqli_free_result($result);

    }
    else{  
        echo "SQL문 처리중 에러 발생 : "; 
        echo mysqli_error($link);
    }
}
else {
    echo "검색할 나라를 입력하세요 ";
}

 
mysqli_close($link);  

?>



<?php

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

if (!$android){
?>

<html>
   <body>
   
      <form action="<?php $_PHP_SELF ?>" method="POST">
         이름: <input type = "text" name = "name" />
         <input type = "submit" />
      </form>
   
   </body>
</html>
<?php
}

   
?>