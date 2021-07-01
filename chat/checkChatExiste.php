<?php

include('../php/verifica_login.php');

header('Access-Control-Allow-Origin: *');

include("../php/conexao.php");

if(isset($_POST["idUsuario"])){
    $idUsuario = $_POST["idUsuario"];
    $idUsuOutro = $_POST["idUsuOutro"];
    $chatsExistentes = " ";
    
    $sql = "SELECT u.usuario_id
    FROM registrochatmensagem r 
    INNER JOIN usuarios u
    ON r.idUsuario = u.usuario_id
    WHERE r.idChat IN (SELECT idChat FROM registrochatmensagem WHERE idUsuario = ?) AND u.usuario_id != ?
    GROUP BY r.idChat";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idUsuOutro, $idUsuOutro);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if($row["usuario_id"] == $idUsuario){
                echo "1";
            }
        }
        
    }
    $conn->close();
}
?>