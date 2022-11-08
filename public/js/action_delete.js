$('body').on('click','.sw-delete',function (e) {
    e.preventDefault();

    var me = $(this),
        url = me.attr('href'),
        title = me.attr('title');
        Swal.fire({
        title: 'Are you sure?',
        text: "You will delete "+title,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            showLoader();
            
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {

                        if(response.success == true ){
                            hideLoader();

                            toastr.success(title+' has been deleted.')
                        }else if(response == '403'){
                            hideLoader();

                            Swal.fire({
                                type: 'error',
                                title: '403',
                                text: 'Access not allowed !!!',
                                icon: 'error'
                            })
                        }else{
                             hideLoader();

                            toastr.error('Error!!')

                        }

                        $('#table').DataTable().ajax.reload();
                    },
                    error: function (response) {
                        Swal.fire({
                            type: 'error',
                            title: 'Oops....',
                            text: 'something went wrong!',
                            icon: 'error'
                        })
                        hideLoader();


                    }
                });
            }else{
                hideLoader();
            }
            
        })
})