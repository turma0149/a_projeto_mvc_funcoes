# Projeto MVC com PHP, jQuery e Bootstrap

> Documentação revisada de acordo com o estado atual do projeto.

---

# PARTE 1 — ROTEIRO DE EXECUÇÃO DO PROJETO

## 1. Objetivo do projeto

Construir um sistema didático de cadastros para compreender o fluxo de uma aplicação organizada no padrão MVC.

O projeto possui atualmente:

- Página inicial;
- Rotas;
- Página 404;
- Cadastro de produtos;
- Cadastro de clientes;
- Cadastro de funcionários;
- Validação no frontend com jQuery Validation;
- Máscaras com jQuery Mask;
- Envio assíncrono com `fetch()`;
- Controllers em PHP;
- Validação no backend com a classe `Validator`;
- Respostas padronizadas em JSON.

O banco de dados e os Models ainda serão implementados.

---

## 2. Criar a estrutura de pastas

Estrutura atual:

```text
a_projeto_mvc_completo/
│
├── assets/
│   ├── css/
│   │   ├── 404.css
│   │   ├── cliente.css
│   │   ├── funcionario.css
│   │   └── produto.css
│   │
│   ├── img/
│   │   └── erro-404.png
│   │
│   └── js/
│       ├── 404.js
│       ├── cliente.js
│       ├── funcionario.js
│       └── produto.js
│
├── config/
│   └── exemploConfig.php
│
├── controllers/
│   ├── ClienteController.php
│   ├── FuncionarioController.php
│   └── ProdutoController.php
│
├── layout/
│   └── exemploLayout.php
│
├── libs/
│   └── Validator.php
│
├── models/
│   └── exemploModel.php
│
├── views/
│   ├── 404.php
│   ├── cliente.php
│   ├── funcionario.php
│   ├── home.php
│   └── produto.php
│
├── documentacao.md
├── index.php
└── routes.php
```

### Responsabilidade de cada pasta

| Pasta/Arquivo | Responsabilidade |
| --- | --- |
| `assets/` | Recursos utilizados pela interface |
| `assets/css/` | Estilos CSS das páginas |
| `assets/img/` | Imagens |
| `assets/js/` | JavaScript criado para as páginas |
| `config/` | Futuras configurações, como conexão com banco |
| `controllers/` | Recebem requisições, validam e processam os dados |
| `layout/` | Futuras partes reutilizáveis do layout |
| `libs/` | Classes e bibliotecas reutilizáveis |
| `models/` | Futuro acesso ao banco de dados |
| `views/` | Páginas exibidas ao usuário |
| `documentacao.md` | Documentação do projeto |
| `index.php` | Porta de entrada da aplicação |
| `routes.php` | Define qual View será carregada |

---

## 3. Criar o `index.php`

O `index.php` é a porta de entrada da aplicação.

No projeto atual ele é responsável por:

1. Criar a estrutura HTML;
2. Carregar Bootstrap;
3. Carregar Bootstrap Icons;
4. Descobrir a página atual;
5. Exibir o cabeçalho;
6. Exibir o menu;
7. Chamar `routes.php`;
8. Exibir o rodapé;
9. Carregar o JavaScript do Bootstrap.

Página padrão:

```php
<?php $page = $_GET['page'] ?? 'home'; ?>
```

Isso significa:

```text
index.php
↓
home
```

O arquivo de rotas é carregado dentro do `<main>`:

```php
require __DIR__ . "/routes.php";
```

---

## 4. Criar o menu principal

O sistema possui as opções:

```text
Início
Produtos
Clientes
Funcionários
```

Exemplo:

```php
<a href="index.php?page=produtos"
   class="nav-link <?= $page === 'produtos'
       ? 'text-white fw-bold'
       : 'text-white-50' ?>">
    Produtos
</a>
```

A expressão PHP identifica a página atual e destaca o item correspondente.

O título do sistema também funciona como link para a Home:

```html
<a href="index.php?page=home"
   class="text-white text-decoration-none">
    Sistema de Cadastros
</a>
```

---

## 5. Criar o `routes.php`

As páginas válidas atualmente são:

