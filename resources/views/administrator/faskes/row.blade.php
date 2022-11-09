<tr>
    <td>
        <select name="vaccine_id[]" id="{{$uniqId}}" class="form-control select2" style="width:100%" required>
   
        </select>
    </td>
    <td>
        <input type="number" name="quota[]" id="quota" class="form-control" required>
    </td>
    <td>
        <button class="btn btn-danger btn-sm" id="delete" type="button"><i class="fas fa-minus"></i></button>
    </td>
</tr>
<!-- setup select2 -->
<script>
$("{{ '#'.$uniqId }}").select2({
    placeholder: "Choose Vaccine...",
    allowClear: true,
    // theme:"classic",
    ajax: {
        url: "{{route('vaccine.select2')}}",
        dataType: 'json',
        data: function (params) {
            return {
                search: $.trim(params.term)
            };  
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
    }
});

</script>