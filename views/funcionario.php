<!-- css da página -->
<link rel="stylesheet" href="assets/css/funcionario.css">

<section>
    <div class="col-md-6 mx-auto">
        <h2> Cadastro de funcionários </h2>

        <!-- Formulário -->
        <form id="formFuncionario">

            <!-- Nome -->
            <div class="mb-3">
                <label for="nome"> Nome </label>
                <input type="text" id="nome" name="nome" class="form-control">
            </div>

            <!-- CNPJ -->
            <div class="mb-3">
                <label for="cnpj"> CNPJ </label>
                <input type="text" id="cnpj" name="cnpj" class="form-control">
            </div>

            <!-- RF -->
            <div class="mb-3">
                <label for="regFunc"> E-mail </label>
                <input type="text" id="regFunc" name="regFunc" class="form-control">
            </div>

            <!-- PIS -->
            <div class="mb-3">
                <label for="pis"> Telefone </label>
                <input type="text" id="pis" name="pis" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Cadastrar
            </button>

        </form>

        <!-- Mensagem de Retorno -->
        <div id="mensagem" class="alert d-none mt-3"> </div>
                
    </div>


</section>

<!-- script da página -->
<script src="assets/js/funcionario.js"></script>