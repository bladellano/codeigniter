const BASE_URL = 'http://localhost/codeigniter/';

function clearErrors(){
    $('.has-error').removeClass('has-error');
    $('.help-block').html('');
}

function showErrors(error_list){
    clearErrors();
    $.each(error_list,(id,msg)=>{
        $(id).parent().parent().addClass('has-error');
        $(id).parent().siblings('.help-block').html(msg)
    });
}

function loadingImg(msg=null){
    return `<i class='fa fa-circle-o-notch fa-spin'></i>&nbsp; ${msg}`;
}

function uploadImg(){
    
}