<?php

/*
|--------------------------------------------------------------------------
| CLASSE VALIDATOR
|--------------------------------------------------------------------------
|
| Esta classe recebe os dados de um formulário e verifica se eles são válidos.
|
| Exemplo:
|
| $validator = new Validator($_POST);
|
| $validator
|     ->required("nome")
|     ->email("email");
|
| if ($validator->fails()) {
|     print_r($validator->errors());
| }
|
*/

class Validator
{
    /*
    |--------------------------------------------------------------------------
    | PROPRIEDADES
    |--------------------------------------------------------------------------
    */

    // Guarda os dados recebidos do formulário.
    private $dados = [];

    // Guarda as mensagens de erro encontradas.
    private $erros = [];


    /*
    |--------------------------------------------------------------------------
    | CONSTRUTOR
    |--------------------------------------------------------------------------
    |
    | O construtor é executado quando usamos:
    |
    | new Validator($_POST);
    |
    */

    public function __construct($dados)
    {
        $this->dados = $dados;
    }


    /*
    |--------------------------------------------------------------------------
    | MÉTODOS AUXILIARES
    |--------------------------------------------------------------------------
    */

    // Retorna o valor de um campo.
    private function valor($campo)
    {
        // Caso o campo não exista, retorna uma string vazia.
        return $this->dados[$campo] ?? "";
    }


    // Verifica se um campo está vazio.
    private function vazio($campo)
    {
        $valor = $this->valor($campo);

        // Se for texto, remove espaços antes de verificar.
        if (is_string($valor)) {
            return trim($valor) === "";
        }

        // Para outros tipos, utiliza empty.
        return empty($valor) && $valor !== 0 && $valor !== "0";
    }


    // Adiciona uma nova mensagem ao array de erros.
    private function adicionarErro($campo, $mensagem)
    {
        // Se o campo ainda não possui erros,
        // cria um array vazio para ele.
        if (!isset($this->erros[$campo])) {
            $this->erros[$campo] = [];
        }

        // Adiciona a nova mensagem ao final do array.
        $this->erros[$campo][] = $mensagem;
    }


    // Campos opcionais vazios não precisam ser validados.
    //
    // Exemplo:
    // O site não é obrigatório.
    // Se o usuário não preencher, não devemos mostrar "URL inválida".
    private function ignorarSeVazio($campo)
    {
        return $this->vazio($campo);
    }


    /*
    |--------------------------------------------------------------------------
    | 1. CAMPO OBRIGATÓRIO
    |--------------------------------------------------------------------------
    */

