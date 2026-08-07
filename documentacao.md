# Projeto MVC com PHP, jQuery e Bootstrap

> Documentação atualizada com base na versão atual do projeto.

------------------------------------------------------------------------

# PARTE 1 --- PASSO A PASSO DO QUE FOI CONSTRUÍDO

## 1. Objetivo do projeto

O projeto foi criado para estudar, de forma didática, a organização de
uma aplicação PHP inspirada no padrão MVC.

Até o momento foram implementados:

-   Landing page pública;
-   Página de login visual;
-   Home da área administrativa;
-   Rotas utilizando `$_GET`;
-   Página 404;
-   Cadastro de produtos;
-   Cadastro de clientes;
-   Cadastro de funcionários;
-   Bootstrap e Bootstrap Icons;
-   jQuery;
-   jQuery Validation;
-   jQuery Mask;
-   `FormData`;
-   `fetch()`;
-   Controllers PHP;
-   Respostas JSON padronizadas;
-   Classe `Validator`;
-   Helpers para PHP;
-   Helpers para JavaScript.

> O banco de dados, os Models reais e a autenticação com sessão ainda
> não foram implementados.

------------------------------------------------------------------------

## 2. Estrutura atual do projeto

``` text
a_projeto_mvc_completo/
│
├── assets/
│   ├── css/
│   │   ├── 404.css
│   │   ├── cliente.css
│   │   ├── funcionario.css
│   │   ├── login.css
│   │   └── produto.css
│   │
│   ├── img/
│   │   └── erro-404.png
│   │
│   └── js/
│       ├── 404.js
│       ├── cliente.js
│       ├── funcionario.js
│       ├── login.js
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
│   ├── js/
│   │   └── helpers.js
│   │
│   └── php/
│       ├── helpers.php
│       └── Validator.php
│
├── models/
│   └── exemploModel.php
│
├── views/
│   ├── 404.php
│   ├── cliente.php
│   ├── funcionario.php
│   ├── home.php
│   ├── landing.php
│   ├── login.php
│   └── produto.php
│
├── documentacao.md
├── index.php
└── routes.php
```

### Responsabilidade das principais pastas

  Pasta            Responsabilidade
  ---------------- ------------------------------------------------
  `assets/css/`    CSS das páginas
  `assets/img/`    Imagens do projeto
  `assets/js/`     JavaScript específico das páginas
  `controllers/`   Receber, validar e processar requisições
  `libs/php/`      Classes e funções PHP reutilizáveis
  `libs/js/`       Funções JavaScript reutilizáveis
  `models/`        Futuro acesso ao banco de dados
  `views/`         Interfaces exibidas ao usuário
  `config/`        Futuras configurações
  `layout/`        Estrutura preparada para layouts reutilizáveis

------------------------------------------------------------------------

## 3. Fluxo atual de navegação

A primeira página do projeto agora é a **Landing Page**.

``` text
index.php
   ↓
landing.php
   ↓
login.php
   ↓
home.php
   ↓
Produtos / Clientes / Funcionários
```

No estado atual, o Login é apenas visual. O botão **Entrar** direciona
diretamente para:

``` text
index.php?page=home
```

Ainda não existe autenticação real.

------------------------------------------------------------------------

## 4. `index.php`

O `index.php` continua sendo a porta de entrada da aplicação.

A página padrão é:

``` php
$page = $_GET["page"] ?? "landing";
```

Portanto:

``` text
index.php
```

abre a Landing Page.

### Páginas independentes

Atualmente existem duas páginas com HTML próprio:

``` php
$paginasIndependentes = [
    "landing" => __DIR__ . "/views/landing.php",
    "login" => __DIR__ . "/views/login.php",
];
```

O `index.php` verifica:

``` php
if (array_key_exists($page, $paginasIndependentes)) {
    require $paginasIndependentes[$page];
    exit;
}
```

O `exit` é importante porque impede que o header e o footer da área
administrativa sejam carregados depois da Landing ou do Login.

### Área administrativa

As demais páginas utilizam o layout do próprio `index.php`:

``` text
Header
↓
Menu
↓
routes.php
↓
View
↓
Footer
```

O menu atual possui:

-   Produtos;
-   Clientes;
-   Funcionários;
-   Sair.

