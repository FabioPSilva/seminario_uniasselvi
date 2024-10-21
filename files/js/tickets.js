 //Variavel que vai armazenar os dados do show selecionado
 var selectedItemData = null;

 //Variavel que vai armazenar a imagem de Check do item clicado
 var checkIcon = null;
 
 //Método que é chamado ao clicar em algum show 
 //Rerecebe como parâmetro o item (elemento <span>) que foi clicado e o id do show
 selectShow = function(item){

     //Se não houver nenhum show selecionado...
     if(selectedItemData == null){

         //Armazena a referência da "imagem de check" do item clicado
         checkIcon = item.querySelector('.check');

         //Altera a visibilidade da "check" removendo a classe hide
         checkIcon.classList.toggle('hide');

         //Armazena o conteúdo do show selecionado
         selectedItemData = item.getAttribute('data-info');

        //exibe o botão de comprar
        document.getElementById('buyButton').style.visibility = 'visible';

         //Dá um return para parar a execução do restante do código (Para evitar usar ELSE)
         return;
     }

     //Executa o código abaixo se a houver um show selecionado (não caiu no return).

     //Oculta o check do item que já está selecionado
     checkIcon.classList.toggle('hide');

     if(selectedItemData != item.getAttribute('data-info')){
     //Armazena a "check" do item que foi clicado
     checkIcon = item.querySelector('.check');

     //Exibe o check do item clicado
     checkIcon.classList.toggle('hide');

     //Armazena os dados do novo show selecionado
     selectedItemData = item.getAttribute('data-info');

     //exibe o botão de comprar
     document.getElementById('buyButton').style.visibility = 'visible';
     } else {
         selectedItemData = null;
         document.getElementById('buyButton').style.visibility = 'hidden';
     }
 }

 setVisibleEventForm = function(visible){
    document.getElementById('eventForm').style.display = visible ? 'block' : 'none';
 }

 showUserForm = function(visible){
    document.getElementById('disablePage').style.display = visible == 'show' ? 'block' : 'none';
    document.getElementById('modalOverlay').style.display = visible == 'show' ? 'block' : 'none';
 }

 showForm = function(form){
    document.getElementById('modalFormShow').style.display = 'block';
 }

 editEvent = function(element){
    alert(element.getAttribute('data-info'));
 }

 deleteEvent = function(eventId){
    if(confirm('Deseja realmente excluir este evento?')){
        location.href = '../api/event/deleteEvent.php?eventId=' + eventId;
    }
 }