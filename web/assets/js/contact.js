var API_URL = 'http://agenda.dev/api/v1';
var $modal = $('#modal').modal({show: false});

$(function() {
    getAllContacts();

    $("#phone").mask("(99) 9?9999-9999");

    // create event
    $('.create').click(function () {
        showModal($(this).text());
    });
    $modal.find('.submit').click(function (e) {
        e.preventDefault();
        var row = {};
        var form = $(this);
        form.parsley().validate();

        if (!form.parsley().isValid()){
            $.notific8('Informações incorretas.',{ life:5000,horizontalEdge:"bottom", theme:"danger" ,heading:" ERRO :) "});
            return;
        }

        $modal.find('input[name]').each(function () {
            row[$(this).attr('name')] = $(this).val();
        });
        var url = API_URL + '/contatos';
        var contatoid = $('#contatoid').val();
        if (contatoid) {
            url = url + '/' + contatoid;
        }
        $.ajax({
            url: url,
            type: contatoid ? 'put' : 'post',
            contentType: 'application/json',
            data: JSON.stringify(row),
            success: function () {
                $modal.modal('hide');
                $('#table').bootstrapTable('refresh');
                $.notific8('Contato cadastrado!',{ life:5000,horizontalEdge:"bottom", theme:"success" ,heading:" SUCESSO "});
            },
            error: function (result) {
                $modal.modal('hide');
                $.notific8('Erro: ' + result.result.message,{ life:5000,horizontalEdge:"bottom", theme:"danger" ,heading:" ERRO"});
            }
        });
    });

});

function getAllContacts() {
    $.ajax({
        url: API_URL + '/contatos',
        type: 'GET',
        success: function(result) {
            mountTable(result.data);
        }
    });
}

function mountTable(data) {
    $('#table').bootstrapTable({
        pageList: [10, 25, 50, 100, 'All'],
        data: data,
        locale: 'pt-BR',
        responsive: {
            details: false
        }
    });
}

function actionFormatter(value) {
    return [
        '<a class="btn btn-warning btn-xs update" title="Atualizar Contato" href="javascript:">Editar</a>',
        '<a class="btn btn-danger btn-xs remove"  title="Inativar Contato" href="javascript:">Inativar</a>',
    ].join('');
}

// update and delete events
window.actionEvents = {
    'click .update': function (e, value, row) {
        showModal($(this).attr('title'), row);
    },
    'click .remove': function (e, value, row) {
        if (confirm('Deseja inativar esse contato?')) {
            $.ajax({
                url: API_URL + '/' + row.contactid,
                type: 'delete',
                success: function () {
                    $('#table').bootstrapTable('refresh');
                    $.notific8('Inativado com sucesso!',{ life:5000,horizontalEdge:"bottom", theme:"success" ,heading:" SUCESSO"});
                },
                error: function () {
                    $.notific8('Erro ao inativar!',{ life:5000,horizontalEdge:"bottom", theme:"danger" ,heading:" ERRO"});
                }
            })
        }
    }
};

function showModal(title, row) {
    row = row || {
        contactid: '',
        name: '',
        phone: '',
        email: ''
    }; // default row value

    $('#contatoid').val(row.contactid);
    $modal.data('id', row.contactid);
    $modal.find('.modal-title').text(title);
    for (var name in row) {
        $modal.find('input[name="' + name + '"]').val(row[name]);
    }
    $modal.modal('show');
}
