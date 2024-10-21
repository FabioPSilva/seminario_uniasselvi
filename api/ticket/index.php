<?php
//Inclui o arquivo de conexão com o banco de dados
include "../sql/db.php";

//Se o METHOD for GET, consulta os dados na tabela
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    //Monta a query de consulta
    $sql = "SELECT * FROM tickets_sold";

    //Executa a query e armazena o resultado na variavel $result
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $tickets = [];

        //Itera sobre os resultados e adiciona ao array
        while($row = $result->fetch_assoc()){
            $tickets[] = $row;
        }

        echo json_encode($tickets);
    }
    //Interrompe a execução do PHP (evitar executar codigo desnecessário)
    exit;
} 

//Se o METHOD for post, salva o novo ticket vendido
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //Pega os dados do evento que foram recebidos via POST, e armazena em suas respectivas variaveis
    $userId =  (isset($_POST["user_id"])) ? $_POST["user_id"] : null;
    $eventId = (isset($_POST["event_id"])) ? $_POST["event_id"] : null;
    $eventName =  (isset($_POST["event_name"])) ? $_POST["event_name"] : null;
    $price =  (isset($_POST["price"])) ? $_POST["price"] : null;
    $saleDate =  (isset($_POST["sale_date"])) ? $_POST["sale_date"] : null;

    // monta a query de insert
    $sql = "INSERT INTO tickets_sold (user_id, event_id, price, sale_date) values ('$userId', '$eventId','$price', '$saleDate')";
    
    //Executa a query
    if($conn->query($sql)){
        echo '{"sucesso": true}';
    } else {
        echo '{"sucesso": false, "error": "'.$conn->error.'"}';
    };
}

?>