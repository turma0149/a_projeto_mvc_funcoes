# Roteiro de execução do projeto - Entendendo MVC

1- Criar as pastas
2- Criar arquivo documentacao.md
3- Criar arquivo index.php
-> para chamar rotas
4- Criar arquivo routes.php
-> Gerar o php das rotas válidas
5- Criar a view do código 404
6- Criar a view de produtos/clientes/funcionarios
7- Criar o script de produtos/clientes/funcionarios
8- Criar o controller de produto/cliente/funcionarios
9- Criar o css de de produtos/clientes/funcionarios

Exercício: Usando o roteiro abaixo crie um sistema capaz de armazenar informações de

- nome do projeto: b_projeto_mvc_clinica
  - Médico (Nome, cpf, crm, email, telefone)
- Cliente (Nome, cpf, email, telefone)
  - Agenda (crmMedico, cpfCliente, data, horário)

# Roteiro de execução do projeto - Validando dados do lado cliente e adicionando máscara

```javascript
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
    reverse: true,
  });

  // Permite até 6 números
  $("#quantidade").mask("000000");
}

function validarFormulario() {
  // Seleciona a div responsável pelas mensagens
  const mensagem = document.getElementById("mensagem");

  // Configura o jQuery Validation
  $("#formFuncionario").validate({
    // Criar regras de validação
    rules: {},

    // Colocar as mensagens em português
    messages: {},

    // Retornar as mensagens de erro
    errorPlacement: function (error, element) {},

    // Executado quando o campo está INVÁLIDO
    highlight: function (element) {},

    // Executado quando o campo está VÁLIDO
    unhighlight: function (element) {},

    // Executado somente quando todos os campos forem válidos
    submitHandler: async function (formulario) {
      // ---->>> AQUI É ONDE ENVIAMOS OS DADOS PARA O BACK-END (CONTROLLER)
    },
  });
}
```

# MVC com PHP

## Objetivo

Ao final deste conteúdo você será capaz de:

- Entender o padrão MVC
  - 1- v - view - frontend (html, css, js) - requisição
  - 2- c - controller - php no sentido de negócios
  - 3- m - model - banco de dados
- Framework de PHP - Laravel e Codeigniter

- Navegar entre páginas utilizando rotas
- Criar uma View
- Enviar dados para um Controller
- Validar informações
- Retornar uma resposta em JSON

---

# Sistema de Cadastro de Produtos

O sistema será capaz de:

- Exibir uma página
- Receber dados do formulário JS
- Enviar dados ao Controller
- Validar informações
- Retornar uma resposta ao usuário

---

# Estrutura do Projeto

- assets/
  - css/
  - js/
- config/
- controllers/
- layout
- models/
- views/
- documentacao.md
- index.php
- routes.php