```php
$paginasValidas = [
    "home" => __DIR__ . "/views/home.php",
    "produtos" => __DIR__ . "/views/produto.php",
    "clientes" => __DIR__ . "/views/cliente.php",
    "funcionarios" => __DIR__ . "/views/funcionario.php",
];
```

A página é capturada com:

```php
$page = $_GET["page"] ?? "home";
```

Depois verificamos se a rota existe:

```php
if (array_key_exists($page, $paginasValidas)) {

    require $paginasValidas[$page];

} else {

    http_response_code(404);

    require __DIR__ . "/views/404.php";
}
```

### Rotas atuais

| URL                           | View             |
| ----------------------------- | ---------------- |
| `index.php`                   | `home.php`       |
| `index.php?page=home`         | `home.php`       |
| `index.php?page=produtos`     | `produto.php`    |
| `index.php?page=clientes`     | `cliente.php`    |
| `index.php?page=funcionarios` | `funcionario.php`|
| rota inexistente              | `404.php`        |

---

## 6. Criar a Home

Arquivo:

```text
views/home.php
```

A Home possui três cards:

- Produtos;
- Clientes;
- Funcionários.

Cada card direciona para uma rota do sistema.

Exemplo:

```html
<a href="index.php?page=produtos"
   class="btn btn-primary">
    Acessar produtos
</a>
```

A página utiliza principalmente classes do Bootstrap, sem necessidade de CSS próprio neste momento.

---

## 7. Criar a página 404

Arquivo:

```text
views/404.php
```

Quando uma rota não existe:

```php
http_response_code(404);
require __DIR__ . "/views/404.php";
```

A View possui:

- imagem;
- código `404`;
- mensagem;
- orientação ao usuário;
- botão para Produtos;
- botão para Página Inicial.

Arquivo de estilo existente:

```text
assets/css/404.css
```


O arquivo `assets/js/404.js` está vazio e pode permanecer como reserva para futuras funcionalidades ou ser removido caso não seja utilizado.

---

## 8. Criar as Views de cadastro

Arquivos:

```text
views/produto.php
views/cliente.php
views/funcionario.php
```

### Produto

Campos:

```text
nome
categoria
preco
quantidade
```

### Cliente

Campos:

```text
nome
cpf
email
telefone
```

### Funcionário

Campos:

```text
nome
cnpj
regFunc
pis
```

### Estrutura padronizada

Os formulários seguem o mesmo padrão:

```html
<div class="mb-3">

    <label for="nome" class="form-label">
        Nome
    </label>

    <div class="input-group">

        <span class="input-group-text">
            <i class="bi bi-person"></i>
        </span>

        <input
            type="text"
            id="nome"
            name="nome"
            class="form-control"
        >

        <div class="invalid-feedback"></div>
        <div class="valid-feedback"></div>

    </div>

</div>
```

Também existe uma área padronizada para retorno:

```html
<div id="mensagem"
     class="alert d-none mt-3">
</div>
```

---

## 9. Carregar as bibliotecas JavaScript

Nas três Views de cadastro são carregadas:

### jQuery

```html
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
```

### jQuery Validation

```html
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
```

### jQuery Mask

```html
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
```

Depois é carregado o script específico da página:

```html
<script src="assets/js/produto.js"></script>
```

A ordem é importante:

```text
jQuery
↓
jQuery Validation
↓
jQuery Mask
↓
JavaScript da página
```

---

## 10. Inicializar o JavaScript

Os scripts seguem o mesmo padrão:

```javascript
$(document).ready(function () {

    aplicarMascaras();

    validarFormulario();

});
```

Isso executa o código quando a página estiver pronta.

---

## 11. Aplicar máscaras

### Produto

Preço:

```javascript
$("#preco").mask("000.000.000,00", {
    reverse: true,
});
```

Quantidade:

```javascript
$("#quantidade").mask("000000");
```

### Cliente

CPF:

```javascript
$("#cpf").mask("000.000.000-00");
```

Telefone:

```javascript
$("#telefone").mask("(00) 00000-0000");
```

### Funcionário

CNPJ:

```javascript
$("#cnpj").mask("00.000.000/0000-00");
```

PIS:

```javascript
$("#pis").mask("000.00000.00-0");
```

Registro:

