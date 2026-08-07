<?php

// A resposta será enviada em formato JSON
header("Content-Type: application/json; charset=utf-8");


// Carrega a classe Validator
require __DIR__ . "/../libs/php/Validator.php";


// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    http_response_code(405);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Método não permitido. Utilize uma requisição POST.",
        "dados" => null,
        "erros" => null
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    exit;
}


// Cria o objeto validador
$validator = new Validator($_POST);


// Executa as regras de validação
validarCadastro($validator);


// Verifica se existem erros de validação
if ($validator->fails()) {

    http_response_code(422);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Corrija os campos indicados.",
        "dados" => null,
        "erros" => $validator->errors()
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    exit;
}


// -------->>> TODO: Aqui será realizado o cadastro no banco de dados


// Retorna sucesso
http_response_code(200);

echo json_encode([
    "sucesso" => true,
    "mensagem" => "Cliente cadastrado com sucesso (controllerCliente).",
    "dados" => $validator->data(),
    "erros" => null
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

exit;


// --------------------------------------------------
// Funções auxiliares
// --------------------------------------------------

function validarCadastro($validator)
{
    // Nome
    $validator->required("nome", "O nome do cliente é obrigatório. (controllerCliente)");

    $validator->string("nome", "O nome do cliente deve ser um texto válido. (controllerCliente)");

    $validator->minLength(
        "nome",
        3,
        "O nome do cliente deve conter no mínimo 3 caracteres. (controllerCliente)"
    );

    $validator->maxLength(
        "nome",
        100,
        "O nome do cliente deve conter no máximo 100 caracteres. (controllerCliente)"
    );


    // CPF
    $validator->required(
        "cpf",
        "O CPF do cliente é obrigatório. (controllerCliente)"
    );

    $validator->string(
        "cpf",
        "O CPF do cliente deve ser um texto válido. (controllerCliente)     "
    );

    $validator->minLength(
        "cpf",
        11,
        "O CPF do cliente deve conter 11 dígitos. (controllerCliente)"
    );

    $validator->maxLength(
        "cpf",
        11,
        "O CPF do cliente deve conter 11 dígitos. (controllerCliente)"
    );


    // E-mail
    $validator->required(
        "email",
        "O e-mail do cliente é obrigatório. (controllerCliente)"
    );

    $validator->email(
        "email",
        "Informe um e-mail válido. (controllerCliente)"
    );


    // Telefone
    $validator->required(
        "telefone",
        "O telefone do cliente é obrigatório. (controllerCliente)"
    );

    $validator->string(
        "telefone",
        "O telefone do cliente deve ser um texto válido. (controllerCliente)"
    );

    $validator->minLength(
        "telefone",
        10,
        "O telefone do cliente deve conter no mínimo 10 dígitos. (controllerCliente)"
    );

    $validator->maxLength(
        "telefone",
        10,
        "O telefone do cliente deve conter no máximo 10 dígitos.(controllerCliente)"
    );
}
