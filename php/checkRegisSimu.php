<?php

header('Access-Control-Allow-Origin: *');

include("conexao.php");

if(isset($_POST["idSimulado"])){
    $idSimulado = $_POST["idSimulado"];
    $idUsuario = $_POST["idUsuario"];
   
    $sql = "SELECT * FROM `registrosimulado` WHERE `idSimulado` = ? AND `usuario_id` = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idSimulado, $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        echo"registroTrue";
    }else{  
        echo $idSimulado;
    }
    $conn->close();

}else{
    
    $idUsuario = $_POST["idUsuario"];
   
    $sql = "SELECT r.qtdAcertos, s.nome as nomeSimulado, s.descricao as descricaoSimulado, s.idSimulado, COUNT(q.idQuestao) AS qtdQuestoes
	FROM registrosimulado r
	INNER JOIN simulados s
	ON r.idSimulado = s.idSimulado
    INNER JOIN questoes q
	ON q.idSimulado = r.idSimulado
	WHERE r.usuario_id = ?
    GROUP by r.idSimulado
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){

            $titulo = strtoupper(substr( $row['nomeSimulado'], 0, 1)) . strtoupper(substr( $row['nomeSimulado'], 2, 1));

            echo'
            <div class ="cardSimuConc" idsimulado="'.$row['idSimulado'].'" titulo="'.$titulo.'" title="Visualizar Simulado" >
                <div class="text">
                    <p class="tituloSimuConc">'.$row["nomeSimulado"].'</p>
                    <p class="descricaoSimuConc">'.$row["descricaoSimulado"].'</p>
			    </div>
			    <div class="acertos">'.$row["qtdAcertos"].'/'.$row["qtdQuestoes"].'</div> 
            </div>
            ';
        }
    }else{
        echo "registroFalse";    
    }
    $conn->close();
}





?>
