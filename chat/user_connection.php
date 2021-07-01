<?php


class UserConnection
{
	private $user_name;
	private $user_id;
	private $user_connection_id;
	private $ativo;


	public function __construct(){
	}

	function setUserName($user_name){
		$this->user_name = $user_name;
	}

	function getUserName(){
		return $this->user_name;
	}

	function setUserId($user_id){
		$this->user_id = $user_id;
	}

	function getUserId(){
		return $this->user_id;
	}

	function setUserConnectionId($user_connection_id){
		$this->user_connection_id = $user_connection_id;
	}

	function getUserConnectionId(){
		return $this->user_connection_id;
	}

	function setUserConnect($connect){
		$this->connect = $connect;
	}

	function getUserConnect(){
		return $this->connect;
	}

	function updateUserConnectionID(){

	require dirname(__DIR__) . "../php/conexao.php";

	$sql = "UPDATE `usuarios` SET `connectionID` = ? WHERE `usuario_id` = ?";

		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ii", $this->user_connection_id, $this->user_id);

		if($stmt->execute()){
			
			return 'Update da conexão feito com sucesso';
	
		}else{
			return "Erro no update da conexão";
		}

		$conn->close();

	}

	function getQualquerUserConnection($id_usuario){
		include("../php/conexao.php");
    
	    $sql = "SELECT `connectionID` FROM `usuarios` WHERE `usuario_id` = ?";

	    $stmt = $conn->prepare($sql);
	    $stmt->bind_param("i", $id_usuario);
	    $stmt->execute();
	    $result = $stmt->get_result();

	    if($result->num_rows > 0){
	        while($row = $result->fetch_assoc()){
	            return $row['connectionID'];
	        } 
	    }
	    $conn->close();
	}

	function getQualquerIdUsuario($idConexao){
		require dirname(__DIR__) . "../php/conexao.php";
    
	    $sql = "SELECT `usuario_id` FROM `usuarios` WHERE `connectionID` = ?";

	    $stmt = $conn->prepare($sql);
	    $stmt->bind_param("i", $idConexao);
	    $stmt->execute();
	    $result = $stmt->get_result();

	    if($result->num_rows > 0){
	        while($row = $result->fetch_assoc()){
	            return $row['usuario_id'];
	        } 
	    }
	    $conn->close();
	}

	function setUserStatusAtivo(){
		require dirname(__DIR__) . "../php/conexao.php";

		$sql = "UPDATE `usuarios` SET `ativo`= 1 WHERE `usuario_id` = ?";

		$stmt = $conn->prepare($sql);
		$stmt->bind_param("i", $this->user_id);

		if($stmt->execute()){
				return 'Update status ativo = 1';

		}else{
			return "Erro no update da conexão";
		}
		$conn->close();
	}

	function setAllUsersStatusAtivo($id_usuario){
		require dirname(__DIR__) . "../php/conexao.php";

		$sql = "UPDATE `usuarios` SET `ativo`= 0 WHERE `ativo` = 1 AND `usuario_id` != ?";

		$stmt = $conn->prepare($sql);
		$stmt->bind_param("i", $id_usuario);

		if($stmt->execute()){
				return 'Update dos usuarios com status ativo 0';

		}else{
			return "Erro no update da conexão dos usuário com status ativo 0";
		}
		$conn->close();
	}

}
?>

