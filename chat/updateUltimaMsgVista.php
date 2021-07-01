<?php

include('../php/verifica_login.php');

header('Access-Control-Allow-Origin: *');

include("../php/conexao.php");

if(isset($_POST["idUsuOutro"])){
    $idUsuOutro = $_POST["idUsuOutro"];
    
    $sql = "UPDATE `registrochatmensagem` SET `visto`= 1 WHERE `idUsuario` =  ? AND `visto` = 0";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",  $idUsuOutro);
    if($stmt->execute()){
        echo "mensagens lidas";

    }else{
        echo "Tabela registrochatmensagem error ao dar update nas mensagens vistas".$conn->error;    
    }
    $conn->close();
}
?>