```javascript
$("#regFunc").mask("0-0000");
```

---

## 12. Validar no lado cliente

Exemplo de Produto:

```javascript
$("#formProduto").validate({

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

});
```

---

## 13. Mostrar feedback do Bootstrap

Mensagem de erro:

```javascript
errorPlacement: function (error, element) {

    element
        .closest(".mb-3")
        .find(".invalid-feedback")
        .text(error.text());
},
```

Campo inválido:

```javascript
highlight: function (element) {

    $(element)
        .removeClass("is-valid")
        .addClass("is-invalid");
},
```

Campo válido:

```javascript
unhighlight: function (element) {

    $(element)
        .removeClass("is-invalid")
        .addClass("is-valid");
},
```

Ao limpar o formulário:

```javascript
$("#formProduto").on("reset", function () {

    $(this)
        .find(".form-control")
        .removeClass("is-valid is-invalid");

});
```

O mesmo padrão foi aplicado em Cliente e Funcionário.

---

## 14. Criar o `FormData`

Quando o formulário estiver válido:

```javascript
submitHandler: async function (formulario) {

    const dados = new FormData(formulario);

}
```

O `FormData` reúne os campos que possuem atributo `name`.

Exemplo:

```html
<input id="nome" name="nome">
```

Consultar:

```javascript
dados.get("nome");
```

Alterar:

```javascript
dados.set("nome", "Novo valor");
```

---

## 15. Preparar os dados antes do envio

### Preço

Na tela:

```text
1.234,56
```

Enviado:

```text
1234.56
```

Código:

```javascript
const precoConvertido = $("#preco")
    .val()
    .replace(/\./g, "")
    .replace(",", ".");

dados.set("preco", precoConvertido);
```

### CPF

```javascript
const cpf = $("#cpf")
    .val()
    .replace(/\D/g, "");

dados.set("cpf", cpf);
```

### Telefone

```javascript
const telefone = $("#telefone")
    .val()
    .replace(/\D/g, "");

dados.set("telefone", telefone);
```

### CNPJ

```javascript
const cnpj = $("#cnpj")
    .val()
    .replace(/\D/g, "");

dados.set("cnpj", cnpj);
```

### PIS

```javascript
const pis = $("#pis")
    .val()
    .replace(/\D/g, "");

dados.set("pis", pis);
```

### Registro do funcionário

```javascript
const regFunc = $("#regFunc")
    .val()
    .replace(/\D/g, "");

dados.set("regFunc", regFunc);
```

---

## 16. Enviar os dados com `fetch()`

Produto:

```javascript
const resposta = await fetch(
    "controllers/ProdutoController.php",
    {
        method: "POST",
        body: dados,
    }
);
```

Cliente:

```javascript
const resposta = await fetch(
    "controllers/ClienteController.php",
    {
        method: "POST",
        body: dados,
    }
);
```

Funcionário:

```javascript
const resposta = await fetch(
    "controllers/FuncionarioController.php",
    {
        method: "POST",
        body: dados,
    }
);
```

A resposta é convertida para JSON:

```javascript
const resultado = await resposta.json();
```

---

## 17. Tratar erros retornados pelo backend

O padrão atual é:

```javascript
if (!resposta.ok) {

    mensagem.className =
        "alert alert-danger mt-3";

    let conteudo =
        `<strong>${resultado.mensagem}</strong>`;

    if (resultado.erros) {

        conteudo += "<ul class='mb-0 mt-2'>";

        Object.entries(resultado.erros)
            .forEach(function ([campo, erros]) {

                erros.forEach(function (erro) {
                    conteudo += `<li>${erro}</li>`;
                });

            });

        conteudo += "</ul>";
    }

    mensagem.innerHTML = conteudo;

    return;
}
```

Assim, erros de vários campos podem ser exibidos.

---

## 18. Criar os Controllers

Arquivos:

```text
controllers/ProdutoController.php
controllers/ClienteController.php
controllers/FuncionarioController.php
```

Todos seguem o mesmo fluxo:

```text
Receber requisição
↓
Verificar POST
↓
Criar Validator
↓
Executar regras
↓
Verificar erros
↓
TODO: Model/Banco
↓
Retornar JSON
```

---

