$('body').on('click','.small-modal-show',function(e){
    e.preventDefault();
    // alert('mamam');
    var me = $(this),
        url = me.attr('href'),
        title = me.attr('title');
    $('.modal-title').text(title);
    $('#modal-btn-save').text(me.hasClass('btn-edit') ? 'Update' : 'Create');
    $.ajax({
        url: url,
        dataType: 'html',
        success: function (response) {
            if(response == '403'){
                Swal.fire({
                    type: 'error',
                    title: '403',
                    text: 'Access not allowed !!!',
                    icon: 'error'
                })
            }else{
                $('.modal-body').html(response)
                $('#modal-sm').modal('show');
            }
        }
    });

})

$('body').on('click','.large-modal-show',function(e){
    e.preventDefault();
    // alert('mamam');
    var me = $(this),
        url = me.attr('href'),
        title = me.attr('title');
    $('.modal-title').text(title);
    $('#modal-btn-save').text(me.hasClass('btn-edit') ? 'Update' : 'Create');
    $.ajax({
        url: url,
        dataType: 'html',
        success: function (response) {
            if(response == '403'){
                Swal.fire({
                    type: 'error',
                    title: '403',
                    text: 'Access not allowed !!!',
                    icon: 'error'
                })
            }else{
                $('.modal-body').html(response)
                $('#modal-lg').modal('show');
            }
        }
    });

})
$('body').on('keydown', '#form-modal', function (e) {
    if (e.keyCode == 13 && ($(event.target)[0] != $("textarea")[0])) {
      e.preventDefault();
      simpan();
      return false;
    }
});


$('#modal-btn-save').on('click',function () {
    simpan();
})


function simpan(){
    showLoader();
    var form = $('#form-modal'),
        url = form.attr('action'),
        method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT';
        message = method == 'POST' ? 'Saved' : 'Updated',
        module_name = form.attr('title');
        formData = new FormData(form[0]);
        form.find('.error').remove();
        $(".form-control").removeClass('is-invalid');

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
                $('#modal-sm').modal('hide');
                $('#modal-lg').modal('hide');
                toastr.success(response.message);
                $('#table').DataTable().ajax.reload();
            }else{
                console.log(response);
                if(response.code == 422){
                    toastr.error(response.message);
                    $.each(JSON.parse(response.errors), function (key, value) {
                        $('#' + key)
                            .closest('.form-control')
                            .addClass('is-invalid')
                        $('#' + key)
                            .closest('.form-group')
                            .append('<span class="error invalid-feedback">' + value + '</span>')
                    })
                }else{
                    toastr.error(response.message);
                    // console.log(response.message);
                }
            
            }
           
            
        },
    })
}