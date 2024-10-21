<?php
//Inclui o arquivo de conexão com o banco de dados
// __DIR__ considera o caminho referente ao arquivo event
include_once __DIR__ . '/../sql/db.php';

//Pega o id do evento que foi recebido via POST, e armazena na variavel
$id = (isset($_GET['eventId'])) ? $_GET['eventId'] : null;

//Monta a query de delete passando o id
$sql = "DELETE FROM events WHERE id = $id"; 
    
//Executa a query
if($conn->query($sql)){
    header("Location: ../../files/tickets.php?deleted=true");
} else {
    header("Location: ../../files/tickets.php?deleted=false");
};

?>