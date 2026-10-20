<div class="row mb-3">
    <div class="col-md-6">
        <h2>Contatos</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="/agenda/create" class="btn btn-primary">Novo Contato</a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        <!-- Tabela -->
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tabelaContatos">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th>Endereço</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="3" class="text-center">Carregando...</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        <nav>
            <ul class="pagination justify-content-center" id="paginacaoContatos"></ul>
        </nav>
    </div>
</div>

<script src="/assets/agenda/index.js"></script>