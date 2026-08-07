// PROJETO USANDO JQUERY

$(document).ready(function () {
  // Aplica as máscaras nos campos
  aplicarMascaras();

  // Configura a validação e o envio
  validarFormulario();
});

function aplicarMascaras() {
  // Preço no formato: 1.234,56
  $("#preco").mask("000.000.000,00", {
    reverse: true,
  });

  // Permite até 6 números
  $("#quantidade").mask("000000");
}

function validarFormulario() {
  // Seleciona a div responsável pelas mensagens
  const mensagem = document.getElementById("mensagem");

  // Impede o formulário de recarregar a página
  $("#formProduto").on("submit", function (evento) {
    evento.preventDefault();
  });

  // Configura o jQuery Validation
  $("#formProduto").validate({
    // Regras de validação
    rules: {
      nome: {
        required: true,
        minlength: 3,
      },
      categoria: {
        required: true,
        minlength: 3,
      },
      preco: {
        required: true,
      },
      quantidade: {
        required: true,
        digits: true,
        min: 1,
      },
    },

    // Mensagens em português
    messages: {
      nome: {
        required: "Informe o nome do produto.",
        minlength: "O nome deve ter pelo menos 3 caracteres.",
      },
      categoria: {
        required: "Informe a categoria do produto.",
        minlength: "A categoria deve ter pelo menos 3 caracteres.",
      },
      preco: {
        required: "Informe o preço do produto.",
      },
      quantidade: {
        required: "Informe a quantidade.",
        digits: "Digite somente números inteiros.",
        min: "A quantidade deve ser maior ou igual a 1.",
      },
    },

    // Mensagens de erro
    errorPlacement: function (error, element) {
      element.closest(".mb-3").find(".invalid-feedback").text(error.text());
    },

    // Executado quando o campo está inválido
    highlight: function (element) {
      $(element).removeClass("is-valid").addClass("is-invalid");
    },

    // Executado quando o campo está válido
    unhighlight: function (element) {
      $(element).removeClass("is-invalid").addClass("is-valid");
    },

    // Executado somente quando todos os campos forem válidos
    submitHandler: async function (formulario) {
      // Captura os dados do formulário
      const dados = new FormData(formulario);

      /*
       * Converte o preço:
       * Formato exibido: 1.234,56
       * Formato enviado: 1234.56
       */
      const precoConvertido = $("#preco")
        .val()
        .replace(/\./g, "")
        .replace(",", ".");

      // Substitui o preço mascarado pelo preço convertido
      dados.set("preco", precoConvertido);

      //Mostra os dados no console
      console.table(Object.fromEntries(dados.entries()));

      // Exibe mensagem enquanto envia
      mensagem.className = "alert alert-info mt-3";
      mensagem.textContent = "Enviando dados...";

      try {
        // Envia os dados para o Controller
        const resposta = await fetch("controllers/ProdutoController.php", {
          method: "POST",
          body: dados,
        });

        // Converte a resposta JSON
        const resultado = await resposta.json();

        //console.log(resultado);

        // Verifica se ocorreu erro HTTP
        if (!resposta.ok) {
          mensagem.className = "alert alert-danger mt-3";
          let conteudo = `<strong>${resultado.mensagem}</strong>`;
          if (resultado.erros) {
            conteudo += "<ul class='mb-0 mt-2'>";
            Object.entries(resultado.erros).forEach(function ([campo, erros]) {
              erros.forEach(function (erro) {
                conteudo += `<li>${erro}</li>`;
              });
            });
            conteudo += "</ul>";
          }

          mensagem.innerHTML = conteudo;

          return;
        }

        // Exibe mensagem de sucesso
        mensagem.className = "alert alert-success mt-3";
        mensagem.textContent = resultado.mensagem;

        // Limpa os campos
        formulario.reset();

      } catch (erro) {
        mensagem.className = "alert alert-danger mt-3";
        mensagem.textContent =
          "Erro ao enviar os dados para o controller de produto.";

        console.error(erro);
      }
    },
  });

  // Quando o formulário for limpo
  $("#formProduto").on("reset", function () {
    // Remove as classes de validação
    $(this).find(".form-control").removeClass("is-valid is-invalid");
  });
}
