<?php
include "config.php";

$id=$_GET["id"];
$sql="DELETE  FROM users WHERE id='{$id}'";
$run_sql=mysqli_query($conn,$sql);
if($run_sql){
    echo json_encode(["success"=>true,"message"=>"USUARIO ELIMINADO CON EXITO"]);
}else{
    echo json_encode(["success"=>false,"message"=>"PROBLEMA DEL SERVIDOR"]);
}


?>