O título **Sistema de Cadastros** direciona para:

``` text
index.php?page=home
```

O link **Sair**, por enquanto, apenas retorna para:

``` text
index.php?page=landing
```

Como ainda não existe sessão, ele não realiza logout real.

------------------------------------------------------------------------

## 5. Landing Page

Arquivo:

``` text
views/landing.php
```

A Landing Page é totalmente independente e possui:

-   `<!DOCTYPE html>`;
-   `<html>`;
-   `<head>`;
-   Bootstrap;
-   Bootstrap Icons;
-   header próprio;
-   apresentação do sistema;
-   cards de recursos;
-   botões para Login;
-   footer próprio.

Os botões utilizam:

``` html
<a href="index.php?page=login">
    Entrar
</a>
```

A Landing apresenta os módulos:

``` text
Produtos
Clientes
Funcionários
```

------------------------------------------------------------------------

## 6. Página de Login

Arquivo:

``` text
views/login.php
```

Também é uma página independente.

Possui:

-   campo de e-mail;
-   campo de senha;
-   Bootstrap;
-   Bootstrap Icons;
-   `login.css`;
-   jQuery;
-   jQuery Validation;
-   `helpers.js`;
-   `login.js`.

### Estado atual do botão Entrar

O botão de envio foi temporariamente comentado:

``` html
<!--
<button type="submit">
    Entrar
</button>
-->
```

E foi colocado um link:

``` html
<a href="index.php?page=home"
   class="btn btn-primary w-100">
    Entrar
</a>
```

Assim, neste momento:

``` text
Login
↓
clicar em Entrar
↓
Home
```

> Como o botão atual é um `<a>`, ele não envia o formulário e não
> autentica o usuário. Isso é proposital nesta etapa.

O arquivo `login.js` já está preparado com validações de e-mail e senha
para uma etapa futura de autenticação.

------------------------------------------------------------------------

## 7. Home da área administrativa

Arquivo:

``` text
views/home.php
```

É a primeira tela interna do sistema.

A Home permite acessar os módulos:

``` text
Produtos
Clientes
Funcionários
```

Diferente da Landing e do Login, ela utiliza:

``` text
Header do index.php
+
Footer do index.php
```

------------------------------------------------------------------------

## 8. Rotas

Arquivo:

``` text
routes.php
```

As rotas cadastradas atualmente são:

``` php
$paginasValidas = [
    "landing" => __DIR__ . "/views/landing.php",
    "home" => __DIR__ . "/views/home.php",
    "produtos" => __DIR__ . "/views/produto.php",
    "clientes" => __DIR__ . "/views/cliente.php",
    "funcionarios" => __DIR__ . "/views/funcionario.php",
];
```

A página é capturada com:

``` php
$page = $_GET["page"] ?? "landing";
```

A verificação utiliza:

``` php
array_key_exists($page, $paginasValidas)
```

Se a rota existir:

``` php
require $paginasValidas[$page];
```

Caso contrário:

``` php
http_response_code(404);
require __DIR__ . "/views/404.php";
```

### Observação sobre Landing e Login

A Landing e o Login são tratados antes pelo `index.php`.

Por isso, o Login não precisa estar em `$paginasValidas` de `routes.php`
para funcionar.

------------------------------------------------------------------------

## 9. Página 404

Arquivo:

``` text
views/404.php
```

Quando uma rota não existe:

``` php
http_response_code(404);
```

é executado e a View 404 é carregada.

A página possui:

-   `404.css`;
-   imagem `erro-404.png`;
-   mensagem de página não encontrada;
-   botão para Produtos;
-   botão para a Página Inicial.

No estado atual, a 404 **não é uma página HTML independente**. Ela é
carregada pelo `routes.php` dentro do `<main>` do layout administrativo.

------------------------------------------------------------------------

## 10. Views dos cadastros

### Produto

Arquivo:

``` text
views/produto.php
```

Campos:

``` text
nome
categoria
preco
quantidade
```

### Cliente

Arquivo:

``` text
views/cliente.php
```

Campos:

``` text
nome
cpf
email
telefone
```

### Funcionário

Arquivo:

``` text
views/funcionario.php
```

Campos:

