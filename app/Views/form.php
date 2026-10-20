<div class="row mb-3">
    <div class="col-md-6">
        <h2 id="tituloFormulario">Novo Contato</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="/agenda/index" class="btn btn-secondary">Voltar à Lista</a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form id="formContato">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nome" name="nome" required maxlength="255">
            </div>
            
            <div class="mb-3">
                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
            </div>
            
            <div class="mb-3">
                <label for="logradouro" class="form-label">Endereço Completo</label>
                <input type="text" class="form-control" id="logradouro" name="logradouro" maxlength="255" placeholder="Rua, Número, Bairro, Cidade - UF">
            </div>
            
            <button type="submit" class="btn btn-success" id="btnSalvar">Salvar</button>
        </form>
    </div>
</div>

<script src="/assets/agenda/form.js"></script>