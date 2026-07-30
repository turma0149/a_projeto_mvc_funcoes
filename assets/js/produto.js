//Selecionar o formulário e a div de mensagens 
const form = document.getElementById("formProduto");
const mensagem = document.getElementById("mensagem");

//Executa quando o formulário é enviado
form.addEventListener("submit", async function (evento){

    //Impede o recarregamento da página
    evento.preventDefault();

    //Capturar dados do formulário
    const dados = new FormData(form);

    //Exibe uma mensagem enquanto os dados são enviados
    mensagem.className = "alert alert-info mt-3";
    mensagem.textContent = "Enviando dados...";
    
    try{
        //Envia os dados para o Controller
        const resposta = await fetch("controllers/ProdutoController.php",{
            method: "post",
            body: dados
        }); 

    } catch(erro){
        //Exibe mensagem caso ocorra erro
        mensagem.className = "alert alert-danger mt-3";
        mensagem.textContent = "Erro ao enviar os dados";

        console.log(erro);
    }
});