## 19. Verificar o método HTTP

```php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    http_response_code(405);

    echo json_encode([
        "sucesso" => false,
        "mensagem" =>
            "Método não permitido. Utilize uma requisição POST.",
        "dados" => null,
        "erros" => null
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    exit;
}
```

---

## 20. Carregar o Validator

```php
require __DIR__ . "/../libs/Validator.php";
```

Criar o objeto:

```php
$validator = new Validator($_POST);
```

Executar as regras:

```php
validarCadastro($validator);
```

---

## 21. Validar Produto no backend

### Nome

```php
$validator->required(
    "nome",
    "O nome do produto é obrigatório."
);

$validator->string(
    "nome",
    "O nome do produto deve ser um texto válido."
);

$validator->minLength(
    "nome",
    3,
    "O nome do produto deve conter no mínimo 3 caracteres."
);

$validator->maxLength(
    "nome",
    100,
    "O nome do produto deve conter no máximo 100 caracteres."
);
```

### Categoria

Valida:

```text
required
string
minLength 3
maxLength 100
```

### Preço

Valida:

```text
required
numeric
min 0.01
```

### Quantidade

Valida:

```text
required
integer
min 1
```

---

## 22. Validar Cliente no backend

### Nome

```text
required
string
minLength 3
maxLength 100
```

### CPF

O JavaScript remove a máscara antes do envio.

O backend espera:

```text
11 dígitos
```

Valida:

```text
required
string
minLength 11
maxLength 11
```

### E-mail

```text
required
email
```

### Telefone

O backend aceita:

```text
10 ou 11 dígitos
```

Valida:

```text
required
string
minLength 10
maxLength 11
```

---

## 23. Validar Funcionário no backend

### Nome

```text
required
string
minLength 3
maxLength 100
```

### CNPJ

Depois da remoção da máscara:

```text
14 dígitos
```

Valida:

```text
required
string
minLength 14
maxLength 14
```

### Registro

Depois da remoção da máscara:

```text
5 dígitos
```

Valida:

```text
required
string
minLength 5
maxLength 5
```

### PIS

Depois da remoção da máscara:

```text
11 dígitos
```

Valida:

```text
required
string
minLength 11
maxLength 11
```

---

## 24. Retornar erro de validação

```php
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
```

---

## 25. Ponto onde entrará o banco de dados

Nos três Controllers existe:

```php
// -------->>> TODO: Aqui será realizado o cadastro no banco de dados
```

Este será o ponto em que o Controller chamará o Model.

Futuramente:

```text
Controller
↓
Model
↓
Banco de Dados
```

---

## 26. Retornar sucesso

Produto:

```php
echo json_encode([
    "sucesso" => true,
    "mensagem" =>
        "Produto cadastrado com sucesso (controllerProduto).",
    "dados" => $validator->data(),
    "erros" => null
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
```

Cliente e Funcionário seguem o mesmo contrato.

> Quando o banco for implementado, é recomendável retirar os textos de teste `(controllerProduto)`, `(controllerCliente)` e `(controllerFuncionario)` das mensagens finais.

---

## 27. Contrato JSON padronizado

### Sucesso

```json
{
    "sucesso": true,
    "mensagem": "Produto cadastrado com sucesso.",
    "dados": {},
    "erros": null
}
```

### Erro

```json
{
    "sucesso": false,
    "mensagem": "Corrija os campos indicados.",
    "dados": null,
    "erros": {
        "nome": [
            "O nome do produto é obrigatório."
        ]
    }
}
```

O frontend pode sempre utilizar:

```javascript
resultado.sucesso;
resultado.mensagem;
resultado.dados;
resultado.erros;
```

---

# PARTE 2 — ENTENDENDO O PROJETO

# 28. O que é MVC?

MVC significa:

```text
Model
View
Controller
```

| Camada      | Responsabilidade                        |
| ----------- | --------------------------------------- |
| Model       | Manipula dados e acessa o banco         |
| View        | Interface exibida ao usuário            |
| Controller  | Controla a requisição e o processamento |

Fluxo conceitual:

```text
View
↓
Controller
↓
Model
↓
Banco
```

No projeto atual, View e Controller já estão implementados. A parte de Model/Banco ainda está preparada apenas estruturalmente.

