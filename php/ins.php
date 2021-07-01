<?php
include('verifica_login.php');

header('Access-Control-Allow-Origin: *');

include("conexao.php");


if(isset($_POST["simulado"])){

    $txtNome = $_POST["txtNome"];
    $txtDescricao = $_POST["txtDescricao"];

    $sql = "INSERT INTO `simulados`(`nome`, `descricao`) VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $txtNome, $txtDescricao);

    if($stmt->execute()){
        echo $stmt->insert_id .'|'. strtoupper(substr($txtNome, 0, 1)) . strtoupper(substr($txtNome, 2, 1));

    }else{
        echo "Tabela simulado error ao inserir".$conn->error;    
    }
    $conn->close();

}else if(isset($_POST["questao"])){

    $txtQuestao = $_POST["txtQuestao"];
    $idSimulado = $_POST["idSimulado"];

    $sql = "INSERT INTO `questoes` (`idQuestao`, `idSimulado`, `Texto`, `idAlternativaCerta`) VALUES (NULL, ?, ?, NULL);";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $idSimulado, $txtQuestao);

    if($stmt->execute()){
        echo $stmt->insert_id;

    }else{
        echo "Tabela questoes error ao inserir".$conn->error;    
    }
    $conn->close();

}else if(isset($_POST["alternativa"])){

    $idAltCerta = 0;
    $txtAlternativa = $_POST["txtAlternativa"];
    $txtAlternativaCerta = $_POST["txtAlternativaCerta"];
    $idQuestao = $_POST["idQuestao"];

    $sql = "INSERT INTO `alternativas`(`idQuestao`, `texto`) VALUES (?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $idQuestao,  $txtAlternativa);

    if($stmt->execute()){

        if($txtAlternativa == $txtAlternativaCerta){
            $idAltCerta = $stmt->insert_id;
             $sql = "UPDATE `questoes` SET `idAlternativaCerta`= ? WHERE `idQuestao` = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii",  $idAltCerta,  $idQuestao);
            if($stmt->execute()){
                echo'1';
            }else{
                echo "Tabela simulado error ao dar update da alt certa".$conn->error;   
            }
        }
    }else{
        echo "Tabela alternativas error ao inserir".$conn->error;    
    }
    $conn->close();
}else if(isset($_POST["registrosimulado"])){
    
    $qtdAcertos = $_POST["qtdAcertos"];
    $idUsuario = $_POST["idUsuario"];
    $idSimulado = $_POST["idSimulado"];
    $respostas = $_POST["respostas"];

    $sql = "INSERT INTO `registrosimulado` (`resgistro_id`, `usuario_id`, `idSimulado`, `qtdAcertos`, `data`, `respostas`) VALUES (null, ?, ?, ?, NOW(), '$respostas')";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $idUsuario, $idSimulado, $qtdAcertos);

    if($stmt->execute()){
        echo json_encode("Inserido com Sucesso na Tabela registroSimulado");
    }else{
        echo json_encode("Tabela registrosimulado".$conn->error);    
    }
    $conn->close();
}
?>