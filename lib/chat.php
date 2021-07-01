<?php
namespace MeuChat;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require dirname(__DIR__) . "/chat/user_connection.php";

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        $querystring = $conn->httpRequest->getUri()->getQuery();

        parse_str($querystring, $queryarray);

        $user_conn_object = new \UserConnection;

        $user_conn_object->setUserConnectionId($conn->resourceId);

        $user_conn_object->setUserId($queryarray['idUsuario']);

        $updateConexao = $user_conn_object->updateUserConnectionID();

        $user_conn_object->setUserStatusAtivo();

        $data = array(
            "entrando" => "sim",
            "idUsuario" => $queryarray['idUsuario']
        );

        foreach ($this->clients as $client) {
            if($client->resourceId !== $conn->resourceId){
            $client->send(json_encode($data));
            }
        }

        echo "Nova conexão! ({$conn->resourceId})\n" . $updateConexao . " com id de usuário = ". $queryarray['idUsuario'] . "\n";


        $qtdUsuariosAtivos = count($this->clients) - 1;

        if($qtdUsuariosAtivos == 0){
            echo 'só tem vc aqui :(';
            echo $user_conn_object->setAllUsersStatusAtivo($queryarray['idUsuario']);


        }
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);

        $destinatarioID = $data['destinatarioID'];

        $msg = $data['msg'];


        echo sprintf('Conexão %d mandando mensagem: "%s" para a conexão %d ' . "\n"
            , $from->resourceId, $msg, $destinatarioID);

        foreach ($this->clients as $client) {
            if($client->resourceId == $destinatarioID){
                $client->send(json_encode($data));

                echo "mensagem mandada para id conexão = ".$destinatarioID."\n";
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {

        $data = array(
            "saindo" => "sim",
            "idConexao" => $conn->resourceId
        );

        foreach ($this->clients as $client) {
            $client->send(json_encode($data));

        }

        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Conexão {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}