``` text
nome
cnpj
regFunc
pis
```

Os formulários seguem uma estrutura visual semelhante com Bootstrap:

``` html
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

------------------------------------------------------------------------

## 11. Bibliotecas do frontend

O projeto utiliza:

### Bootstrap

Responsável pela estrutura visual e responsividade.

### Bootstrap Icons

Responsável pelos ícones.

### jQuery

Facilita manipulações no frontend e é necessário para os plugins
utilizados.

### jQuery Validation

Responsável pelas validações no navegador.

### jQuery Mask

Responsável pelas máscaras de digitação.

------------------------------------------------------------------------

## 12. Máscaras

### Produto

``` javascript
$("#preco").mask("000.000.000,00", {
  reverse: true,
});

$("#quantidade").mask("000000");
```

### Cliente

``` javascript
$("#telefone").mask("(00) 00000-0000");
$("#cpf").mask("000.000.000-00");
```

### Funcionário

``` javascript
$("#cnpj").mask("00.000.000/0000-00");
$("#pis").mask("000.00000.00-0");
$("#regFunc").mask("0-0000");
```

A máscara melhora a digitação, mas não substitui a validação.

------------------------------------------------------------------------

## 13. jQuery Validation

Estrutura utilizada:

``` javascript
$("#formProduto").validate({

  rules: {},

  messages: {},

  errorPlacement: function (error, element) {},

  highlight: function (element) {},

  unhighlight: function (element) {},

  submitHandler: async function (formulario) {}

});
```

### `rules`

Define as regras.

### `messages`

Define as mensagens em português.

### `errorPlacement`

Define onde a mensagem será exibida.

### `highlight`

Adiciona:

``` text
is-invalid
```

### `unhighlight`

Adiciona:

``` text
is-valid
```

### `submitHandler`

É executado quando o formulário passa pelas validações.

------------------------------------------------------------------------

## 14. FormData

Os dados são capturados com:

``` javascript
const dados = new FormData(formulario);
```

Consultar:

``` javascript
dados.get("nome");
```

Alterar:

``` javascript
dados.set("cpf", cpf);
```

------------------------------------------------------------------------

## 15. Preparação dos dados

Alguns valores são exibidos formatados para o usuário, mas enviados sem
máscara.

Exemplo:

``` text
CPF na tela:
123.456.789-00

