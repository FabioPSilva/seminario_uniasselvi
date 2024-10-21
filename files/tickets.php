<?php
session_start();

if(isset($_GET["created"])) {
    if($_GET["created"] == "true") {
        echo "<script>alert('Evento criado com sucesso');</script>";
    }
}

if(isset($_GET["updated"])) {
    if($_GET["updated"] == "true") {
        echo "<script>alert('Evento atualizado com sucesso');</script>";
    }
}

if(isset($_GET["deleted"])) {
    if($_GET["deleted"] == "true") {
        echo "<script>alert('Evento excluido com sucesso');</script>";
    } else {
        echo "<script>alert('Erro ao excluir evento!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/tickets.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <title>Tickets for Show</title>

    <!-- Biblioteca externa utilizada para gerar o Código de barras -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

    <!-- Biblioteca externa utilizada para gerar o PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <!-- Script printipal, responsável pela seleção e armazenamento do item clicado -->
     <script src="js/tickets.js"></script>

     <!-- Script responsável por montar a imagem do ticket com as informações do show selecionado -->
     <script src="js/mountImgTicket.js"></script>
</head>
<body>
    <div class="div-user-logged">
        <?php
            if(isset($_SESSION["user"])) {
                echo " <a href='logout.php'><img src='images/login.png'>Sair</a>";
            } else {
                echo "<a href='login.php'><img src='images/login.png'>Entrar</a>";
            }
        ?>
    </div>
    <!--Parte do HEADER da página-->
    <header>
        
        <!--Div sobre a parte do titulo da pagina-->
        <div class="titlePage">
            Ingressos.com
        </div>

        <!--Div para os Box-->
        <div class="box">
        </div>

        <!--Box 2-->
        <div class="box2">
        </div>

        <!--Box 3-->
        <div class="box3">
        </div>

    </header>

    <!--Parte do MAIN(Principal|) da página-->
    <main>
        
        <!--Indicando pro User escolher qual show quer-->
        <div class="Choice_Event">
            <h2>
                Shows deste mês!
                <!--LINHA-->
                <div class="Line"></div>
            </h2>
        </div>

        <!--Div sobre os cards de Show-->
        <?php
            //Inclui o arquivo responsavel por consultar os eventos.
            //O arquivo já retorna o resultado no formato para exibir.
            include "../api/event/listEvents.php";
        ?>

    </main>

    <footer>
        <!--Div para os Box-->    
        <div class="sp">
            <?php
            if(!isset($_SESSION['user'])){
echo <<<EOL
            <button class="sparkle-button hidden" id="buyButton" onclick="showUserForm('show')">
                <span class="spark"></span>
        
                    <span class="backdrop"></span>
                        <svg class="sparkle" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.187 8.096L15 5.25L15.813 8.096C16.0231 8.83114 16.4171 9.50062 16.9577 10.0413C17.4984 10.5819 18.1679 10.9759 18.903 11.186L21.75 12L18.904 12.813C18.1689 13.0231 17.4994 13.4171 16.9587 13.9577C16.4181 14.4984 16.0241 15.1679 15.814 15.903L15 18.75L14.187 15.904C13.9769 15.1689 13.5829 14.4994 13.0423 13.9587C12.5016 13.4181 11.8321 13.0241 11.097 12.814L8.25 12L11.096 11.187C11.8311 10.9769 12.5006 10.5829 13.0413 10.0423C13.5819 9.50162 13.9759 8.83214 14.186 8.097L14.187 8.096Z" fill="black" stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M6.5 4L6.303 4.5915C6.24777 4.75718 6.15472 4.90774 6.03123 5.03123C5.90774 5.15472 5.75718 5.24777 5.5915 5.303L5 5.5L5.5915 5.697C5.75718 5.75223 5.90774 5.84528 6.03123 5.96877C6.15472 6.09226 6.24777 6.24282 6.303 6.4085L6.5 7L6.697 6.4085C6.75223 6.24282 6.84528 6.09226 6.96877 5.96877C7.09226 5.84528 7.24282 5.75223 7.4085 5.697L8 5.5L7.4085 5.303C7.24282 5.24777 7.09226 5.15472 6.96877 5.03123C6.84528 4.90774 6.75223 4.75718 6.697 4.5915L6.5 4Z" fill="black" stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M6 14.25L5.741 15.285C5.59267 15.8785 5.28579 16.4206 4.85319 16.8532C4.42059 17.2858 3.87853 17.5927 3.285 17.741L2.25 18L3.285 18.259C3.87853 18.4073 4.42059 18.7142 4.85319 19.1468C5.28579 19.5794 5.59267 20.1215 5.741 20.715L6 21.75L6.259 20.715C6.40725 20.1216 6.71398 19.5796 7.14639 19.147C7.5788 18.7144 8.12065 18.4075 8.714 18.259L9.75 18L8.714 17.741C8.12065 17.5925 7.5788 17.2856 7.14639 16.853C6.71398 16.4204 6.40725 15.8784 6.259 15.285L6 14.25Z" fill="black" stroke="black" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    

                        <!-- PART do BOTAO para comprar ingresso-->
                        <a href="javascript:void(0)">
                            <span class="spark"></span>
                            <span class="backdrop"></span>
                            </svg>
                            <span class="text">Comprar ingresso...</span>
                        </a>
            </button>
EOL;
            }
            ?>
        </div>
    </footer>


    <!-- Modal com o formulário dos dados do usuário -->
    <div class="container modal-overlay" id="modalOverlay">
            <img src="../files/images/close.png" class="button-close" onclick="showUserForm('hide')">
            <form action="javascript:void(0)" method="post" class="formulario" onsubmit="return createPDFTicket(this)">

                <!--Parte para preenchimento do nome completo-->
                <label for="Full_name" class="Full_name">Nome Completo</label><br>
                <input type="text" id="name" name="name" placeholder="Ex.: Wilson Rafael Gom..." required>
                <br>

                <label for="email" class="email">Seu Email</label><br>
                <input type="text" id="email" name="email" placeholder="Ex.: wilsonDev@gmail..." required>
                <br>

                <!--Div para o BOTÃO de envio-->
                <button>Confirmar</button>

        </div>
    

        <div id="disablePage"></div>

    <!--Devs
    Fabio
    Wilson
    -->
</body>
</html>