<?php
include('verifica_login.php');

header('Access-Control-Allow-Origin: *');

include("conexao.php");


if(isset($_POST["idQuestao"])){

    $idQuestao  = $_POST["idQuestao"];
    $txtQuestao = $_POST["txtQuestao"];
    $idAltCerta = $_POST["idAltCerta"];

    $sql = "UPDATE `questoes` SET `Texto`= ?, `idAlternativaCerta` =  ? WHERE `idQuestao` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $txtQuestao, $idAltCerta, $idQuestao);

    if($stmt->execute()){
        echo "update feito com sucesso";

    }else{
        echo "Tabela questão erro no update".$conn->error;    
    }
    $conn->close();

}else if(isset($_POST["idAlt"])){
    $txtAlt  = $_POST["txtAlt"];
    $idAlt = $_POST["idAlt"];

    $sql = "UPDATE `alternativas` SET `texto` = ? WHERE `idAlternativa` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $txtAlt, $idAlt);

    if($stmt->execute()){
        echo "update alt feito com sucesso";

    }else{
        echo "Tabela alternativas erro no update".$conn->error;    
    }
    $conn->close();
}
?>