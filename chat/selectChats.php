<?php

include('../php/verifica_login.php');

header('Access-Control-Allow-Origin: *');

include("../php/conexao.php");

if(isset($_POST["idUsuario"])){
    $idUsuario = $_POST["idUsuario"];
    
    $sql = "SELECT r.idRegistro, r.idChat, r.idUsuario, u.usuario, u.foto, r.data, u.ativo
    FROM registrochatmensagem r 
    INNER JOIN usuarios u ON r.idUsuario = u.usuario_id
    WHERE r.idChat IN (SELECT idChat FROM registrochatmensagem WHERE idUsuario = ?) AND u.usuario_id != ?
    GROUP BY r.idChat";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idUsuario, $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "<a class = 'contato' idUsuario='".$row["idUsuario"]."' nome = '".$row["usuario"]."'' idChat = '".$row["idChat"]."'>
             <img  src= 'data:image/jpeg;base64,".base64_encode($row['foto'])."'>
             <p href='#'>".$row["usuario"]."<span></span></p>";

            if($row['ativo'] == 1){
                echo "<i class='fas fa-circle' style='color:#128043'></i></a>";
            }else{
                echo "<i class='fas fa-circle' style='color:#801212'></i></a>";
            }
            
        } 
    }else{
        echo "<div class = 'semChat'>Faça simulados e encontre pessoas para tirar dúvidas <img src='imgs_inicial/converse.svg' alt='converse' /></div>";
    }
    $conn->close();
}

?>