CPF enviado:
12345678900
```

Produto também converte:

``` text
1.234,56
```

para:

``` text
1234.56
```

------------------------------------------------------------------------

## 16. `fetch()`

Os cadastros são enviados sem recarregar a página.

Produto:

``` javascript
const resposta = await fetch(
  "controllers/ProdutoController.php",
  {
    method: "POST",
    body: dados,
  }
);
```

Depois:

``` javascript
const resultado = await resposta.json();
```

Cliente e Funcionário seguem o mesmo padrão.

------------------------------------------------------------------------

## 17. Controllers

Arquivos:

``` text
controllers/ProdutoController.php
controllers/ClienteController.php
controllers/FuncionarioController.php
```

Fluxo atual:

``` text
Recebe requisição
↓
Verifica POST
↓
Cria Validator
↓
Executa regras
↓
Verifica erros
↓
TODO: banco de dados
↓
Retorna JSON
```

------------------------------------------------------------------------

## 18. Validação do método HTTP

Os Controllers aceitam POST:

``` php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    http_response_code(405);

    echo json_encode([
        "sucesso" => false,
        "mensagem" =>
            "Método não permitido. Utilize uma requisição POST.",
        "dados" => null,
        "erros" => null
    ]);

    exit;
}
```

------------------------------------------------------------------------

## 19. Classe Validator

Local atual:

``` text
libs/php/Validator.php
```

Carregamento:

``` php
require __DIR__ . "/../libs/php/Validator.php";
```

Uso:

``` php
$validator = new Validator($_POST);
```

Depois:

``` php
validarCadastro($validator);
```

Se houver erros:

``` php
if ($validator->fails()) {
    // retorna erro 422
}
```

------------------------------------------------------------------------

## 20. Validações disponíveis no Validator

A classe possui regras reutilizáveis.

### `required()`

``` php
$validator->required(
    "nome",
    "O nome é obrigatório."
);
```

### `string()`

``` php
$validator->string(
    "nome",
    "O nome deve ser um texto."
);
```

### `minLength()`

``` php
$validator->minLength(
    "nome",
    3,
    "O nome deve ter no mínimo 3 caracteres."
);
```

### `maxLength()`

``` php
$validator->maxLength(
    "nome",
    100,
    "O nome deve ter no máximo 100 caracteres."
);
```

### `numeric()`

``` php
$validator->numeric(
    "preco",
    "Informe um número válido."
);
```

### `integer()`

``` php
$validator->integer(
    "quantidade",
    "Informe um número inteiro."
);
```

### `min()`

``` php
$validator->min(
    "quantidade",
    1,
    "O valor mínimo é 1."
);
```

### `max()`

``` php
$validator->max(
    "quantidade",
    100,
    "O valor máximo é 100."
);
```

### `between()`

``` php
$validator->between(
    "idade",
    18,
    65,
    "A idade deve estar entre 18 e 65."
);
```

### `email()`

``` php
$validator->email(
    "email",
    "Informe um e-mail válido."
);
```

### `url()`

``` php
$validator->url(
    "site",
    "Informe uma URL válida."
);
```

### `regex()`

``` php
$validator->regex(
    "telefone",
    "/^[0-9]{10,11}$/",
    "Informe um telefone válido."
);
```

### `date()`

Formato esperado:

``` text
dia/mês/ano
```

Uso:

``` php
$validator->date(
    "dataNascimento",
    "Informe uma data válida."
);
```

### `alpha()`

``` php
$validator->alpha(
    "nome",
    "Utilize apenas letras."
);
```

### `alphaNumeric()`

``` php
$validator->alphaNumeric(
    "codigo",
    "Utilize apenas letras e números."
);
```

### `in()`

``` php
$validator->in(
    "categoria",
    ["Roupa", "Alimento", "Eletrônico"],
    "Categoria inválida."
);
```

### `boolean()`

``` php
$validator->boolean(
    "ativo",
    "Informe um valor válido."
);
```

### `confirmed()`

``` php
$validator->confirmed(
    "senha",
    null,
    "As senhas não conferem."
);
```

### `same()`

``` php
$validator->same(
    "email",
    "confirmarEmail",
    "Os e-mails devem ser iguais."
);
```

------------------------------------------------------------------------

## 21. Métodos de resultado do Validator

### `fails()`

``` php
$validator->fails();
```

Retorna `true` se houver erros.

### `passes()`

``` php
$validator->passes();
```

Retorna `true` se não houver erros.

### `errors()`

``` php
$validator->errors();
```

Retorna os erros.

### `first()`

``` php
$validator->first("nome");
```

Retorna os erros associados ao campo informado.

### `data()`

``` php
$validator->data();
```

Retorna os dados recebidos.

------------------------------------------------------------------------

## 22. Helpers PHP

Foi criada uma área própria:

``` text
libs/php/helpers.php
```

Helpers são funções genéricas e reutilizáveis.

### `somenteNumeros()`

``` php
somenteNumeros("123.456.789-00");
```

Retorna:

``` text
12345678900
```

### `dataParaBanco()`

``` php
dataParaBanco("25/12/2026");
```

Retorna:

``` text
2026-12-25
```

### `dataParaBrasil()`

``` php
dataParaBrasil("2026-12-25");
```

Retorna:

``` text
25/12/2026
```

### `precoParaBanco()`

``` php
precoParaBanco("1.234,56");
```

Retorna:

``` text
1234.56
```

### `precoParaBrasil()`

``` php
precoParaBrasil(1234.56);
```

Retorna:

``` text
1.234,56
```

### `limparTexto()`

``` php
limparTexto("   Maria Silva   ");
```

Retorna:

``` text
Maria Silva
```

Para carregar:

``` php
require __DIR__ . "/../libs/php/helpers.php";
```

> Os helpers PHP já foram criados, mas os Controllers atuais ainda não
> os utilizam.

------------------------------------------------------------------------

## 23. Helpers JavaScript

Arquivo:

``` text
libs/js/helpers.js
```

### `somenteNumeros()`

``` javascript
somenteNumeros("123.456.789-00");
```

Retorna:

``` text
12345678900
```

### `precoParaBackend()`

``` javascript
precoParaBackend("1.234,56");
```

Retorna:

``` text
1234.56
```

### `mostrarMensagem()`

``` javascript
mostrarMensagem(
  mensagem,
  "success",
  "Cadastro realizado com sucesso."
);
```

### `limparValidacao()`

``` javascript
limparValidacao(formulario);
```

Remove:

``` text
is-valid
is-invalid
```

> O arquivo de helpers JavaScript já existe. Na versão atual, ele é
> carregado pela página de Login, mas os scripts de Produto, Cliente e
> Funcionário ainda mantêm suas conversões diretamente nos próprios
> arquivos.

------------------------------------------------------------------------

## 24. Contrato JSON padronizado

Os Controllers seguem o mesmo formato.

### Sucesso

``` json
{
    "sucesso": true,
    "mensagem": "Cadastro realizado com sucesso.",
    "dados": {},
    "erros": null
}
```

### Erro

``` json
{
    "sucesso": false,
    "mensagem": "Corrija os campos indicados.",
    "dados": null,
    "erros": {
        "nome": [
            "O nome é obrigatório."
        ]
    }
}
```

Assim o frontend pode trabalhar sempre com:

``` javascript
resultado.sucesso;
resultado.mensagem;
resultado.dados;
resultado.erros;
```

------------------------------------------------------------------------

## 25. Códigos HTTP utilizados

  Código   Significado
  -------- -----------------------------------
  `200`    Requisição processada com sucesso
  `404`    Página não encontrada
  `405`    Método HTTP não permitido
  `422`    Dados não passaram pela validação

------------------------------------------------------------------------

# PARTE 2 --- ENTENDENDO OS CONCEITOS

## 26. MVC

MVC significa:

``` text
Model
View
Controller
```

### View

Exibe a interface.

No projeto:

``` text
landing.php
login.php
home.php
produto.php
cliente.php
funcionario.php
404.php
```

### Controller

Recebe e processa requisições.

No projeto:

``` text
ProdutoController.php
ClienteController.php
FuncionarioController.php
```

### Model

Será responsável pelo acesso ao banco.

A pasta existe, mas os Models reais ainda não foram implementados.

------------------------------------------------------------------------

## 27. GET

GET é utilizado nas rotas.

Exemplo:

``` text
index.php?page=produtos
```

No PHP:

``` php
$_GET["page"];
```

------------------------------------------------------------------------

## 28. POST

POST é utilizado para enviar os formulários aos Controllers.

No PHP:

``` php
$_POST
```

Exemplo:

``` php
$_POST["nome"];
```

------------------------------------------------------------------------

## 29. `array_key_exists()`

Verifica se uma chave existe em um array.

``` php
array_key_exists($page, $paginasValidas);
```

É utilizado tanto na identificação das páginas independentes quanto nas
rotas.

------------------------------------------------------------------------

## 30. `__DIR__`

Representa o diretório do arquivo PHP atual.

``` php
__DIR__ . "/views/home.php";
```

Ajuda a criar caminhos seguros para os arquivos do projeto.

------------------------------------------------------------------------

## 31. `require`

Carrega outro arquivo PHP.

``` php
require __DIR__ . "/routes.php";
```

Também é utilizado para carregar:

``` text
Views
Validator
Helpers PHP
```

------------------------------------------------------------------------

## 32. JSON

JSON é utilizado para comunicação entre JavaScript e Controller.

PHP:

``` php
echo json_encode([
    "sucesso" => true,
    "mensagem" => "Cadastro realizado."
]);
```

JavaScript:

``` javascript
const resultado = await resposta.json();
```

------------------------------------------------------------------------

## 33. `JSON_UNESCAPED_UNICODE`

Mantém caracteres como:

``` text
á
é
ç
ã
```

mais legíveis no JSON.

------------------------------------------------------------------------

## 34. `JSON_PRETTY_PRINT`

Formata o JSON com indentação, facilitando a leitura durante o
desenvolvimento.

------------------------------------------------------------------------

## 35. `async` e `await`

Exemplo:

``` javascript
submitHandler: async function (formulario) {

    const resposta = await fetch(...);

}
```

O `await` aguarda a resposta da operação assíncrona.

------------------------------------------------------------------------

## 36. `try` e `catch`

Exemplo:

``` javascript
try {

    const resposta = await fetch(...);

} catch (erro) {

    console.error(erro);

}
```

É utilizado para tratar falhas durante a execução da requisição.

------------------------------------------------------------------------

## 37. Por que validar no frontend e no backend?

### Frontend

``` text
jQuery Validation
```

Ajuda o usuário e evita envios desnecessários.

### Backend

``` text
Validator.php
```

Garante que o servidor valide os dados recebidos.

Fluxo:

``` text
Usuário
↓
jQuery Validation
↓
FormData
↓
Fetch
↓
Controller
↓
Validator PHP
```

A validação do frontend não substitui a validação do backend.

------------------------------------------------------------------------

# PARTE 3 --- FLUXOS DO PROJETO

## 38. Fluxo público atual

``` text
Usuário
↓
index.php
↓
Landing Page
↓
Login
↓
Entrar
↓
Home administrativa
```

Neste momento não existe verificação de usuário e senha.

------------------------------------------------------------------------

## 39. Fluxo dos cadastros

``` text
Usuário
↓
View
↓
Formulário
↓
jQuery Validation
↓
jQuery Mask
↓
FormData
↓
Preparação dos valores
↓
Fetch
↓
POST
↓
Controller
↓
Validator
↓
JSON
↓
JavaScript
↓
Mensagem na View
```

------------------------------------------------------------------------

## 40. Fluxo futuro com banco

``` text
View
↓
JavaScript
↓
Controller
↓
Validator
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
```

------------------------------------------------------------------------

## 41. Fluxo futuro de autenticação

A estrutura atual já prepara o projeto para futuramente implementar:

``` text
Login
↓
LoginController
↓
Validação
↓
Busca do usuário no banco
↓
Verificação da senha
↓
$_SESSION
↓
Área protegida
```

Nesse momento o botão `<a>` do Login poderá voltar a ser um botão:

``` html
<button type="submit">
    Entrar
