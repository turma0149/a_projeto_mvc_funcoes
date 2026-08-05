<?php


class Validator
{
    // Propriedade que receberá os dados e erros
    private $dados = [];
    private $erros = [];

    // Construtor (ao criar o validador já envia os dados)
    public function __construct($dados)
    {
        $this->dados = $dados;
    }


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


    // CAMPO OBRIGATÓRIO
    public function required($campo, $mensagem = null)
    {
        if ($this->vazio($campo)) {
            $this->adicionarErro(
                $campo,
                $mensagem ?? "O campo $campo é obrigatório."
            );
        }
        return $this;
    }



    //TEXTO
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

    // QUANTIDADE MÍNIMA DE CARACTERES

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


    //QUANTIDADE MÁXIMA DE CARACTERES

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
