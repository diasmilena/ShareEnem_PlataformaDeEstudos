<?php
include("conexao.php");
session_start();

$sql = "SELECT * FROM simulados WHERE simulados.idSimulado NOT IN (SELECT idSimulado FROM registrosimulado WHERE registrosimulado.usuario_id = ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
	while($row = $result->fetch_assoc()){

		$titulo = strtoupper(substr( $row['nome'], 0, 1)) . strtoupper(substr( $row['nome'], 2, 1));

		echo' <div class="card" idsimulado="'.$row['idSimulado'].'" titulo="'.$titulo.'" title="Visualizar Simulado" >
  				<div class="tituloSplited">'.$titulo.'</div>
					<h1 class= "card_titulo">'.$row['nome'].'
					</h1>
					<p>'.$row['descricao'].'</p> 

					<img src="imgs_inicial/loading.gif" class="loadingGif">
			  </div>';
	}
}else{
	echo"Todos simulados já concluídos.";
}

?>