    public function required($campo, $mensagem = null)
    {
        if ($this->vazio($campo)) {
            $this->adicionarErro(
                $campo,
                $mensagem ?? "O campo $campo é obrigatório."
            );
        }

        // Retorna a própria classe.
        // Isso permite encadear os métodos:
        // ->required("nome")->minLength("nome", 3)
        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 2. TEXTO
    |--------------------------------------------------------------------------
    */

    public function string($campo, $mensagem = null)
    {
        if ($this->ignorarSeVazio($campo)) {
            return $this;
        }

        if (!is_string($this->valor($campo))) {
            $this->adicionarErro(
                $campo,
                $mensagem ?? "O campo $campo deve ser um texto."
            );
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 3. NÚMERO
    |--------------------------------------------------------------------------
    */

    public function numeric($campo, $mensagem = null)
    {
        if ($this->ignorarSeVazio($campo)) {
            return $this;
        }

        if (!is_numeric($this->valor($campo))) {
            $this->adicionarErro(
                $campo,
                $mensagem ?? "O campo $campo deve ser numérico."
            );
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 4. NÚMERO INTEIRO
    |--------------------------------------------------------------------------
    */

    public function integer($campo, $mensagem = null)
    {
        if ($this->ignorarSeVazio($campo)) {
            return $this;
        }

        $valor = $this->valor($campo);

        if (filter_var($valor, FILTER_VALIDATE_INT) === false) {
            $this->adicionarErro(
                $campo,
                $mensagem ?? "O campo $campo deve ser um número inteiro."
            );
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 5. E-MAIL
    |--------------------------------------------------------------------------
    */

    public function email($campo, $mensagem = null)
    {
        if ($this->ignorarSeVazio($campo)) {
            return $this;
        }

        $valor = $this->valor($campo);

        if (!filter_var($valor, FILTER_VALIDATE_EMAIL)) {
            $this->adicionarErro(
                $campo,
                $mensagem ?? "Informe um e-mail válido."
            );
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 6. URL
    |--------------------------------------------------------------------------
    */

    public function url($campo, $mensagem = null)
    {
        if ($this->ignorarSeVazio($campo)) {
            return $this;
        }

        $valor = $this->valor($campo);

        if (!filter_var($valor, FILTER_VALIDATE_URL)) {
            $this->adicionarErro(
                $campo,
                $mensagem ?? "Informe uma URL válida."
            );
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 7. VALOR MÍNIMO
    |--------------------------------------------------------------------------
    |
    | Usado para números.
    |
    | Exemplo:
    | ->min("preco", 1)
    |
    */

    public function min($campo, $minimo, $mensagem = null)
    {
        if ($this->ignorarSeVazio($campo)) {
            return $this;
        }

        $valor = $this->valor($campo);

        if (!is_numeric($valor) || $valor < $minimo) {
            $this->adicionarErro(
                $campo,
                $mensagem ?? "O campo $campo deve ser no mínimo $minimo."
            );
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 8. VALOR MÁXIMO
    |--------------------------------------------------------------------------
    */

    public function max($campo, $maximo, $mensagem = null)
    {
        if ($this->ignorarSeVazio($campo)) {
            return $this;
        }

        $valor = $this->valor($campo);

        if (!is_numeric($valor) || $valor > $maximo) {
            $this->adicionarErro(
                $campo,
                $mensagem ?? "O campo $campo deve ser no máximo $maximo."
            );
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 9. VALOR ENTRE DOIS NÚMEROS
    |--------------------------------------------------------------------------
    */

    public function between($campo, $minimo, $maximo, $mensagem = null)
    {
        if ($this->ignorarSeVazio($campo)) {
            return $this;
        }

        $valor = $this->valor($campo);

        if (
            !is_numeric($valor)
            || $valor < $minimo
            || $valor > $maximo
        ) {
            $this->adicionarErro(
                $campo,
                $mensagem
                    ?? "O campo $campo deve estar entre $minimo e $maximo."
            );
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 10. QUANTIDADE MÍNIMA DE CARACTERES
    |--------------------------------------------------------------------------
    */

    public function minLength($campo, $minimo, $mensagem = null)
    {
        if ($this->ignorarSeVazio($campo)) {
            return $this;
        }

        $valor = trim($this->valor($campo));

        if (strlen($valor) < $minimo) {
            $this->adicionarErro(
                $campo,
                $mensagem
                    ?? "O campo $campo deve ter pelo menos $minimo caracteres."
            );
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 11. QUANTIDADE MÁXIMA DE CARACTERES
    |--------------------------------------------------------------------------
    */

    public function maxLength($campo, $maximo, $mensagem = null)
    {
        if ($this->ignorarSeVazio($campo)) {
            return $this;
        }

        $valor = trim($this->valor($campo));

        if (strlen($valor) > $maximo) {
            $this->adicionarErro(
                $campo,
                $mensagem
                    ?? "O campo $campo deve ter no máximo $maximo caracteres."
            );
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 12. EXPRESSÃO REGULAR
    |--------------------------------------------------------------------------
    |
    | Permite criar uma validação personalizada.
    |
    | Exemplo de telefone:
    | ->regex("telefone", "/^[0-9]{10,11}$/")
    |
    */

    public function regex($campo, $padrao, $mensagem = null)
    {
        if ($this->ignorarSeVazio($campo)) {
            return $this;
        }

        $valor = $this->valor($campo);

        if (!preg_match($padrao, $valor)) {
            $this->adicionarErro(
                $campo,
                $mensagem ?? "O formato do campo $campo é inválido."
            );
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 13. VALOR DENTRO DE UMA LISTA
    |--------------------------------------------------------------------------
    |
    | Exemplo:
    |
    | ->in("categoria", ["Roupa", "Alimento", "Eletrônico"])
    |
    */

    public function in($campo, $opcoes, $mensagem = null)
    {
        if ($this->ignorarSeVazio($campo)) {
            return $this;
        }

        $valor = $this->valor($campo);

        if (!in_array($valor, $opcoes)) {
            $this->adicionarErro(
                $campo,
                $mensagem ?? "O valor informado no campo $campo não é permitido."
            );
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 14. DATA
    |--------------------------------------------------------------------------
    |
    | Esta versão utiliza o formato brasileiro:
    | dia/mês/ano
    |
    | Exemplo:
    | 25/12/2026
    |
    */

    public function date($campo, $mensagem = null)
    {
        if ($this->ignorarSeVazio($campo)) {
            return $this;
        }

        $valor = $this->valor($campo);

        // Divide o texto usando a barra.
        $partes = explode("/", $valor);

        // Uma data deve possuir dia, mês e ano.
        if (count($partes) !== 3) {
            $this->adicionarErro(
                $campo,
                $mensagem ?? "Informe uma data no formato dia/mês/ano."
            );

            return $this;
        }

        $dia = $partes[0];
        $mes = $partes[1];
        $ano = $partes[2];

        // checkdate verifica se a data realmente existe.
        // Exemplo: 31/02 é inválido.
        if (!checkdate($mes, $dia, $ano)) {
            $this->adicionarErro(
                $campo,
                $mensagem ?? "Informe uma data válida."
            );
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 15. CONFIRMAÇÃO
    |--------------------------------------------------------------------------
    |
    | Por padrão:
    |
    | confirmed("senha")
    |
    | compara:
    |
    | senha
    | senha_confirmation
    |
    */

    public function confirmed(
        $campo,
        $campoConfirmacao = null,
        $mensagem = null
    ) {
        if ($this->ignorarSeVazio($campo)) {
            return $this;
        }

        // Caso não seja informado, cria o nome automaticamente.
        if ($campoConfirmacao === null) {
            $campoConfirmacao = $campo . "_confirmation";
        }

        if ($this->valor($campo) !== $this->valor($campoConfirmacao)) {
            $this->adicionarErro(
                $campo,
                $mensagem ?? "A confirmação do campo $campo não confere."
            );
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 16. CAMPOS IGUAIS
    |--------------------------------------------------------------------------
    */

    public function same($campo, $outroCampo, $mensagem = null)
    {
        if ($this->ignorarSeVazio($campo)) {
            return $this;
        }

        if ($this->valor($campo) !== $this->valor($outroCampo)) {
            $this->adicionarErro(
                $campo,
                $mensagem
                    ?? "O campo $campo deve ser igual ao campo $outroCampo."
            );
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 17. APENAS LETRAS E ESPAÇOS
    |--------------------------------------------------------------------------
    */

    public function alpha($campo, $mensagem = null)
    {
        if ($this->ignorarSeVazio($campo)) {
            return $this;
        }

        $valor = $this->valor($campo);

        if (!preg_match("/^[A-Za-zÀ-ÿ ]+$/", $valor)) {
            $this->adicionarErro(
                $campo,
                $mensagem ?? "O campo $campo deve conter apenas letras."
            );
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 18. LETRAS E NÚMEROS
    |--------------------------------------------------------------------------
    */

    public function alphaNumeric($campo, $mensagem = null)
    {
        if ($this->ignorarSeVazio($campo)) {
            return $this;
        }

        $valor = $this->valor($campo);

        if (!preg_match("/^[A-Za-zÀ-ÿ0-9 ]+$/", $valor)) {
            $this->adicionarErro(
                $campo,
                $mensagem
                    ?? "O campo $campo deve conter apenas letras e números."
            );
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 19. VALOR BOOLEANO
    |--------------------------------------------------------------------------
    |
    | Aceita:
    | true, false, 1, 0, "1" e "0"
    |
    */

    public function boolean($campo, $mensagem = null)
    {
        if ($this->ignorarSeVazio($campo)) {
            return $this;
        }

        $valor = $this->valor($campo);
        $valoresPermitidos = [true, false, 1, 0, "1", "0"];

        if (!in_array($valor, $valoresPermitidos, true)) {
            $this->adicionarErro(
                $campo,
                $mensagem
                    ?? "O campo $campo deve possuir um valor verdadeiro ou falso."
            );
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | MÉTODOS PARA CONSULTAR O RESULTADO
    |--------------------------------------------------------------------------
    */


    // Retorna true quando encontrou pelo menos um erro.
    public function fails()
    {
        return !empty($this->erros);
    }


    // Retorna true quando nenhum erro foi encontrado.
    public function passes()
    {
        return empty($this->erros);
    }


    // Retorna todos os erros.
    public function errors()
    {
        return $this->erros;
    }


    // Retorna o erro de um campo específico.
    public function first($campo)
    {
        return $this->erros[$campo] ?? null;
    }


    // Retorna os dados recebidos.
    public function data()
    {
        return $this->dados;
    }
}
