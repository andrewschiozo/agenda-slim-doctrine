let paginaAtual = 1;

function carregarContatos(pagina) {
    $.ajax({
        url: '/api/contatos?pagina=' + pagina,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            paginaAtual = response.metadados.pagina_atual;
            renderizarTabela(response.dados);
            renderizarPaginacao(response.metadados);
        },
        error: function() {
            console.error('Erro ao carregar os contatos.');
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

    dados.forEach(function(contato) {
        let dataFormatada = '-';
        if (contato.dataNascimento) {
            const dataObj = new Date(contato.dataNascimento);
            dataFormatada = dataObj.toLocaleDateString('pt-PT');
        }

        const tr = `
            <tr>
                <td class="align-middle">${contato.nome}</td>
                <td class="align-middle">${dataFormatada}</td>
                <td class="align-middle">${contato.logradouro}</td>
                <td class="text-end">
                    <a href="/agenda/edit/${contato.id}" class="btn btn-sm btn-warning">Editar</a>
                    <button class="btn btn-sm btn-danger" onclick="excluirContato(${contato.id})">Excluir</button>
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
        const li = `<li class="page-item ${activeClass}"><a class="page-link" href="#" onclick="carregarContatos(${i}); return false;">${i}</a></li>`;
        ul.append(li);
    }
}

function excluirContato(id) {
    if(confirm('Tem a certeza que deseja excluir este contato?')) {
        alert('implementar');
    }
}

$(document).ready(function() {
    carregarContatos(1);
});