// PROJETO USANDO JQUERY

$(document).ready(function () {
  // Aplica as máscaras nos campos
  aplicarMascaras();

  // Configura a validação e o envio
  validarFormulario();
});

function aplicarMascaras() {
  // CNPJ no formato: 00.000.000/0000-00
  $("#cnpj").mask("00.000.000/0000-00");

  // PIS no formato: 000.00000.00-0
  $("#pis").mask("000.00000.00-0");

  // Registro no formato: 0-0000
  $("#regFunc").mask("0-0000");
}

function validarFormulario() {
  // Seleciona a div responsável pelas mensagens
  const mensagem = document.getElementById("mensagem");

  // Impede o formulário de recarregar a página
  $("#formFuncionario").on("submit", function (evento) {
    evento.preventDefault();
  });

  // Configura o jQuery Validation
  $("#formFuncionario").validate({
    // Regras de validação
    rules: {
      nome: {
        required: true,
        minlength: 3,
        maxlength: 100,
      },

      cnpj: {
        required: true,
        minlength: 18,
        maxlength: 18,
      },

      regFunc: {
        required: true,
      },

      pis: {
        required: true,
        minlength: 14,
        maxlength: 14,
      },
    },

    // Mensagens em português
    messages: {
      nome: {
        required: "Informe o nome do funcionário.",
        minlength: "O nome deve ter pelo menos 3 caracteres.",
        maxlength: "O nome deve ter no máximo 100 caracteres.",
      },

      cnpj: {
        required: "Informe o CNPJ do funcionário.",
        minlength: "Informe um CNPJ válido.",
        maxlength: "Informe um CNPJ válido.",
      },

      regFunc: {
        required: "Informe o registro do funcionário.",
      },

      pis: {
        required: "Informe o PIS do funcionário.",
        minlength: "Informe um PIS válido.",
        maxlength: "Informe um PIS válido.",
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
       * Remove a máscara do CNPJ:
       * Formato exibido: 00.000.000/0000-00
       * Formato enviado: 00000000000000
       */
      const cnpj = $("#cnpj").val().replace(/\D/g, "");

      /*
       * Remove a máscara do PIS:
       * Formato exibido: 000.00000.00-0
       * Formato enviado: 00000000000
       */
      const pis = $("#pis").val().replace(/\D/g, "");

      /*
       * Remove a máscara do registro:
       * Formato exibido: 0-0000
       * Formato enviado: 00000
       */
      const regFunc = $("#regFunc").val().replace(/\D/g, "");

      // Substitui os valores mascarados pelos valores sem máscara
      dados.set("cnpj", cnpj);
      dados.set("pis", pis);
      dados.set("regFunc", regFunc);

      // Mostra os dados no console
      console.table(Object.fromEntries(dados.entries()));

      // Exibe mensagem enquanto envia
      mensagem.className = "alert alert-info mt-3";
      mensagem.textContent = "Enviando dados...";

      try {
        // Envia os dados para o Controller
        const resposta = await fetch("controllers/FuncionarioController.php", {
          method: "POST",
          body: dados,
        });

        // Converte a resposta JSON
        const resultado = await resposta.json();

        // console.log(resultado);

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
          "Erro ao enviar os dados para o controller de funcionário.";

        console.error(erro);
      }
    },
  });

  // Quando o formulário for limpo
  $("#formFuncionario").on("reset", function () {
    // Remove as classes de validação
    $(this).find(".form-control").removeClass("is-valid is-invalid");
  });
}