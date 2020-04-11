$(function() {

    $('#btn_add_course').click(function() {
        clearErrors();
        $('#form_course')[0].reset();
        $('#course_img_path').attr('src', '');
        $('#modal_course').modal();
    });

    $('#btn_add_member').click(function() {
        clearErrors();
        $('#form_member')[0].reset();
        $('#member_photo_path').attr('src', '');
        $('#modal_member').modal();
    });

    $('#btn_add_user').click(function() {
        clearErrors();
        $('#form_user')[0].reset();
        $('#modal_user').modal();
    });

    $('#btn_upload_course_img').change(function() {
        uploadImg($(this), $('#course_img_path'), $('#course_img'))
    });

    $('#btn_upload_member_photo').change(function() {
        uploadImg($(this), $('#member_photo_path'), $('#member_photo'))
    });

    // SUBMISSÃO DO FORMULÁRIO CURSOS

    $('#form_course').submit(function(e) {

        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: BASE_URL + 'restrict/ajaxsavecourse',
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function() {
                clearErrors();
                $('#btn_save_course').siblings('.help-block')
                    .html(loadingImg('Verificando...'));
            },
            success: function(response) {
                clearErrors();
                if (response.status) {
                    $('#modal_course').modal('hide');
                } else {
                    showErrorsModal(response.error_list);
                }

            }
        });
    });

    // SUBMISSÃO DO FORMULÁRIO MEMBER

    $('#form_member').submit(function(e) {

        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: BASE_URL + 'restrict/ajaxsavemember',
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function() {
                clearErrors();
                $('#btn_save_member').siblings('.help-block')
                    .html(loadingImg('Verificando...'));
            },
            success: function(response) {
                clearErrors();
                if (response.status) {
                    $('#modal_member').modal('hide');
                } else {
                    showErrorsModal(response.error_list);
                }

            }
        });
    });

    // SUBMISSÃO DO FORMULÁRIO USUARIO

    $('#form_user').submit(function(e) {

        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: BASE_URL + 'restrict/ajaxsaveuser',
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function() {
                clearErrors();
                $('#btn_save_user').siblings('.help-block')
                    .html(loadingImg('Verificando...'));
            },
            success: function(response) {
                clearErrors();
                if (response.status) {
                    $('#modal_user').modal('hide');
                } else {
                    showErrorsModal(response.error_list);
                }

            }
        });
    });

});