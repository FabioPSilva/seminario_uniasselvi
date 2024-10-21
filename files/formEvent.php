<?php
//Inclui o arquivo de conexão com o banco de dados
// __DIR__ considera o caminho referente ao arquivo event  
include_once __DIR__ . '/../api/sql/db.php';    

$eventId = (isset($_GET['eventId'])) ? $_GET['eventId'] : null;  

//Monta a query de consulta
$sql = "SELECT * FROM events WHERE id = $eventId";

//Executa a query e armazena o resultado na variavel $result
$result = $conn->query($sql);

$id = "";
$name = "";
$description = ""; 
$price = "";       
$date = "";
$time = "";
$local = "";

if($eventId != null){
    // Verificando se a consulta retornou algum resultado
    if ($result->num_rows > 0) {
        // Exibindo os resultados.
        while($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $name = $row["name"];
            $description = $row["description"];
            $price = $row["price"];
            $date = explode(' ',$row["date"])[0];
            $time = explode(' ',$row["date"])[1];
            $local = $row["local"];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/form.css">
    
    <title>Formulario</title>
    <script src="js/form.js"></script>  
</head>
<body>
    
    <!--Main para formulario-->
    <main>

        <div class="container modal-overlay" style="display:block" id="eventForm">
            <a href="tickets.php"><img src="../files/images/close.png" class="img-close"></a>
            <?php
                if($id != null){
                    echo "<h2>Editar Show</h2>";
                } else {
                    echo "<h2>Adicionar Show</h2>";
                }
            ?>
            <form action="../api/event/saveEvent.php" method="post">
                <input type="hidden" id="id" name="id" value="<?php echo $id;?>" style="width: 50px;">
                <br>
                <label for="name">Nome:</label><br>
                <input type="text" id="nameShow" name="name" value="<?php echo $name;?>" required>
                <br>
                <label for="description">Descrição:</label><br>
                <textarea id="description" name="description" rows="2" required> </textarea>
                <br>
                <label for="price">Preço:</label><br>
                <input type="number" id="price" name="price" step="0.01" value="<?php echo $price;?>" required>
                <br>
                <label for="date">Data:</label><br>
                <input type="date" id="date" name="date" value="<?php echo $date;?>" required>
                <br>
                <label for="date">Hora:</label><br>
                <input type="time" id="time" name="time" value="<?php echo $time;?>" required>
                <br>
                <label for="name">Local:</label><br>
                <input type="text" id="local" name="local" value="<?php echo $local;?>" required>
                <br>
                <?php
                if(isset($_GET["updated"])) {
                    if($_GET["updated"] == "false") {
                        echo "<span class='msg-err'>Erro ao atualizar evento\nTente novamente!</span>";
                    }
                }

                if(isset($_GET["created"])) {
                    if($_GET["created"] == "false") {
                        echo "<span class='msg-err'>Erro ao adicionar novo evento\nTente novamente!</span>";
                    }
                }
                ?>
                <button type="submit">Enviar</button>
            </form>
    
        </div>
    
    </main>

</body>
</html>