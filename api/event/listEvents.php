<?php
//Inclui o arquivo de conexão com o banco de dados
// __DIR__ considera o caminho referente ao arquivo atual
include_once __DIR__ . '/../sql/db.php';

//Monta a query de consulta
$sql = "SELECT * FROM events";

//Executa a query e armazena o resultado na variavel $result
$result = $conn->query($sql);

// Verificando se a consulta retornou algum resultado
if ($result->num_rows > 0) {
    // Exibindo os resultados.
    while($row = $result->fetch_assoc()) {
        //Monta o JSON com as informações do show
        $showInfo = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
        echo "<div class=\"Show_cards\">";
        echo "<span onclick=\"".(isset($_SESSION['user']) ? 'null' : 'selectShow(this)')."\" data-info='$showInfo'>";
        echo "<img src='images/check.png' class='check hide'> ".$row["name"];
        //Se o usuário estiver logado, exibe os botões de edição e exclusão
        if(isset($_SESSION['user'])){
            echo "<img src='images/delete.png' class='img_edit' onclick='deleteEvent(".$row['id'].")'>";
            echo "<img src='images/pen.png' class='img_edit' onclick='location.href=\"formEvent.php?eventId=".$row['id']."\"'>";
        }

        echo "</span>";
        echo "</div>";
    }
} else {
    echo "<span style='display:block;text-align:center;margin-top:50px'>Nenhum evento disponível no momento.</span>";
}

if(isset($_SESSION['user'])){
echo "<div style='display:table;margin:0 auto'>";
            if(isset($_SESSION["user"])) {
                echo " <a href='formEvent.php'><img src='images/add.png' style='height:50px'></a>";
            }

echo "</div>";
}

// Fechando a conexão
$conn->close();

?>