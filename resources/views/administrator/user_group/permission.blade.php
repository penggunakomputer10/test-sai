@extends('layouts.adminlte')
@section('title','Dashboard')
@section('content')
<section class="content">
    <!-- Default box -->
    <div class="card">

        <div class="card-body">
            
            <form action="{{route('user_group.permission_update',$role->id)}}" method="put" id="form-page" title="Permission {{$role->name}}">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-4">
                        <h5>Dashboard</h5>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="view_dashboard" name="view_dashboard" value="view_dashboard" {{ $role->hasPermissionTo('view_dashboard') ? 'checked' : ''}}>
                                <label for="view_dashboard" class="custom-control-label">View Dashboard</label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <h5>User Group</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="view_user_group" name="view_user_group" value="view_user_group" {{ $role->hasPermissionTo('view_user_group') ? 'checked' : ''}}>
                                <label for="view_user_group" class="custom-control-label">View User Group</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="add_user_group" name="add_user_group" value="add_user_group" {{ $role->hasPermissionTo('add_user_group') ? 'checked' : ''}}>
                                <label for="add_user_group" class="custom-control-label">Add User Group</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="edit_user_group" name="edit_user_group" value="edit_user_group" {{ $role->hasPermissionTo('edit_user_group') ? 'checked' : ''}}>
                                <label for="edit_user_group" class="custom-control-label">Edit User Group</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="delete_user_group" name="delete_user_group" value="delete_user_group" {{ $role->hasPermissionTo('delete_user_group') ? 'checked' : ''}}>
                                <label for="delete_user_group" class="custom-control-label">Delete User Group</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="permission_user_group" name="permission_user_group" value="permission_user_group" {{ $role->hasPermissionTo('permission_user_group') ? 'checked' : ''}}>
                                <label for="permission_user_group" class="custom-control-label">Permission User Group</label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <h5>User</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="view_user" name="view_user" value="view_user" {{ $role->hasPermissionTo('view_user') ? 'checked' : ''}}>
                                <label for="view_user" class="custom-control-label">View User</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="add_user" name="add_user" value="add_user" {{ $role->hasPermissionTo('add_user') ? 'checked' : ''}}>
                                <label for="add_user" class="custom-control-label">Add User</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="edit_user" name="edit_user" value="edit_user" {{ $role->hasPermissionTo('edit_user') ? 'checked' : ''}}>
                                <label for="edit_user" class="custom-control-label">Edit User</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="delete_user" name="delete_user" value="delete_user" {{ $role->hasPermissionTo('delete_user') ? 'checked' : ''}}>
                                <label for="delete_user" class="custom-control-label">Delete User</label>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <h5>Province</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="view_province" name="view_province" value="view_province" {{ $role->hasPermissionTo('view_province') ? 'checked' : ''}}>
                                <label for="view_province" class="custom-control-label">View Province</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="add_province" name="add_province" value="add_province" {{ $role->hasPermissionTo('add_province') ? 'checked' : ''}}>
                                <label for="add_province" class="custom-control-label">Add Province</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="edit_province" name="edit_province" value="edit_province" {{ $role->hasPermissionTo('edit_province') ? 'checked' : ''}}>
                                <label for="edit_province" class="custom-control-label">Edit Province</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="delete_province" name="delete_province" value="delete_province" {{ $role->hasPermissionTo('delete_province') ? 'checked' : ''}}>
                                <label for="delete_province" class="custom-control-label">Delete Province</label>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <h5>City</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="view_city" name="view_city" value="view_city" {{ $role->hasPermissionTo('view_city') ? 'checked' : ''}}>
                                <label for="view_city" class="custom-control-label">View City</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="add_city" name="add_city" value="add_city" {{ $role->hasPermissionTo('add_city') ? 'checked' : ''}}>
                                <label for="add_city" class="custom-control-label">Add City</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="edit_city" name="edit_city" value="edit_city" {{ $role->hasPermissionTo('edit_city') ? 'checked' : ''}}>
                                <label for="edit_city" class="custom-control-label">Edit City</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="delete_city" name="delete_city" value="delete_city" {{ $role->hasPermissionTo('delete_city') ? 'checked' : ''}}>
                                <label for="delete_city" class="custom-control-label">Delete City</label>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <h5>Vaccine</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="view_vaccine" name="view_vaccine" value="view_vaccine" {{ $role->hasPermissionTo('view_vaccine') ? 'checked' : ''}}>
                                <label for="view_vaccine" class="custom-control-label">View Vaccine</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="add_vaccine" name="add_vaccine" value="add_vaccine" {{ $role->hasPermissionTo('add_vaccine') ? 'checked' : ''}}>
                                <label for="add_vaccine" class="custom-control-label">Add Vaccine</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="edit_vaccine" name="edit_vaccine" value="edit_vaccine" {{ $role->hasPermissionTo('edit_vaccine') ? 'checked' : ''}}>
                                <label for="edit_vaccine" class="custom-control-label">Edit Vaccine</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="delete_vaccine" name="delete_vaccine" value="delete_vaccine" {{ $role->hasPermissionTo('delete_vaccine') ? 'checked' : ''}}>
                                <label for="delete_vaccine" class="custom-control-label">Delete Vaccine</label>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <h5>Faskes</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="view_faskes" name="view_faskes" value="view_faskes" {{ $role->hasPermissionTo('view_faskes') ? 'checked' : ''}}>
                                <label for="view_faskes" class="custom-control-label">View Faskes</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="add_faskes" name="add_faskes" value="add_faskes" {{ $role->hasPermissionTo('add_faskes') ? 'checked' : ''}}>
                                <label for="add_faskes" class="custom-control-label">Add Faskes</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="edit_faskes" name="edit_faskes" value="edit_faskes" {{ $role->hasPermissionTo('edit_faskes') ? 'checked' : ''}}>
                                <label for="edit_faskes" class="custom-control-label">Edit Faskes</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="delete_faskes" name="delete_faskes" value="delete_faskes" {{ $role->hasPermissionTo('delete_faskes') ? 'checked' : ''}}>
                                <label for="delete_faskes" class="custom-control-label">Delete Faskes</label>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <h5>General Setting</h5>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="general_setting" name="general_setting" value="general_setting" {{ $role->hasPermissionTo('general_setting') ? 'checked' : ''}}>
                                <label for="general_setting" class="custom-control-label">General Setting</label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                
                
                <div class="row">
                    <div class="form-group">
                        <a class="btn btn-default"  href="{{route('user_group.index')}}">Back</a>
                        <button class="btn btn-primary"  id="page-btn-save" type="button">Save</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <!-- /.card -->

</section>
@endsection

@section('script')
<script>
$('body').on('keydown', '#form-page', function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
        simpanByForm('#form-page');
        return false;
    }
});


$('#page-btn-save').on('click', function (e) {
    e.preventDefault();
    simpanByForm('#form-page');
})
</script>
@endsection