<?php

include('../php/verifica_login.php');

header('Access-Control-Allow-Origin: *');

include("../php/conexao.php");

if(isset($_POST["idChat"])){
    $idChat = $_POST["idChat"];
    
    $sql = "SELECT m.txtMensagem, r.data, r.visto, r.idUsuario
    FROM registrochatmensagem r
    INNER JOIN mensagens m ON r.idMensagem = m.idMensagem
    WHERE `idChat` = ?
    ORDER BY r.data DESC 
    LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idChat);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo $row["txtMensagem"]."|". $row["visto"] ."|". $row["idUsuario"];
        } 
    }
    $conn->close();
}

?>