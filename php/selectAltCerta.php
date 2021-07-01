<?php
include('verifica_login.php');

header('Access-Control-Allow-Origin: *');

include("conexao.php");

if(isset($_POST["idQuestao"])){
    $idQuestao = $_POST["idQuestao"];
    
     $sql = "SELECT `idAlternativaCerta` FROM `questoes` WHERE `idQuestao` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idQuestao);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo $row['idAlternativaCerta'];
            }
        }
    $conn->close();
}
?>