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
    "mensagem" => "Funcionário cadastrado com sucesso (controllerFuncionario).",
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
    $validator->required(
        "nome",
        "O nome do funcionário é obrigatório."
    );

    $validator->string(
        "nome",
        "O nome do funcionário deve ser um texto válido."
    );

    $validator->minLength(
        "nome",
        3,
        "O nome do funcionário deve conter no mínimo 3 caracteres."
    );

    $validator->maxLength(
        "nome",
        100,
        "O nome do funcionário deve conter no máximo 100 caracteres."
    );


    // CNPJ
    $validator->required(
        "cnpj",
        "O CNPJ do funcionário é obrigatório."
    );

    $validator->string(
        "cnpj",
        "O CNPJ do funcionário deve ser um texto válido."
    );

    $validator->minLength(
        "cnpj",
        14,
        "O CNPJ do funcionário deve conter 14 dígitos."
    );

    $validator->maxLength(
        "cnpj",
        14,
        "O CNPJ do funcionário deve conter 14 dígitos."
    );


    // Registro do Funcionário
    $validator->required(
        "regFunc",
        "O registro do funcionário é obrigatório."
    );

    $validator->string(
        "regFunc",
        "O registro do funcionário deve ser um texto válido."
    );

    $validator->minLength(
        "regFunc",
        5,
        "O registro do funcionário deve conter 5 dígitos."
    );

    $validator->maxLength(
        "regFunc",
        5,
        "O registro do funcionário deve conter 5 dígitos."
    );


    // PIS
    $validator->required(
        "pis",
        "O PIS do funcionário é obrigatório."
    );

    $validator->string(
        "pis",
        "O PIS do funcionário deve ser um texto válido."
    );

    $validator->minLength(
        "pis",
        11,
        "O PIS do funcionário deve conter 11 dígitos."
    );

    $validator->maxLength(
        "pis",
        11,
        "O PIS do funcionário deve conter 11 dígitos."
    );
}