---

# 29. Fluxo de navegação

```text
Usuário
↓
URL
↓
index.php
↓
routes.php
↓
View
```

Exemplo:

```text
index.php?page=clientes
↓
routes.php
↓
views/cliente.php
```

---

# 30. URL

Exemplo:

```text
http://localhost/projeto/index.php?page=produtos
```

| Parte            | Significado        |
| ---------------- | ------------------ |
| `localhost`      | Servidor local     |
| `projeto`        | Pasta do projeto   |
| `index.php`      | Arquivo de entrada |
| `?page=produtos` | Parâmetro da URL   |

---

# 31. GET

GET envia informações pela URL.

```php
$_GET["page"];
```

No projeto:

```php
$page = $_GET["page"] ?? "home";
```

O operador `??` significa:

> Use o valor da esquerda se ele existir; caso contrário, use o valor da direita.

---

# 32. `array_key_exists()`

Utilizado nas rotas:

```php
array_key_exists($page, $paginasValidas);
```

Verifica se uma chave existe no array.

Exemplo:

```php
$paginasValidas = [
    "home" => "views/home.php",
    "produtos" => "views/produto.php"
];
```

Se:

```php
$page = "produtos";
```

a chave existe.

---

# 33. `__DIR__`

`__DIR__` representa a pasta onde o arquivo PHP atual está localizado.

Exemplo:

```php
__DIR__ . "/views/produto.php";
```

É mais seguro do que depender da pasta atual do navegador ou do servidor.

---

# 34. `require`

Carrega outro arquivo PHP.

```php
require __DIR__ . "/routes.php";
```

Se o arquivo obrigatório não puder ser carregado, a execução é interrompida.

---

# 35. View

A View representa a interface.

No projeto:

```text
home.php
produto.php
cliente.php
funcionario.php
404.php
```

Ela trabalha principalmente com:

```text
HTML
Bootstrap
Bootstrap Icons
CSS
JavaScript
jQuery
```

---

# 36. Bootstrap

Framework CSS utilizado para facilitar a criação da interface.

Exemplos usados:

```text
container
row
col-md-4
col-md-6
form-control
form-label
input-group
input-group-text
btn
btn-primary
alert
card
shadow-sm
text-muted
d-none
mt-5
mb-3
w-100
```

---

# 37. Bootstrap Icons

Exemplo:

```html
<i class="bi bi-person"></i>
```

Ícones utilizados incluem pessoas, produtos, envelope, telefone, empresa e outros.

---

# 38. jQuery

Biblioteca JavaScript.

JavaScript:

```javascript
document.getElementById("nome");
```

jQuery:

```javascript
$("#nome");
```

No projeto ele é utilizado principalmente pelo Validation e Mask e para manipular os campos.

---

# 39. jQuery Validation

Plugin responsável pela validação no navegador.

Estrutura utilizada:

```javascript
$("#formProduto").validate({

    rules: {},

    messages: {},

    errorPlacement: function () {},

    highlight: function () {},

    unhighlight: function () {},

    submitHandler: async function () {}

});
```

---

# 40. jQuery Mask

Aplica uma máscara visual durante a digitação.

Exemplo:

```javascript
$("#cpf").mask("000.000.000-00");
```

A máscara:

- melhora a experiência do usuário;
- orienta o formato de preenchimento;
- não substitui a validação do backend.

---

# 41. FormData

Cria uma coleção com os dados do formulário:

```javascript
const dados = new FormData(formulario);
```

Consultar:

```javascript
dados.get("nome");
```

Alterar:

```javascript
dados.set("cpf", cpf);
```

---

# 42. `replace()` e expressão regular

Exemplo:

```javascript
$("#cpf").val().replace(/\D/g, "");
```

`\D` significa:

```text
qualquer caractere que NÃO seja número
```

`g` significa:

```text
procurar em todo o texto
```

Assim:

```text
123.456.789-00
```

vira:

```text
12345678900
```

---

# 43. Fetch

Envia a requisição sem recarregar a página:

```javascript
fetch("controllers/ProdutoController.php", {
    method: "POST",
    body: dados,
});
```

Fluxo:

