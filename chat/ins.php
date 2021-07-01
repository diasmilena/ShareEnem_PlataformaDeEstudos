<?php

include('../php/verifica_login.php');

header('Access-Control-Allow-Origin: *');

include("../php/conexao.php");

if(isset($_POST["chat"])){
    $sql = "INSERT INTO `chats` (`idChat`) VALUES (NULL)";

    $stmt = $conn->prepare($sql);

    if($stmt->execute()){
        echo $stmt->insert_id;

    }else{
        echo "Tabela chats error ao inserir".$conn->error;    
    }

}else if(isset($_POST["primeiroRegistroChatMsg"])){

    $idChat = $_POST["idChat"];
    $idUsuCriou = $_POST["idUsuCriou"];
    $idUsuOutro = $_POST["idUsuOutro"];
    $idMsg =  $_POST["idMsg"];

    $sql = "INSERT INTO `registrochatmensagem`(`idUsuario`, `idChat`, `idMensagem`, `data`) VALUES (?, ?, ?, NOW());";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $idUsuCriou, $idChat, $idMsg);

    if($stmt->execute()){
        $sql = "INSERT INTO `registrochatmensagem`(`idUsuario`, `idChat`, `idMensagem`, `data`) VALUES (?, ?, null, NOW());";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $idUsuOutro, $idChat);

        if($stmt->execute()){

            echo "novo registro de chat feito";

        }else{
            echo "Tabela registros chats error ao inserir registro 1".$conn->error;    
        }

    }else{
        echo "Tabela registros chats error ao inserir registro 2".$conn->error;    
    }
    $conn->close();

}else if(isset($_POST["msg"])){
    $txtMsg = $_POST["msg"];

    $sql = "INSERT INTO `mensagens`(`txtMensagem`) VALUES (?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $txtMsg);

    if($stmt->execute()){
        echo $stmt->insert_id;

    }else{
        echo "Tabela mensagens error ao inserir".$conn->error;    
    }
    $conn->close();
    
}else{

    $idUsuario = $_POST["idUsuario"];
    $idChat = $_POST["idChat"];
    $idMsg = $_POST["idMsg"];

    $sql = "INSERT INTO `registrochatmensagem`(`idUsuario`, `idChat`, `idMensagem`, `data`, `visto`) VALUES (?, ?, ?, NOW(), 0)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $idUsuario, $idChat, $idMsg);

    if($stmt->execute()){
        echo "novo registro de chat mensagem feito";

    }else{
        echo "Tabela registros chats error ao inserir registro".$conn->error;    
    }    
}

?>