</button>
```

------------------------------------------------------------------------

# PARTE 4 --- PADRONIZAÇÃO DO PROJETO

## 42. Nomes dos arquivos

### Classes e Controllers

PascalCase:

``` text
Validator.php
ProdutoController.php
ClienteController.php
FuncionarioController.php
```

### Views

Minúsculas:

``` text
landing.php
login.php
home.php
produto.php
cliente.php
funcionario.php
404.php
```

### JavaScript

Minúsculo:

``` text
produto.js
cliente.js
funcionario.js
login.js
helpers.js
```

### CSS

Minúsculo:

``` text
produto.css
cliente.css
funcionario.css
login.css
404.css
```

------------------------------------------------------------------------

## 43. Separação de responsabilidades

``` text
Validator.php
→ valida dados no backend

helpers.php
→ funções PHP reutilizáveis

helpers.js
→ funções JavaScript reutilizáveis

produto.js / cliente.js / funcionario.js
→ comportamento específico de cada tela

Controller
→ recebe, valida, processa e responde

Model
→ futuramente acessará o banco

View
→ apresenta a interface
```

------------------------------------------------------------------------

# PARTE 5 --- ESTADO ATUAL E PRÓXIMAS ETAPAS

## 44. O que já está pronto

-   Estrutura de pastas;
-   Landing Page;
-   Login visual;
-   Home administrativa;
-   Rotas;
-   Página 404;
-   Views dos três cadastros;
-   Bootstrap;
-   jQuery;
-   Validation;
-   Mask;
-   JavaScript dos cadastros;
-   Controllers;
-   Validator;
-   Helpers PHP;
-   Helpers JavaScript;
-   Contrato JSON padronizado;
-   Tratamento de erros de validação.

------------------------------------------------------------------------

## 45. O que ainda não está implementado

-   Autenticação real;
-   `LoginController.php`;
-   `$_SESSION`;
-   Logout real;
-   Proteção das rotas administrativas;
-   Banco de dados;
-   Conexão com banco;
-   Models reais;
-   Persistência dos cadastros;
-   Listagem;
-   Edição;
-   Exclusão.

------------------------------------------------------------------------

