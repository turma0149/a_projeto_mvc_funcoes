
// Selecionar o formulário e a div de mensagens
const form = document.getElementById("formCliente");
const mensagem = document.getElementById("mensagem");

// Executa quando o formulário é enviado
form.addEventListener("submit", async function (evento) {

    // Impede o recarregamento da página
    evento.preventDefault();

    // Captura os dados do formulário
    const dados = new FormData(form);

    //Mostra (no console = f12) os dados do form em tabela
    //console.table(Object.fromEntries(dados.entries()));
    //console.log("simples");

    // Exibe uma mensagem enquanto os dados são enviados
    mensagem.className = "alert alert-info mt-3";
    mensagem.textContent = "Enviando dados...";

    try {
        // Envia os dados para o Controller
        const resposta = await fetch("controllers/ClienteController.php", {
            method: "POST",
            body: dados
        });

        // Converte a resposta JSON em objeto JavaScript
        const resultado = await resposta.json();

        console.log(resultado);

        // Verifica o código HTTP (200..) da resposta
        if (!resposta.ok) {
            mensagem.className = "alert alert-danger mt-3";
            mensagem.textContent = resultado.mensagem;
            return;
        }

        // Exibe a mensagem de sucesso
        mensagem.className = "alert alert-success mt-3";
        mensagem.textContent = resultado.mensagem;

        // Limpa o formulário
        form.reset();

    } catch (erro) {
        mensagem.className = "alert alert-danger mt-3";
        mensagem.textContent = "Erro ao enviar os dados para o controller cliente";

        console.log(erro);
    }
});