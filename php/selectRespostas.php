<?php 
include('verifica_login.php');

header('Access-Control-Allow-Origin: *');

include("conexao.php");

if(isset($_POST["idSimulado"])){
	$idUsuario = $_POST["idUsuario"];
    $idSimulado = $_POST["idSimulado"];
	$res = "";

	$sql = "SELECT respostas FROM `registrosimulado` WHERE `usuario_id` = ? AND `idSimulado` = ?";

	$stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idUsuario, $idSimulado);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
    	 if($row = $result->fetch_assoc()){
			$respostas = json_decode($row['respostas'], TRUE);
			foreach ($respostas as $key => $value) {
				$res = $res.$key ." | " .$value ."||";
			}
			echo substr($res, 0, strlen($res) - 2);
    	 }
    	
    }else{
    	echo "RegistroFalse";
    }
    $conn->close();
}
?>

