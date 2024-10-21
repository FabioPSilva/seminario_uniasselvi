<?php
session_start();
if(!isset($_SESSION["user"])) {
include __DIR__ . '/../api/sql/db.php';

    $user = isset($_POST["user"]) ? $_POST["user"] : null;
    $password = isset($_POST["password"]) ? password_hash($_POST["password"], PASSWORD_DEFAULT) : null;

    if($user != null && $password != null) {
        $resultLogin = $conn->query("SELECT * FROM users WHERE email = '$user'");
        if($resultLogin->num_rows > 0) {
            $row = $resultLogin->fetch_assoc();
            if(password_verify($_POST["password"], $row["password"])) {
                session_start();
                $_SESSION["user"] = $user;
                header("Location: tickets.php");
            } else {
                echo "Senha incorreta";
            }
        } else {
            echo "Usuário não encontrado";
        }
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar</title>
    <style type="text/css">
        .login {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        input {
            padding: 5px;
        }
        button {
            padding: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php
        if(isset($_SESSION["user"])) {
            echo "Usuário logado: ".$_SESSION["user"];
            echo "<br><a href='login.php/?logout=true'>Sair</a>";
            exit;
        }
    ?>
    <div class="login">
        <form action="login.php" method="post">
            <label for="user">Usuário:</label>
            <input type="text" name="user" id="user" value="email@teste.com.br" required>
            <label for="password">Senha:</label>
            <input type="password" name="password" id="password" value="123456" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>