```text
JavaScript
↓
POST
↓
Controller
```

---

# 44. `async` e `await`

A requisição ao servidor não é instantânea.

Por isso:

```javascript
submitHandler: async function (formulario) {

    const resposta = await fetch(...);

}
```

`await` aguarda a operação assíncrona terminar antes de continuar.

---

# 45. `try` e `catch`

Utilizados para tratar falhas na requisição:

```javascript
try {

    const resposta = await fetch(...);

} catch (erro) {

    console.error(erro);

}
```

O `catch` trata, por exemplo, falhas inesperadas de comunicação ou erros que impeçam a execução normal da requisição.

---

# 46. POST

Os dados dos formulários são enviados com:

```text
POST
```

No PHP:

```php
$_POST
```

Exemplo:

```php
$_POST["nome"];
```

---

# 47. Controller

Responsabilidades no projeto:

```text
Receber
↓
Verificar método
↓
Validar
↓
Processar
↓
Responder
```

O Controller não gera a interface visual do cadastro.

---

# 48. `header()` no Controller

```php
header(
    "Content-Type: application/json; charset=utf-8"
);
```

Informa que a resposta enviada pelo Controller será JSON em UTF-8.

---

# 49. Códigos HTTP utilizados

| Código | Significado no projeto         |
| ------ | ------------------------------ |
| `200`  | Operação realizada com sucesso |
| `404`  | Rota/página não encontrada     |
| `405`  | Método HTTP não permitido      |
| `422`  | Erro de validação dos dados    |

---

# 50. JSON

Formato utilizado para comunicação entre backend e frontend.

PHP:

```php
echo json_encode([
    "sucesso" => true,
    "mensagem" => "Cadastro realizado."
]);
```

JavaScript:

```javascript
const resultado = await resposta.json();
```

---

# 51. `JSON_UNESCAPED_UNICODE`

```php
JSON_UNESCAPED_UNICODE
```

Evita transformar caracteres como:

```text
á
ç
ã
é
```

em sequências Unicode pouco legíveis no JSON.

---

# 52. `JSON_PRETTY_PRINT`

```php
JSON_PRETTY_PRINT
```

Formata o JSON com indentação para facilitar a leitura durante o desenvolvimento.

---

# 53. Classe `Validator`

Arquivo:

```text
libs/Validator.php
```

Uso:

```php
$validator = new Validator($_POST);
```

A classe armazena:

```php
private $dados = [];
private $erros = [];
```

---

# 54. Métodos auxiliares do Validator

São métodos privados utilizados internamente:

```text
valor()
vazio()
adicionarErro()
ignorarSeVazio()
```

Eles não são chamados diretamente pelo Controller.

---

# 55. Validações disponíveis no Validator

A classe atual possui todas estas regras:

## `required()`

Campo obrigatório.

```php
$validator->required(
    "nome",
    "O nome é obrigatório."
);
```

## `string()`

Verifica se o valor é texto.

```php
$validator->string(
    "nome",
    "O nome deve ser um texto."
);
```

## `minLength()`

Quantidade mínima de caracteres.

```php
$validator->minLength(
    "nome",
    3,
    "O nome deve ter no mínimo 3 caracteres."
);
```

## `maxLength()`

Quantidade máxima de caracteres.

```php
$validator->maxLength(
    "nome",
    100,
    "O nome deve ter no máximo 100 caracteres."
);
```

## `numeric()`

Número inteiro ou decimal.

```php
$validator->numeric(
    "preco",
    "O preço deve ser numérico."
);
```

## `integer()`

Número inteiro.

```php
$validator->integer(
    "quantidade",
    "A quantidade deve ser inteira."
);
```

## `min()`

Valor mínimo.

```php
$validator->min(
    "quantidade",
    1,
    "O valor mínimo é 1."
);
```

## `max()`

Valor máximo.

```php
$validator->max(
    "quantidade",
    100,
    "O valor máximo é 100."
);
```

## `between()`

Valor entre dois limites.

```php
$validator->between(
    "idade",
    18,
    65,
    "A idade deve estar entre 18 e 65."
);
```

## `email()`

E-mail válido.

```php
$validator->email(
    "email",
    "Informe um e-mail válido."
);
```

