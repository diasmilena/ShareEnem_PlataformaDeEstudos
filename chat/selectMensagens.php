<?php

include('../php/verifica_login.php');

header('Access-Control-Allow-Origin: *');

include("../php/conexao.php");

if(isset($_POST["idChat"])){
    $idChat = $_POST["idChat"];
    $idUsuario = $_POST["idUsuario"];
    
    $sql = "SELECT r.idChat, m.idMensagem, m.txtMensagem, r.data, r.idUsuario
    FROM registrochatmensagem r 
    INNER JOIN mensagens m
    ON r.idMensagem = m.idMensagem
    WHERE r.idChat = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idChat);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){

            if($idUsuario == $row["idUsuario"]){
                echo "<div class='msg' style ='align-self:flex-end' ><p style='background-color:#725bb0' title = '".$row["data"]."'>".$row["txtMensagem"]."</p></div>";
            }else{
                echo "<div class='msg' style ='align-self:flex-start' ><p style='background-color:#358f8e' title = '".$row["data"]."'>".$row["txtMensagem"]."</p></div>";
            }
            
        } 
    }
    $conn->close();
}
?>