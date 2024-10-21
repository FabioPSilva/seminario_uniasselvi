<?php
//Inclui o arquivo de conexão com o banco de dados
// __DIR__ considera o caminho referente ao arquivo event
include_once __DIR__ . '/../sql/db.php';

//Pega os dados do evento que foram recebidos via POST, e armazena em suas respectivas variaveis
$id = (isset($_POST['id'])) ? $_POST['id'] : null;
$name =  (isset($_POST["name"])) ? $_POST["name"] : null;
$description =  (isset($_POST["description"])) ? $_POST["description"] : null;
$price =  (isset($_POST["price"])) ? $_POST["price"] : null;
$date =  (isset($_POST["date"])) ? $_POST["date"] : null;
$time =  (isset($_POST["time"])) ? $_POST["time"] : null;
$local = (isset($_POST["local"])) ? $_POST["local"] : null;
if($date != null){
    $date = $date . " ".$time;
}


//Se o id foi recebido, monta a query de update caso contrário monta a query de insert
if($id == null || $id == ""){
    $sql = "INSERT INTO events (name, description, price, date) values ('$name', '$description','$price', '$date', '$local')";
} else {
    $sql = "UPDATE events SET name = '$name', description = '$description', price = '$price', date = '$date', local = '$local' WHERE id = '$id'";
}
    
//Executa a query
if($conn->query($sql)){
    //Se suceso, redireciona para a página de tickets
    if($id == null || $id == ""){
        header("Location: ../../files/tickets.php?created=true");
    } else {
        header("Location: ../../files/tickets.php?updated=true");
    }
} else {
    //Se falhar, retorna para o formulario de edição
    if($id == null || $id == ""){
        header("Location: ../../files/formEvent.php?eventId=".$id."&created=false");
    } else {
        header("Location: ../../files/formEvent.php?eventId=".$id."&updated=false");
    }
}

?>