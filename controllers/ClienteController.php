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
$cpf = trim($_POST['cpf']);
$email = trim($_POST['email']);
$telefone = trim($_POST['telefone']);

// Valida os campos obrigatórios 
if ($nome === "" || $cpf === "" || $email === "" || $telefone === "") {
    http_response_code(400);

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Preencha todos os campos"
    ]);

    exit;
}

// -------->>> TODO: Aqui seria o banco de dados 

//Simulando  retornar  sucesso 
http_response_code(200);

echo json_encode([
    "sucesso" => true,
    "mensagem" => "Cliente cadastrado com sucesso!",
    "cliente" => [
        "nome" => $nome,
        "cpf" => $cpf,
        "email" => $email,
        "telefone" => $telefone,
    ]
]);
