<?php
include('verifica_login.php');

header('Access-Control-Allow-Origin: *');


if(isset($_POST["idSimulado"])){
    $idSimulado = $_POST["idSimulado"];
    $sigla = $_POST["sigla"]; 
   
    $_SESSION['simuladoAtual'] = $idSimulado;
    $_SESSION['sigla'] = $sigla;
}
?>