| Arquivo/Pasta     | Responsabilidade                                                                            |
| ----------------- | ------------------------------------------------------------------------------------------- |
| **assets/**       | Armazena arquivos utilizados pela interface do sistema.                                     |
| **assets/css/**   | Contém os arquivos de estilos (CSS).                                                        |
| **assets/js/**    | Contém os arquivos JavaScript da aplicação.                                                 |
| **config/**       | Contém arquivos de configuração: conexão com o database, constantes e configurações gerais. |
| **controllers/**  | Recebe as requisições, valida os dados, chama o Model e retorna uma resposta.               |
| **models/**       | Manipula os dados da aplicação e realiza operações no banco de dados.                       |
| **views/**        | Contém as páginas exibidas ao usuário (HTML, CSS e JavaScript).                             |
| **documentacao/** | Contém algumas explicações para o projeto.                                                  |
| **index.php**     | Porta de entrada da aplicação. Carrega o layout principal e inicia o sistema.               |
| **routes.php**    | Analisa a URL e define qual View será carregada.                                            |

# URL

Uma URL é o endereço utilizado para acessar uma página.

Exemplo: **http://localhost/projeto/index.php?page=produtos**

Partes da URL

| Parte          | Significado       |
| -------------- | ----------------- |
| localhost      | Servidor          |
| projeto        | Pasta             |
| index.php      | Arquivo           |
| ?page=produtos | Parâmetro enviado |

---

# GET

GET envia informações pela URL.

Exemplo: **index.php?page=produtos** No PHP:

```php
$_GET["page"];
```

Neste projeto o GET informa qual página será carregada.

# index.php

Responsabilidades

- Iniciar a aplicação
- Exibir o layout
- Exibir o menu
- Carregar as rotas

Exemplo

```php
require "routes.php";
```

---

# routes.php

1- Recebe o parâmetro enviado pela URL: **?page=produtos**
2- Mostra views/produto.php
3- Caso a página não exista
mostra: views/404.php

# Fluxo Inicial

Usuário -> URL -> index.php -> routes.php -> Direciona para View

# View

A View é a interface do sistema.

Pode conter:

- HTML
- CSS
- Bootstrap
- JavaScript

A View não possui regras de negócio.

# Formulário

<form>
   <input>
   <button>
</form>

O formulário captura as informações digitadas pelo usuário.

---

# POST

POST envia informações de forma oculta. Exemplo

- Nome
- Categoria
- Preço
- Quantidade

No PHP

```php
$_POST["nome"];
```

# JavaScript

Responsabilidades

- Capturar os dados
- Enviar ao Controller
- Receber a resposta
- Atualizar a interface

---

# FormData

Captura todos os campos do formulário.

```javascript
const dados = new FormData(formProduto);
```

Capturando um campo específico.

```javascript
dados.get("nome");
dados.get("preco");
```

---

# Fetch

O `fetch()` envia dados para outro arquivo sem recarregar a página.

```javascript
fetch("controllers/ProdutoController.php");
```

Fluxo

```text
View

↓

JavaScript

↓

Controller
```

---

# JSON

JSON é um formato utilizado para trocar informações entre sistemas.

Exemplo

```json
{
  "sucesso": true,
  "mensagem": "Produto cadastrado!"
}
```

No PHP

```php
echo json_encode([
    "sucesso" => true,
    "mensagem" => "Produto cadastrado!"
]);
```

---

# Fluxo do JavaScript

```text
Captura os dados

↓

POST

↓

Controller

↓

JSON

↓

Mensagem ao usuário
```

---

# Controller

Responsabilidades

- Receber a requisição
- Receber os dados
- Validar
- Processar
- Retornar uma resposta

Fluxo

```text
Recebe

↓

Valida

↓

Processa

↓

Responde
```

---

# Validações

Exemplos

- Campos obrigatórios
- Preço válido
- Quantidade válida

As validações impedem o envio de dados inválidos.

---

# Model

O Model é responsável pelo acesso aos dados.

Exemplos

- Salvar
- Editar
- Excluir
- Listar

O Model conversa com o banco de dados.

---

# Banco de Dados

Fluxo

```text
View

↓

Controller

↓

Model

↓

Banco de Dados
```

A View nunca acessa diretamente o banco de dados.

---

# Padrão MVC

Cada camada possui uma responsabilidade.

| Camada     | Responsabilidade          |
| ---------- | ------------------------- |
| Model      | Manipular os dados        |
| View       | Exibir a interface        |
| Controller | Controlar o processamento |

---

# Responsabilidade dos Arquivos

| Arquivo    | Responsabilidade                  |
| ---------- | --------------------------------- |
| index.php  | Inicia a aplicação                |
| routes.php | Define qual página será carregada |
| View       | Interface do usuário              |
| JavaScript | Envia e recebe dados              |
| Controller | Processa a requisição             |
| Model      | Acessa o banco de dados           |
| Banco      | Armazena os dados                 |

---

# Fluxo Completo da Aplicação

```text
Usuário

↓

URL

↓

GET

↓

index.php

↓

routes.php

↓

View

↓

Formulário

↓

POST

↓

JavaScript

↓

FormData

↓

Fetch

↓

Controller

↓

Validação

↓

Model

↓

Banco de Dados

↓

Model

↓

Controller

↓

JSON

↓

JavaScript

↓

View

↓

Usuário
```
