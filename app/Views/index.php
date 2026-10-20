<div class="row mb-3">
    <div class="col-md-6">
        <h2>Contatos</h2>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12 text-end">
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
                        <th class="text-nowrap">Nome</th>
                        <th class="text-nowrap">Data Nascimento</th>
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

<!-- Modal de exclusão -->
<div class="modal fade" id="confirmDeleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteLabel">Confirmar Exclusão</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <p>Tem certeza que deseja excluir o contato <strong id="modalContactName"></strong>?</p>

        <div class="form-check mt-3">
          <input class="form-check-input" type="checkbox" id="chkConfirmExclusion">
          <label class="form-check-label text-muted small" for="chkConfirmExclusion">
            Para excluir o contato você precisa marcar essa opção
          </label>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não, quero cancelar</button>
        <button type="button" class="btn btn-danger" id="btnConfirmDelete" data-id="" data-nome="" disabled>Sim, quero excluir</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Visualização -->
<div class="modal fade" id="viewContactModal" tabindex="-1" aria-labelledby="viewContactLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewContactLabel">Detalhes do Contato</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <small class="text-muted d-block">Nome</small>
          <strong id="viewModalNome" class="fs-5"></strong>
        </div>
        <div class="mb-3">
          <small class="text-muted d-block">Data de Nascimento</small>
          <span id="viewModalDataNascimento"></span>
        </div>
        <div>
          <small class="text-muted d-block">Endereço</small>
          <span id="viewModalEndereco"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<script src="/assets/agenda/index.js"></script>