<?php
include "config.php";

$input=file_get_contents("php://input");
$decode=json_decode($input,true);

$id=$decode['id'];
$name=$decode['name'];
$age=$decode['age'];
$country=$decode['country'];


$sql="UPDATE users SET user_name='{$name}', user_age='{$age}', user_country='{$country}' WHERE id='{$id}'";
$run_sql=mysqli_query($conn,$sql);

if($run_sql){
    echo json_encode(["success"=>true,"message"=>"USUARIO ACTUALIZADO CON EXITO"]);
}else{
    echo json_encode(["success"=>false,"message"=>"PROBLEMA DEL SERVIDOR"]);
}

?>