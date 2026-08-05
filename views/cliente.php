<!-- css da página -->
<link rel="stylesheet" href="assets/css/cliente.css">

<section>
    <div class="col-md-6 mx-auto">
        <h2> Cadastro de clientes </h2>

        <!-- Formulário -->
        <form id="formCliente">

            <!-- Nome -->
            <div class="mb-3">
                <label for="nome"> Nome </label>
                <div class="input-group">
                    <span class="input-group-text"> <i class="bi bi-box"></i> </span>
                    <input type="text" id="nome" name="nome" class="form-control">
                </div>
                <div class="invalid-feedback"></div>
                <div class="valid-feedback"></div>
            </div>

            <!-- CPF -->
            <div class="mb-3">
                <label for="cpf"> CPF </label>
                <div class="input-group">
                    <span class="input-group-text"> <i class="bi bi-person"></i></span>
                    <input type="text" id="cpf" name="cpf" class="form-control">
                </div>
                <div class="invalid-feedback"></div>
                <div class="valid-feedback"></div>
            </div>

            <!-- e-mail -->
            <div class="mb-3">
                <label for="email"> E-mail </label>
                <div class="input-group">
                    <span class="input-group-text"> <i class="bi bi-person"></i></span>
                    <input type="text" id="email" name="email" class="form-control">
                </div>
                <div class="invalid-feedback"></div>
                <div class="valid-feedback"></div>
            </div>
        </form>
    </div>

    <!-- telefone -->
    <div class="mb-3">
        <label for="telefone"> Telefone </label>
        <input type="text" id="telefone" name="telefone" class="form-control">
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
<script src="assets/js/cliente.js"></script>