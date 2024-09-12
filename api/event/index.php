<?php
//Diz que o retorno será um JSON
header('Content-Type: application/json');

//Inclui o arquivo de conexão com o banco de dados
include "../sql/db.php";

//Se o METHOD for GET, consulta os dados na tabela
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    //Monta a query de consulta
    $sql = "SELECT * FROM event";

    //Executa a query e armazena o resultado na variavel $result
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $events = [];

        //Itera sobre os resultados e adiciona ao array
        while($row = $result->fetch_assoc()){
            $events[] = $row;
        }

        echo json_encode($events);
    }
    //Interrompe a execução do PHP (evitar executar codigo desnecessário)
    exit;
} 

//Se o METHOD for post, salva ou atualiza os dados do evento
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //Pega os dados do evento que foram recebidos via POST, e armazena em suas respectivas variaveis
    $id = (isset($_POST['id'])) ? $_POST['id'] : null;
    $name =  (isset($_POST["name"])) ? $_POST["name"] : null;
    $description =  (isset($_POST["description"])) ? $_POST["description"] : null;
    $price =  (isset($_POST["price"])) ? $_POST["price"] : null;
    $date =  (isset($_POST["date"])) ? $_POST["date"] : null;

    //Se o id foi recebido, monta a query de update caso contrário monta a query de insert
    if($id == null || $id == ""){
        $sql = "INSERT INTO event (name, description, price, date) values ('$name', '$description','$price', '$date')";
    } else {
        $sql = "UPDATE event SET name = '$name', description = '$description', price = '$price', date = '$date' WHERE id = '$id'";
    }
    
    //Executa a query
    if($conn->query($sql)){
        echo '{"sucesso": true}';
    } else {
        echo '{"sucesso": false}';
    };
}

?>