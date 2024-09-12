<?php
//Seta o tipo de retorno
header('Content-Type: application/json');

//Inclui o arquivo de conexão com o banco de dados
include "../sql/db.php";

//Se o METHOD for GET, retorna a lista de usuários
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    //Monta a query de consulta
    $sql = "SELECT * FROM users";

    //Executa a query e armazena o resultado na variavel $result
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $users = [];

        //Itera sobre os resultados e adiciona ao array
        while($row = $result->fetch_assoc()){
            $users[] = $row;
        }

        echo json_encode($users);
    }
    exit;
} 

//Se o METHOD for post, salva ou atualiza os dados
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //Pega os dados do usuario que foram recebidos via POST, e armazena em suas respectivas variaveis
    $id = (isset($_POST['id'])) ? $_POST['id'] : null;
    $name =  (isset($_POST["name"])) ? $_POST["name"] : null;
    $email =  (isset($_POST["email"])) ? $_POST["email"] : null;
    $password =  (isset($_POST["password"])) ? password_hash($_POST["password"], PASSWORD_BCRYPT) : null;

    //Se o id foi recebido, monta a query de update caso contrário monta a query de insert
    if($id == null || $id == ""){
        $sql = "INSERT INTO users (name, email, password) values ('$name', '$email','$password')";
    } else {
        $sql = "UPDATE users SET name = '$name', email = '$email', password = '$password' WHERE id = '$id'";
    }
    
    //Executa a query
    if($conn->query($sql)){
        echo '{"sucesso": true}';
    } else {
        echo '{"sucesso": false}';
    };
}

?>