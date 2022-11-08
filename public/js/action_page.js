// $('body').on('keydown', '#form-page', function (e) {
//     if (e.keyCode == 13) {
//         e.preventDefault();
//         simpanByForm();
//         return false;
//     }
// });


// $('#page-btn-save').on('click', function (e) {
//     e.preventDefault();
//     simpanByForm();
// })

function simpanByForm(form_id) {
    showLoader();
    var form = $(form_id),
        url = form.attr('action'),
        method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT';
    message = method == 'POST' ? 'Saved' : 'Updated',
        module_name = form.attr('title');
    formData = new FormData(form[0]);
    form.find('.error').remove();
    $(".form-control").removeClass('is-invalid');
    $(".custom-file-input").removeClass('is-invalid');
    console.log(url);

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
