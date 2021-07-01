<?php

header('Access-Control-Allow-Origin: *');

include("conexao.php");

if(isset($_POST["idSimulado"])){
    $idUsuario = $_POST["idUsuario"];
    $idSimulado = $_POST["idSimulado"];
   
    $sql = "SELECT u.foto, u.usuario, u.descricaoperfil, r.qtdAcertos, u.usuario_id
    FROM registrosimulado r
    INNER JOIN usuarios u
    ON r.usuario_id = u.usuario_id
    WHERE `idSimulado` = ?  AND u.usuario_id NOT IN (SELECT `usuario_id` FROM registrosimulado WHERE `usuario_id` = ?)
    ORDER BY `qtdAcertos` DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idSimulado, $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();


    if($result->num_rows > 0){
        echo'
            <h2>Errou alguma pergunta? Tire suas dúvidas com outros vestibulandos:</h2>
        <div class="rankingConteudo">
        <table>
        <tr>
            <th id="popoverUsuTh"></th>
            <th class="tituloUsuario">Usuario</th>
            <th class = "nome"></th>
            <th>Quantidade acertos</th>
        </tr> ';
        while($row = $result->fetch_assoc()){
            echo'
            <tr>
           <td id = "popoverUsu">
             <div>
                 <img class="img" src="data:image/jpeg;base64,'.base64_encode($row["foto"]).'"/>
                 <p class="popDescricao">'.$row["descricaoperfil"].'</p>
             </div>

            <button class="btnAbrirChat"  idUsuario = "'.$row["usuario_id"].'" foto = "data:image/jpeg;base64,'.base64_encode($row["foto"]).'" nome ="'.$row["usuario"].'">Mandar mensagem</button>

            </td>
                <td class="tdImg"><img class="img" src="data:image/jpeg;base64,'.base64_encode($row["foto"]).'"/></td>
                 <td class = "nome" >'.$row["usuario"].'</td>
                <td>'.$row["qtdAcertos"].'</td>    

            </tr>

            
            ';
        }
        echo'
        </table>
        </div>
        ';
    }
    $conn->close();
}



?>
