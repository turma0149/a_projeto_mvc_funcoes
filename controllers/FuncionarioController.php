<?php

//A resposta será enviada em formato JSON
header("Content-Type: application/json; charset=utf-8");

//Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); //405 - método não permitido

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Método não permitido, esperava POST"
    ]);

    exit;
}

// Recebe os dados enviados pelo formulário
$nome = trim($_POST['nome']);
$regFunc = trim($_POST['regFunc']);
$pis = trim($_POST['pis']);
$cnpj = trim($_POST['cnpj']);

// Valida os campos obrigatórios 
if ($nome === "" || $regFunc === "" || $pis === "" || $cnpj === "") {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Preencha todos os campos"
    ]);

    exit;
}

// -------->>> TODO: Aqui seria o banco de dados 

//Retornar sucesso 
http_response_code(200);

echo json_encode([
    "sucesso" => true,
    "mensagem" => "Funcionario cadastrado com sucesso!",
    "funcionario" => [
        "nome" => $nome,
        "regFunc" => $regFunc,
        "pis" => $pis,
        "cnpj" => $cnpj
    ]
]);
