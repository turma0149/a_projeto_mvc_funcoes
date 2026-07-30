<section>
    <div class="col-md-6 mx-auto">
        <h2> Cadastro de produtos </h2>

        <!-- Formulário -->
        <form id="formProduto">

            <!-- Nome -->
            <div class="mb-3">
                <label for="nome"> Nome </label>
                <input type="text" id="nome" name="nome" class="form-control">
            </div>

            <!-- Categoria -->
            <div class="mb-3">
                <label for="categoria"> Categoria </label>
                <input type="text" id="categoria" name="categoria" class="form-control">
            </div>

            <!-- Preço -->
            <div class="mb-3">
                <label for="preco"> Preço </label>
                <input type="number" id="preco" name="preco" class="form-control">
            </div>

            <!-- Quantidade -->
            <div class="mb-3">
                <label for="quantidade"> Quantidade </label>
                <input type="quantidade" id="quantidade" name="quantidade" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Cadastrar
            </button>

            <!-- Mensagem de Retorno -->
            <div id="mensagem" class="alert d-none mt-3"> </div>

        </form>


    </div>


    <script src="assets/js/produto.js"></script>

</section>