<?php
header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
include("conexao.php");
session_start();
    
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') { //se a requisição for ajax

    if(empty($_POST['email']) || empty($_POST['senha'])){ //se 
        echo json_encode(array('error' => true));
    }else{

        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $senha = mysqli_real_escape_string($conn, $_POST['senha']);


        $sql = "SELECT usuario_id, usuario, senha, funcao, foto  FROM `usuarios` WHERE `email` = '$email'";  //checa primeiro se o email tá igual

        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            while($linha = $result->fetch_assoc()) {
                if(password_verify($senha, $linha["senha"])){     //para depois decodificar a senha e testar

                $_SESSION['usuario'] = $linha["usuario"]; 
                $_SESSION['usuario_id'] = $linha["usuario_id"];
                $_SESSION['foto'] = $linha["foto"];
                $_SESSION['funcao'] = $linha["funcao"];
                //se sim as sessões são criadas
                
                echo json_encode(array('sucesso' => true));   
                         //e depois é mandado pro js essa array para redirecionar a pessoa
                }else{ //email certo, senha errada

                    echo json_encode(array('error' => true));
                };
            };   
           
        }else{
            echo json_encode(array('error' => true));
        };

    };

}else{ //se não (pq aí a pessoa tentou entrar diretamente na pagina) 
    
    if(empty($_POST['email']) || empty($_POST['senha'])){
    header('Location: ../index.php');
    exit();
   };

};

?>