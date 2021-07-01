<?php
session_start();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include("conexao.php");
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') { //se a requisição for ajax

    if(empty($_POST['email'])  ||empty($_POST['nomecompleto']) ||empty($_POST['usuario']) || empty($_POST['senha'])){
        echo json_encode(array('erro_dados' => true)); 
        exit();

    }else{

        $email = trim($_POST['email']);

        $nomecompleto = trim($_POST['nomecompleto']);
        
        $usuario = trim($_POST['usuario']);
        
        $descricaoperfil =  trim($_POST['descricaoperfil']);
        
        $txtFoto = file_get_contents($_POST['txtFoto']);
        
        $senha = password_hash(($_POST['senha']), PASSWORD_DEFAULT);
        
        
        $sql = "SELECT COUNT(*) AS total FROM usuarios WHERE usuarios.email = ?";

        $stmt = $conn->prepare($sql);    
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        
        if ($row['total'] == 1) {
            echo json_encode(array('existe' => true));   
        }else{

        $sql = "INSERT INTO `usuarios`(`usuario_id`, `usuario`, `email`, `senha`, `nomecompleto`, `descricaoperfil`, `foto`, `dataCadastro`, `funcao`) VALUES (null, ?, ?, ?, ?, ?, ?, NOW(),'usuario')";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $usuario, $email, $senha, $nomecompleto, $descricaoperfil, $txtFoto);


            if($stmt->execute()){
                echo json_encode(array('sucesso' => true));  
            }else{
                echo json_encode(array('eoeoeoeerro' => true)); 
            }; 
        };
    };

}else{
    header('Location: ../index.php');
    exit();
}

?>