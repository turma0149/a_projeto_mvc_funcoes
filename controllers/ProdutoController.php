<?php

//A resposta será enviada em formato JSON
header("Content-Type: application/json; charset=utf-8");

// Carrega a classe Validator.
require_once __DIR__ . "/../libs/Validator.php";

//Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); //405 - método não permitido

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Método não permitido, esperava POST"
    ]);

    exit;
}

// Cria o objeto validador
$validator = new Validator($_POST);

//Executa a função que contém as regras de validação
validarCadastro($validator);


// -------->>> TODO: Aqui seria o banco de dados 


//Verifica se tem erros
if ($validator->fails()) {

    http_response_code(422);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Corrija os campos indicados.",
        "erros" => $validator->errors()
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    exit;
}


//Retornar sucesso 
http_response_code(200);

echo json_encode([
    "sucesso" => true,
    "mensagem" => "Dados validados com sucesso.",
    "dados" => $validator->data()
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

exit;



// ------ Funções auxiliares ------------


function validarCadastro($validator)
{
    $validator->required("nome", "Informe o nome.");
    $validator->string("nome", "O nome deve ser um texto.");
    $validator->minLength("nome", 3, "O nome deve ter pelo menos 3 caracteres.");
    $validator->maxLength("nome", 30, "O nome deve ter no máximo 30 caracteres.");
}
