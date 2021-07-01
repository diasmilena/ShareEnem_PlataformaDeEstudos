<?php

include('../php/verifica_login.php');

header('Access-Control-Allow-Origin: *');

include("../php/conexao.php");

if(isset($_POST["idUsuario"])){
    $idUsuario = $_POST["idUsuario"];
    
    $sql = "SELECT `connectionID` FROM `usuarios` WHERE `usuario_id` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo $row['connectionID'];
        } 
    }
    $conn->close();
}
?>
