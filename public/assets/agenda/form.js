$(document).ready(function() {
    let contatoId = null;
    
    // trata a edicao na url /edit/1
    const partesUrl = window.location.pathname.split('/');
    const ultimoSegmento = partesUrl[partesUrl.length - 1];

    // trata mínimo e máximo da data de nascimento
    const dataAtual = new Date();

    const anoAtual = dataAtual.getFullYear();
    const mesAtual = String(dataAtual.getMonth() + 1).padStart(2, '0');
    const diaAtual = String(dataAtual.getDate()).padStart(2, '0');
    
    const dataMaxima = `${anoAtual}-${mesAtual}-${diaAtual}`;
    const dataMinima = `${anoAtual - 120}-${mesAtual}-${diaAtual}`;
    
    // aplica min e max no input data_nascimento
    $('#data_nascimento').attr('max', dataMaxima);
    $('#data_nascimento').attr('min', dataMinima);

    if (!isNaN(ultimoSegmento) && ultimoSegmento > 0) {
        contatoId = ultimoSegmento;
        $('#tituloFormulario').text('Editar Contato');
        carregarDadosEdicao(contatoId);
    }

    // Procura os dados na API para preencher os campos
    function carregarDadosEdicao(id) {
        $.ajax({
            url: '/api/contatos/' + id,
            method: 'GET',
            success: function(dados) {
                $('#nome').val(dados.nome);
                $('#data_nascimento').val(dados.dataNascimento);
                $('#logradouro').val(dados.logradouro);
            },
            error: function() {
                window.location.href = '/agenda/index';                
            }
        });
    }

    // Salva o contato
    $('#formContato').on('submit', function(e) {
        e.preventDefault();

        const btnSalvar = $('#btnSalvar');
        btnSalvar.prop('disabled', true).text('Salvando...');

        // monta a url para criação/atualização
        const urlDestino = contatoId ? '/api/contatos/' + contatoId : '/api/contatos';

        const dadosFormulario = $(this).serialize();

        $.ajax({
            url: urlDestino,
            method: contatoId ? 'PUT' : 'POST',
            data: dadosFormulario,
            success: function(response) {
                window.location.href = '/agenda/index';
            },
            error: function(xhr) {
                btnSalvar.prop('disabled', false).text('Salvar');

                let msg = 'Ocorreu um erro ao salvar o registro.';
                if (xhr.responseJSON && xhr.responseJSON.erro) {
                    msg = xhr.responseJSON.erro;
                }
                showAlert(msg, 'error')
            }
        });
    });
});