<?php
	
	include('verifica_login.php');

	header('Access-Control-Allow-Origin: *');

	include("conexao.php");

	$idQuestao = $_POST['idQuestao'];
	
	$sql = "DELETE FROM questoes WHERE idQuestao = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("i", $idQuestao);

	if (!$stmt->execute()) {
 	 	echo $conn->error;
	}else{
		echo "Excluído com sucesso!";
	}
	$conn->close();

?>