## `url()`

URL válida.

```php
$validator->url(
    "site",
    "Informe uma URL válida."
);
```

## `regex()`

Validação personalizada por expressão regular.

```php
$validator->regex(
    "telefone",
    "/^[0-9]{10,11}$/",
    "Informe um telefone válido."
);
```

## `date()`

Data válida no formato:

```text
dia/mês/ano
```

Exemplo:

```php
$validator->date(
    "dataNascimento",
    "Informe uma data válida."
);
```

## `alpha()`

Letras e espaços.

```php
$validator->alpha(
    "nome",
    "Utilize apenas letras."
);
```

## `alphaNumeric()`

Letras, números e espaços.

```php
$validator->alphaNumeric(
    "codigo",
    "Utilize apenas letras e números."
);
```

## `in()`

Valor pertencente a uma lista.

```php
$validator->in(
    "categoria",
    ["Roupa", "Alimento", "Eletrônico"],
    "Categoria inválida."
);
```

## `boolean()`

Valores booleanos aceitos pela classe.

```php
$validator->boolean(
    "ativo",
    "Informe um valor válido."
);
```

## `confirmed()`

Compara um campo com seu campo de confirmação.

```php
$validator->confirmed(
    "senha",
    null,
    "As senhas não conferem."
);
```

Por padrão:

```text
senha
senha_confirmation
```

## `same()`

Compara dois campos.

```php
$validator->same(
    "email",
    "confirmarEmail",
    "Os e-mails devem ser iguais."
);
```

---

# 56. Métodos de resultado do Validator

## `fails()`

Retorna verdadeiro quando existem erros.

```php
if ($validator->fails()) {
    // existem erros
}
```

## `passes()`

Retorna verdadeiro quando não existem erros.

```php
if ($validator->passes()) {
    // dados válidos
}
```

## `errors()`

Retorna todos os erros:

```php
$validator->errors();
```

## `first()`

Retorna os erros de um campo:

```php
$validator->first("nome");
```

## `data()`

Retorna os dados recebidos:

```php
$validator->data();
```

---

# 57. Por que validar duas vezes?

O projeto valida:

```text
Frontend
+
Backend
```

### Frontend

jQuery Validation.

Objetivo:

- ajudar o usuário;
- mostrar erros rapidamente;
- evitar requisições desnecessárias.

### Backend

`Validator.php`.

Objetivo:

- não confiar somente no navegador;
- garantir que os dados recebidos sejam verificados no servidor.

Fluxo:

```text
Usuário
↓
jQuery Validation
↓
Fetch
↓
Controller
↓
Validator PHP
```

---

# 58. CSS

Arquivos existentes:

```text
404.css
cliente.css
funcionario.css
produto.css
```

No estado atual:

- `produto.css` está vazio;
- `cliente.css` está vazio;
- `funcionario.css` está vazio;
- `404.css` possui estilos.

Isso é aceitável durante a construção didática. Os arquivos vazios deixam a estrutura preparada para futuras personalizações.

---

# 59. Model

A pasta existe:

```text
models/
```

Atualmente contém apenas:

```text
exemploModel.php
```

e ainda não há implementação de acesso ao banco.

Quando implementado, o Model deverá concentrar operações como:

```text
salvar
listar
buscar
editar
excluir
```

---

# 60. Config

A pasta:

```text
config/
```

está preparada para configurações futuras.

Exemplo:

```text
config/exemploConfig.php
```

Futuramente poderá conter a configuração/conexão com o banco de dados.

---

# 61. Layout

A pasta:

```text
layout/
```

também está preparada para evolução.

Atualmente o cabeçalho e o rodapé estão diretamente no:

```text
index.php
```

Futuramente eles podem ser separados, por exemplo:

```text
layout/header.php
layout/footer.php
```

Isso não é necessário para o estágio atual do projeto.

---

# 62. Helpers e conversões

Ainda não existe `helpers.php` no projeto atual.

Caso seja necessário transformar dados sem misturar essa responsabilidade com o Validator, poderá ser criado:

```text
libs/helpers.php
```

Exemplo futuro para data:

