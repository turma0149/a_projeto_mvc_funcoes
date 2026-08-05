// PROJETO USANDO JQUERY

$(document).ready(function () {

    // Aplica as máscaras nos campos
    aplicarMascaras();

    // Configura a validação e o envio
    validarFormulario();

});

function aplicarMascaras() {

    // Preço no formato brasileiro
    // Exemplo: 1.234,56
    $("#preco").mask("000.000.000,00", {
        reverse: true
    });

    // Permite até 6 números
    $("#quantidade").mask("000000");

}

function validarFormulario() {

    // Seleciona a div responsável pelas mensagens
    const mensagem = document.getElementById("mensagem");

    // Configura o jQuery Validation
    $("#formFuncionario").validate({
        // Regras de validação
        rules: {
            nome: {
                required: true,
                minlength: 3,
                maxlength:100
            }, 
            cnpj: {
                required: true,
                minlength: 18,
                maxlength: 18
            },
            regFunc: {
               required: true 
            },
            pis: {
                required: true,
                minlength: 14,
                maxlength: 14 
            } 
        },        
        // Mensagens em português
        messages: {
            nome: {
                required: "Informe o nome do produto.",
                minlength: "O nome deve ter pelo menos 3 caracteres.",
                maxlength: "O nome deve ter no máximo 100 caracteres."
            },
            cnpj: {
                required: "Informe o CNPJ do funcionário.",
                minlength: "O CNPJ deve ter 18 caracteres.",
                maxlength: "O CNPJ deve ter 18 caracteres."
            },
            regFunc: {
                required: "Informe o registro do funcionário.",
            },
            pis: {
                required: "Informe o PIS do funcionário.",
                minlength: "O PIS deve ter 14 caracteres.",
                maxlength: "O PIS deve ter 14 caracteres."
            } 
        }, 
        // Mensagens de erro
        errorPlacement: function (error, element) {
        },
        // Executado quando o campo está inválido
        highlight: function (element) {
        },
        // Executado quando o campo está válido
        unhighlight: function (element) {
        },
        // Executado somente quando todos os campos forem válidos
        submitHandler: async function (formulario) {
            //de fato envia o formulário para controler
        }
        


    });
}

