$(function(){
    $('#login_form').submit(function(e){

        e.preventDefault();

        $.ajax({
            type:'post',
            url:BASE_URL + 'restrict/ajaxlogin',
            dataType:'json',
            data:$(this).serialize(),
            beforeSend:function(){
                clearErrors();
                $('#btn_login').parent().siblings('.help-block')
                .html(loadingImg('Verificando...'));
            },
            success:function(json){
                if(json.status === 1){
                    clearErrors();
                    $('#btn_login').parent().siblings('.help-block')
                    .html(loadingImg('Logando...'));
                    window.location = BASE_URL + 'restrict';
                } else {
                    showErrors(json.error_list);
                }
            },
            error:function(resp){
                console.log(resp);
            }
        });
    });

});