```php
function dataParaBanco($data)
{
    $partes = explode("/", $data);

    if (count($partes) !== 3) {
        return null;
    }

    $dia = $partes[0];
    $mes = $partes[1];
    $ano = $partes[2];

    return "$ano-$mes-$dia";
}
```

Entrada:

```text
25/12/2026
```

Saída:

```text
2026-12-25
```

O princípio é:

```text
Validator
→ valida

Helper
→ transforma
```

---

# 63. Padronização de nomes

## Classes e Controllers PHP

PascalCase:

```text
Validator.php
ProdutoController.php
ClienteController.php
FuncionarioController.php
```

## Views

Minúsculo:

```text
home.php
produto.php
cliente.php
funcionario.php
404.php
```

## JavaScript

Minúsculo:

```text
produto.js
cliente.js
funcionario.js
404.js
```

## CSS

Minúsculo:

```text
produto.css
cliente.css
funcionario.css
404.css
```

---

# 64. Relação entre os arquivos de cada módulo

## Produto

```text
views/produto.php
↓
assets/js/produto.js
↓
controllers/ProdutoController.php
↓
futuro: models/Produto.php
```

## Cliente

```text
views/cliente.php
↓
assets/js/cliente.js
↓
controllers/ClienteController.php
↓
futuro: models/Cliente.php
```

## Funcionário

```text
views/funcionario.php
↓
assets/js/funcionario.js
↓
controllers/FuncionarioController.php
↓
futuro: models/Funcionario.php
```

---

# 65. Checklist para criar um novo cadastro

Exemplo: futuramente criar `Pedido`.

```text
1. Criar views/pedido.php
2. Adicionar "pedidos" em routes.php
3. Adicionar link no menu
4. Criar assets/css/pedido.css
5. Criar assets/js/pedido.js
6. Criar o formulário
7. Aplicar máscaras, se necessário
8. Criar validações frontend
9. Criar FormData
10. Preparar os dados
11. Criar controllers/PedidoController.php
12. Criar validações backend
13. Manter o contrato JSON
14. Criar futuramente models/Pedido.php
15. Salvar no banco
16. Testar erros e sucesso
```

---

# 66. Pontos observados na revisão do projeto

A estrutura geral está coerente e os três módulos de cadastro seguem um padrão muito parecido.

### Já está padronizado

- Home como página inicial;
- rotas em um array;
- Views em minúsculo;
- Controllers em PascalCase;
- formulários com Bootstrap;
- `invalid-feedback` e `valid-feedback`;
- scripts separados por módulo;
- máscaras;
- remoção das máscaras antes do backend;
- Controllers usando `Validator`;
- código HTTP `405` para método incorreto;
- código HTTP `422` para validação;
- código HTTP `200` para sucesso;
- contrato JSON com `sucesso`, `mensagem`, `dados` e `erros`;
- tratamento de erros do backend no JavaScript;
- reset das classes `is-valid` e `is-invalid`.


# 67. O que ainda falta implementar

Para completar o MVC com persistência real:

```text
1. Configurar o banco de dados
2. Criar a conexão
3. Criar tabelas
4. Criar Models
5. Fazer o Controller chamar o Model
6. Inserir dados
7. Tratar erros do banco
8. Listar registros
9. Buscar registros
10. Editar registros
11. Excluir registros
```

Neste momento, o projeto já demonstra com clareza:

```text
View
+
JavaScript
+
Rotas
+
Controller
+
Validação frontend
+
Validação backend
+
JSON
```

O próximo grande passo é:

```text
Model
+
Banco de Dados
```

---

# 68. Resumo final

O principal aprendizado do projeto é compreender o caminho da informação.

```text
Usuário preenche
↓
View apresenta
↓
jQuery valida
↓
JavaScript prepara
↓
Fetch envia
↓
Controller recebe
↓
Validator valida novamente
↓
Controller responde JSON
↓
JavaScript interpreta
↓
View mostra o resultado
```

Quando o Model for implementado:

```text
Controller
↓
Model
↓
Banco de Dados
```

Essa separação de responsabilidades ajuda a tornar o sistema mais organizado, previsível e fácil de manter, além de preparar o aluno para trabalhar futuramente com frameworks PHP que utilizam conceitos semelhantes, como Laravel e CodeIgniter.
