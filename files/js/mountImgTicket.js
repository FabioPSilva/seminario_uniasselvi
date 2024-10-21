formatShowDate = function(showDate){
    let date = new Date(showDate.split('-'));
    let month = date.toLocaleDateString('pt-BR', {month: 'long'});

    return date.getDate()+" "+month.substring(0,3);
}

formatShowPrice = function(showPrice){
    let formattedPrice = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(showPrice);

    return formattedPrice;
}

mountTicket = function(formUserData, callback) {
    console.log(formUserData.date);

    let jsonTicketData = JSON.parse(selectedItemData);
    let splitDateShow = jsonTicketData.date.split(' ');
    let dateShow = splitDateShow;

    // Criando um novo canvas para o ticket
    const ticketCanvas = document.createElement('canvas');
    ticketCanvas.width = 820;
    ticketCanvas.height = 270;
    const ctx = ticketCanvas.getContext('2d');

    // Carregando a imagem do ticket
    const ticketImage = new Image();
    ticketImage.src = 'images/ticket.png';
    ticketImage.onload = function() {

        // Desenhar a imagem do ticket no canvas
        ctx.drawImage(ticketImage, 0, 0, ticketCanvas.width, ticketCanvas.height);

        // Adiciona Nome do show
        ctx.font = 'bold 40px Arial';
        ctx.fillStyle = 'black';
        var splitName = jsonTicketData.name.split('-'); 
        ctx.fillText(splitName[0], 290, 100);
        if(splitName.length > 1){
            ctx.fillText(splitName[1], 290, 150);
        }

        // Adiciona Data hora e preço
        ctx.font = 'bold 15px Arial';
        ctx.fillText(formatShowDate(splitDateShow[0]), 320, 233);
        ctx.fillText(dateShow[1].substring(0, dateShow[1].length - 3), 440, 233);
        ctx.fillText(formatShowPrice(jsonTicketData.price), 540, 233);

        // Adiciona Nome do cliente
        ctx.font = 'bold 16px Arial';
        ctx.save();
        ctx.translate(100, 100);
        ctx.rotate(3 * Math.PI / 2);
        ctx.fillText(formUserData.name.value.toUpperCase(), -135, 615); // Coordenadas (X, Y)
        ctx.restore();

        // Cria um canvas temporário para o código de barras
        const barcodeCanvas = document.createElement('canvas');

        // Utiliza o millis para gerar o código de barras (completa os 20 caracteres com um número aleatório)
        let millis = Date.now();
        let randomNum = Math.floor(1000000 + Math.random() * 9000000);

        // Gera o código de barras no canvas temporário
        JsBarcode(barcodeCanvas, millis + '' + randomNum, {
            format: "CODE128",
            width: 1.5,
            height: 20,
            displayValue: false,
            background: "#EDE5E3"
        });

        // Desenha o código de barras no canvas principal (ticket)
        ctx.save();
        ctx.translate(100, 100);
        ctx.rotate(3 * Math.PI / 2);
        ctx.drawImage(barcodeCanvas, -155, 560);
        ctx.restore();

        // Chama o callback após ter finalizado o desenho do ticket
        callback(ticketCanvas);
    }

    showUserForm("hidden");
    return false;
}

createPDFTicket = function(form) {
    const { jsPDF } = window.jspdf;

    mountTicket(form, function(ticketCanvas) {
        const imgData = ticketCanvas.toDataURL('image/png');

        // Criar uma nova instância do jsPDF
        const pdf = new jsPDF();

        // Adicionar a imagem do ticket ao PDF
        pdf.addImage(imgData, 'PNG', 10, 10, 190, 60);

        // Gerar o Blob (tipo de dados que armazena os binarios) do PDF
        const blob = pdf.output("blob");

        // Criar uma URL para o Blob
        const url = URL.createObjectURL(blob);

        // Abrir o PDF em uma nova aba
        window.open(url, '_blank');

        // Limpa o form
        form.reset();
    });
}


