<?php

namespace App\Repositories;
use App\Models\Vaccine;
use Carbon\Carbon;
class VaccineRepository implements BaseRepositoryInterface{

    protected $model;
    public function __construct(Vaccine $model){
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
        $model->save();
        return $model->fresh();

    }

    public function update($data,$id){
        $model              = $this->getById($id);;
        $model->name        = $data['name'];
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
            $vaccines = $this->model->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        }else{
            $search = $request->input('search.value'); 
            $query =  $this->model->where('id','LIKE',"%{$search}%")->orWhere('name', 'LIKE',"%{$search}%");
            $count = $query->count();
            $vaccines = $query->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
            $totalFiltered = $count;
        }

        $data = array();

        if(!empty($vaccines)){
            $angka =$start+1;
            foreach ($vaccines as $u){
                $url_edit =  route('vaccine.edit',$u->id);
                $url_delete = route('vaccine.destroy',$u->id);

                $edit = '<a href="'.$url_edit.'" class="btn btn-sm btn-primary small-modal-show btn-edit" title="Edit : '.$u->name.'"><i class="fas fa-edit"></i> </a>';
                $delete = '<a href="'.$url_delete.'" class="btn btn-sm btn-danger sw-delete" title="'.$u->name.'"><i class="fas fa-trash-alt"></i> </a>';
                $nestedData['angka'] = $angka;
                $nestedData['id'] = $u->id;
                $nestedData['name'] = $u->name;
                $nestedData['created_at'] = Carbon::parse($u->created_at)->format('Y-m-d H:i:s');
                $nestedData['action'] = $edit." ".$delete;
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

    public function select2($request){
        $search = $request->search;

        if($search == ''){
            $vaccines =$this->model->orderby('name','asc')->select('id','name')->limit(10)->get();
        }else{
            $vaccines =$this->model->orderby('name','asc')->select('id','name')->where('name', 'like', '%' .$search . '%')->limit(5)->get();
        }

        $response = array();
        foreach($vaccines as $r){
            $response[] = array(
                "id"=>$r->id,
                "text"=>$r->name
            );
        }
        return $response;
    }

}
