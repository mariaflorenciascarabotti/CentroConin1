<?php
$host= "localhost";
$user= "root";
$password= "";
$dp= "conin_cdg";

$conn = @mysqli_connect($host,$user,$password,$dp);

if(!$conn){
    echo "Error en la conexión";
}else{
    
}


?>