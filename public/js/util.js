const BASE_URL = "http://localhost/codeigniter/";

const DATATABLE_PTBR = {
    "sEmptyTable": "Nenhum registro encontrado",
    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
    "sInfoPostFix": "",
    "sInfoThousands": ".",
    "sLengthMenu": "_MENU_ resultados por página",
    "sLoadingRecords": "Carregando...",
    "sProcessing": "Processando...",
    "sZeroRecords": "Nenhum registro encontrado",
    "sSearch": "Pesquisar",
    "oPaginate": {
        "sNext": "Próximo",
        "sPrevious": "Anterior",
        "sFirst": "Primeiro",
        "sLast": "Último"
    },
    "oAria": {
        "sSortAscending": ": Ordenar colunas de forma ascendente",
        "sSortDescending": ": Ordenar colunas de forma descendente"
    },
    "select": {
        "rows": {
            "_": "Selecionado %d linhas",
            "0": "Nenhuma linha selecionada",
            "1": "Selecionado 1 linha"
        }
    }
};

function clearErrors() {
    $(".has-error").removeClass("has-error");
    $(".help-block").html("");
}

function showErrors(error_list) {
    clearErrors();
    $.each(error_list, (id, msg) => {
        $(id).parent().parent().addClass("has-error");
        $(id).parent().siblings(".help-block").html(msg);
    });
}

function showErrorsModal(error_list) {
    clearErrors();
    $.each(error_list, (id, msg) => {
        $(id).parent().parent().addClass("has-error");
        $(id).siblings(".help-block").html(msg);
    });
}

function loadingImg(msg = null) {
    return `<i class='fa fa-circle-o-notch fa-spin'></i>&nbsp; ${msg}`;
}

function uploadImg(input_file, img, input_path) {
    src_before = img.attr("src");
    img_file = input_file[0].files[0];

    form_data = new FormData();
    form_data.append("image_file", img_file);

    $.ajax({
        url: BASE_URL + "restrict/ajaximportimage",
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: "POST",
        beforeSend: function() {
            clearErrors();
            input_path.siblings(".help-block").html(loadingImg('Carregando imagem...'));
        },
        success: function(resp) {
            clearErrors();
            if (resp["status"]) {
                img.attr("src", resp["img_path"]);
                input_path.val(resp["img_path"])
            } else {
                img.attr("src", src_before);
                input_path.siblings(".help-block").html(resp["error"]);
            }
        },
        error: function() {
            img.attr("src", src_before);
        }
    });

}