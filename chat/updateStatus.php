<?php

include('../php/verifica_login.php');

header('Access-Control-Allow-Origin: *');

include("../php/conexao.php");

if(isset($_POST["idConexao"])){
    $idConexao = $_POST["idConexao"];
    
    $sql = "SELECT `usuario_id` FROM `usuarios` WHERE `connectionID` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",  $idConexao);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $sql = "UPDATE `usuarios` SET `ativo`= 0 WHERE `usuario_id` = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $row["usuario_id"]);
    
            if($stmt->execute()){
                    echo $row["usuario_id"];
    
            }else{
                echo "Erro no update da conexão";
            }
        } 
    }
    $conn->close();
}
?>
