<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "crudphp";
$port = 3306;

try{

    $conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user, $pass);

    //echo "<script>console.log('Conexão com o BD realizado com sucesso!')</script>";

}catch(PDOException $err){

    //echo "<script>console.log('ERRO!! Conexão com o BD não foi realizada com sucesso!')</script>";
   
    //echo "\nErro". $err->getMessage();
}