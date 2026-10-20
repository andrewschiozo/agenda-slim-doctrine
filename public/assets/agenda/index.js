let paginaAtual = 1;

function carregarContatos(pagina) {
    $.ajax({
        url: '/api/contatos?pagina=' + pagina,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            paginaAtual = response.metadados.pagina_atual;
            renderizarTabela(response.dados);
            renderizarPaginacao(response.metadados);
        },
        error: function () {
            showAlert('Erro ao carregar os contatos.', 'danger');
        }
    });
}

function renderizarTabela(dados) {
    const tbody = $('#tabelaContatos tbody');
    tbody.empty();

    if (dados.length === 0) {
        tbody.append('<tr><td colspan="3" class="text-center">Nenhum contato encontrado.</td></tr>');
        return;
    }

    dados.forEach(function (contato) {
        let dataFormatada = '-';
        if (contato.dataNascimento) {
            const dataObj = new Date(contato.dataNascimento);
            dataFormatada = dataObj.toLocaleDateString('pt-BR', { timeZone: 'UTC' });
        }

        const tr = `
            <tr>
                <td class="align-middle">${contato.nome}</td>
                <td class="align-middle">${dataFormatada}</td>
                <td class="text-end">
                    <a href="/agenda/edit/${contato.id}" class="btn btn-sm btn-warning">Editar</a>
                    <button
                        class="btn btn-sm btn-danger btnConfirmDelete"
                        data-id="${contato.id}"
                        data-nome="${contato.nome}"
                        data-bs-toggle="modal"
                        data-bs-target="#confirmDeleteModal">
                        Excluir
                    </button>
                </td>
            </tr>
        `;
        tbody.append(tr);
    });
}

function renderizarPaginacao(metadados) {
    const ul = $('#paginacaoContatos');
    ul.empty();

    if (metadados.totalPaginas <= 1) return;

    for (let i = 1; i <= metadados.totalPaginas; i++) {
        const activeClass = (i === metadados.paginaAtual) ? 'active' : '';
        const li = `<li class="page-item ${activeClass}"><a class="page-link" href="#" onclick="carregarContatos(${i});">${i}</a></li>`;
        ul.append(li);
    }
}

function excluirContato(id, nome = "") {
    $.ajax({
        url: '/api/contatos/' + id,
        method: 'DELETE',
        success: function (response) {
            showAlert(`Contato ${nome} excluído`, 'warning')
            carregarContatos(paginaAtual);
        },
        error: function () {
            showAlert('Erro ao excluir o contato.', 'danger');
        }
    });
}

$(document).ready(function () {
    carregarContatos(1);

    // event no botão de excluir
    $(document).on('click', '.btnConfirmDelete', function () {
        const contatoNome = $(this).data('nome');
        const contatoId = $(this).data('id');
        $('#modalContactName').text(contatoNome);

        // injeta o data no botão de confirmação
        $('#btnConfirmDelete').data('id', contatoId)
        $('#btnConfirmDelete').data('nome', contatoNome)
    });

    // event no checkbox para confirmar exclusão
    $('#chkConfirmExclusion').on('change', function () {
        $('#btnConfirmDelete').prop('disabled', !this.checked);
    });

    // event para resetar a modal
    $('#confirmDeleteModal').on('hidden.bs.modal', function () {
        $('#chkConfirmExclusion').prop('checked', false);
        $('#btnConfirmDelete').prop('disabled', true);
        $('#btnConfirmDelete').data('id', '')
        $('#btnConfirmDelete').data('nome', '')
        $('#modalContactName').text('');
    });

    // event na confirmação da exclusão
    $('#btnConfirmDelete').on('click', function () {

        excluirContato($(this).data('id'), $(this).data('nome'))

        // fecha o modal
        const modalEl = document.getElementById('confirmDeleteModal');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        modalInstance.hide();
    });
});