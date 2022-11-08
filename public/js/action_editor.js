$('body').on('keydown', '#form-editor', function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
        simpanByEditor();
        return false;
    }
});


$('#editor-btn-save').on('click', function () {
    simpanByEditor();
})

function simpanByEditor() {
    tinyMCE.triggerSave();
    showLoader();
    var form = $('#form-editor'),
        url = form.attr('action'),
        method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT';
    message = method == 'POST' ? 'Saved' : 'Updated',
        module_name = form.attr('title');
    formData = new FormData(form[0]);
    form.find('.error').remove();
    $(".form-control").removeClass('is-invalid');
    $(".custom-file-input").removeClass('is-invalid');


    $('.card').find('.error').remove();
    $.ajax({
        url: url,
        method: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        success: function (response) {
            hideLoader();
            if (response.success == true) {
                if(response.code == 201){
                    form.trigger('reset');
                    $(".select2").val('').trigger('change');
                    $(".image-preview").attr("src","");

                }
                toastr.success(response.message);
            }else{
                $.each(JSON.parse(response.errors), function (key, value) {
                    $('#' + key)
                        .closest('.form-control')
                        .addClass('is-invalid')
                    $('#' + key)
                        .closest('.form-group')
                        .append('<span class="error" style="color:red!important;">' + value + '</span>')
                
                })
            
            }
        }
    })

}
