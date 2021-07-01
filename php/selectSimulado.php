<?php
include('verifica_login.php');

header('Access-Control-Allow-Origin: *');

include("conexao.php");

if(isset($_POST["simulado"])){
    $idSimulado = $_POST["idsimulado"];
    
    $sql = "SELECT * FROM simulados WHERE simulados.idSimulado = ?";

    $statement = $conn->prepare($sql);
    $statement->bind_param("i", $idSimulado);
    $statement->execute();
    $result = $statement->get_result();

    if($result->num_rows > 0){
        if($row = $result->fetch_assoc()){
            echo $row['nome'] . "|" . $row['descricao'];
             }
        }else{
            echo "Tabela simulado ERROR no select".$conn->error;    
        }
    $conn->close();

}else if(isset($_POST["questoes"])){
    $idSimulado = $_POST["idsimulado"];
    $questao = "";

    $sql = "SELECT  q.idQuestao, q.Texto as textoQuestao
    FROM simulados s
    INNER JOIN questoes q
    ON s.idSimulado = q.idSimulado
    WHERE s.idSimulado = ? ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idSimulado);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $questao = $questao.$row['idQuestao'] ."|". $row['textoQuestao'] ."||";
        }
        echo substr($questao, 0, strlen($questao) - 2);
    }else{
        echo"sem questoes";
    }
    $conn->close();

}else if(isset($_POST["alternativas"])){
    $idQuestao = $_POST["idQuestao"];
    $alternativa = "";

    $sql = "SELECT a.idQuestao, a.idAlternativa, a.texto as textoAlternativa, q.idAlternativaCerta
    FROM questoes q
    INNER JOIN alternativas a 
    ON q.idQuestao = a.idQuestao
    WHERE a.idQuestao = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idQuestao);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
         while($row = $result->fetch_assoc()){
            $alternativa = $alternativa.$row['idQuestao'] ."|".$row['idAlternativa'] ."|". $row['textoAlternativa'] . "|". $row["idAlternativaCerta"] ."||";
         }
         echo substr($alternativa, 0, strlen($alternativa) - 2);
    }else{
        echo "Sem alternativas";
    }
    $conn->close();


}
?>