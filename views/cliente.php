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
                    <div class="invalid-feedback"></div>
                    <div class="valid-feedback"></div>
                </div>
            </div>

            <!-- CPF -->
            <div class="mb-3">
                <label for="cpf"> CPF </label>
                <div class="input-group">
                    <span class="input-group-text"> <i class="bi bi-person"></i></span>
                    <input type="text" id="cpf" name="cpf" class="form-control">

                    <div class="invalid-feedback"></div>
                    <div class="valid-feedback"></div>
                </div>
            </div>

            <!-- e-mail -->
            <div class="mb-3">
                <label for="email"> E-mail </label>
                <div class="input-group">
                    <span class="input-group-text"> <i class="bi bi-person"></i></span>
                    <input type="text" id="email" name="email" class="form-control">

                    <div class="invalid-feedback"></div>
                    <div class="valid-feedback"></div>
                </div>
            </div>


            <!-- telefone -->
            <div class="mb-3">
                <label for="telefone"> Telefone </label>
                <div class="input-group">
                    <span class="input-group-text"> <i class="bi bi-person"></i></span>
                    <input type="text" id="telefone" name="telefone" class="form-control">

                    <div class="invalid-feedback"></div>
                    <div class="valid-feedback"></div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Cadastrar
            </button>

        </form>

        <!-- Mensagem de Retorno -->
        <div id="mensagem" class="alert d-none mt-3"> </div>

    </div>


</section>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<!-- jQuery Mask -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<!-- script da página -->
<script src="assets/js/cliente.js"></script>