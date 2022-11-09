@foreach($data->vaccines as $p)
<tr>
    <td>
        <select name="vaccine_id[]" id="{{$p->id}}" class="form-control select2" style="width:100%" required>
             <option value="{{$p->vaccine_id}}" selected>{{$p->name}}</option>
        </select>
    </td>
    <td>
        <input type="number" name="quota[]" id="quota" class="form-control" value="{{$p->quota}}" required>
    </td>
    <td>
        <button class="btn btn-danger btn-sm" id="delete" type="button"><i class="fas fa-minus"></i></button>
    </td>
</tr>
@endforeach
