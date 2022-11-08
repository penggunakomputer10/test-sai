<!-- jQuery -->
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script>
<!-- SweetAlert2 -->
<script src="{{asset('adminlte/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('adminlte/plugins/toastr/toastr.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="{{asset('adminlte/dist/js/demo.js')}}"></script> -->
<script src="{{asset('js/action_modal.js')}}"></script>
<script src="{{asset('js/action_page.js')}}"></script>
<script src="{{asset('js/action_editor.js')}}"></script>
<script src="{{asset('js/action_delete.js')}}"></script>
<script src="{{asset('js/loader.js')}}"></script>
<!-- bs-custom-file-input -->
<script src="{{asset('adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script>
$(function () {
  bsCustomFileInput.init();
});
$('body').on('click','#removePreview',function(){
    $('#imageview').remove();
    $('#image').val('');
    $('.custom-file-label').text('Choose file');
})
</script>
<script>
    $('#logout').on('click',function(e){
    e.preventDefault();
    Swal.fire({
        title: '{{auth()->user()->name}}',
        text: "Are you sure want to logout?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
        $.ajax({
            url: "{{ route('logout') }}",
            method: 'POST',
            headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            success: function (response) {
            window.location.href = '{{route("login")}}';
            },
            error: function (xhr) {
                console.log(xhr);
            }
        })
        }
    })
    });
</script>

@yield('script')
</body>