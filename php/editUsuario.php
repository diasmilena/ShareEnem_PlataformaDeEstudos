<?php
include('verifica_login.php');

header('Access-Control-Allow-Origin: *');

include("conexao.php");


if(isset($_POST["idUsuario"])){

    $txtNomeUsuario = $_POST["txtNomeUsuario"];
    $txtNomeCompleto = $_POST["txtNomeCompleto"];
    $txtDescricao = $_POST["txtDescricao"];
    $txtFoto = file_get_contents($_POST['txtFoto']);
    $idUsuario  = $_POST["idUsuario"];

    $sql = "UPDATE `usuarios` SET `usuario`= ?,`nomecompleto`= ?, `descricaoperfil`= ?, `foto`= ? WHERE `usuario_id` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $txtNomeUsuario, $txtNomeCompleto, $txtDescricao, $txtFoto, $idUsuario);

    if($stmt->execute()){
        echo "update info usuário feito com sucesso";

         unset($_SESSION['foto']);

         $_SESSION['foto'] = $txtFoto;

    }else{
        echo "Tabela usuario erro no update".$conn->error;    
    }
    $conn->close();
}
?>