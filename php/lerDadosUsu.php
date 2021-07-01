<?php
include('verifica_login.php');

header('Access-Control-Allow-Origin: *');

include("conexao.php");

if(isset($_POST["idUsuario"])){
    $idUsuario = $_POST["idUsuario"];
    $info = "";
    
    $sql = "SELECT * FROM usuarios WHERE usuarios.usuario_id = ?";

    $statement = $conn->prepare($sql);
    $statement->bind_param("i", $idUsuario);
    $statement->execute();
    $result = $statement->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            
        $info = $info.base64_encode($row["foto"]) ."|". $row['nomecompleto'] ."|". $row['usuario'] . "|". $row['descricaoperfil'] ."|". $row['dataCadastro'];

        }

    echo substr($info, 0, strlen($info) - 1);

    }else{
        echo "Tabela simulado ERROR no select".$conn->error;    
    }
}

    $conn->close();
?>