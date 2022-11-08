<?php

namespace App\Repositories;
use Spatie\Permission\Models\Role;
class UserGroupRepository implements BaseRepositoryInterface{

    protected $model;
    public function __construct(Role $model){
        $this->model = $model;
    }

    public function getData($order='DESC',$pagination=null){
        $data = $this->model->orderBy('created_at',$order);
        if($pagination == null){
            return $data->get();
        }else{
            return $data->paginate($pagination);
        }
    }

    public function getById($id){
        return $this->model->where('id',$id)->first();
    }

    public function store($data){
        $model              = new $this->model;
        $model->name        = $data['name'];
        $model->guard_name  = 'web';
        $model->save();
        return $model->fresh();

    }

    public function update($data,$id){
        $model              = $this->getById($id);;
        $model->name        = $data['name'];
        $model->guard_name  = 'web';
        $model->update();
        return $model->fresh();
    }

    public function destroy($id){
        $model = $this->getById($id);;
        $model->delete();
        return $model->fresh();
    }

    public function table($request){

        $columns = array(
            0 =>'id',
            1 =>'name',
            2 => 'created_at'
        );

        $totalData = $this->model->count();
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))){
            $roles = $this->model->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        }else{
            $search = $request->input('search.value'); 
            $query =  $this->model->where('id','LIKE',"%{$search}%")->orWhere('name', 'LIKE',"%{$search}%");
            $count = $query->count();
            $roles = $query->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
            $totalFiltered = $count;
        }

        $data = array();

        if(!empty($roles)){
            $angka =$start+1;
            foreach ($roles as $u){
                $url_edit =  route('user_group.edit',$u->id);
                $url_delete = route('user_group.destroy',$u->id);
                $url_permission = route('user_group.permission',$u->id);

                $permission = '<a href="'.$url_permission.'" class="btn btn-sm btn-default" title="'.$u->name.'"><i class="fas fa-cogs"></i> </a>';
                $edit = '<a href="'.$url_edit.'" class="btn btn-sm btn-primary small-modal-show btn-edit" title="Edit : '.$u->name.'"><i class="fas fa-edit"></i> </a>';
                $delete = '<a href="'.$url_delete.'" class="btn btn-sm btn-danger sw-delete" title="'.$u->name.'"><i class="fas fa-trash-alt"></i> </a>';
                $nestedData['angka'] = $angka;
                $nestedData['id'] = $u->id;
                $nestedData['name'] = $u->name;
                $nestedData['action'] = ($u->id == 1) ? $permission: $permission." ".$edit." ".$delete;
                $data[] = $nestedData;

                $angka++;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
            );

        return $json_data;

    }

    public function updatePermission($request,$id){
        $role = Role::find($id);
        $array = [];
        foreach($request->except(['_token', '_method']) as $a){
            if($a != '_token' OR $a != '_method'){
                array_push($array,$a);
            }
        }

        $role->syncPermissions($array);

        return $role;
    }

    public function select2($request){
        $search = $request->search;

        if($search == ''){
            $roles =$this->model->orderby('name','asc')->select('id','name')->limit(10)->get();
        }else{
            $roles =$this->model->orderby('name','asc')->select('id','name')->where('name', 'like', '%' .$search . '%')->limit(5)->get();
        }

        $response = array();
        foreach($roles as $r){
            $response[] = array(
                "id"=>$r->id,
                "text"=>$r->name
            );
        }
        return $response;
    }

}
