<?php

namespace App\Repositories;
use App\Models\City;
use Carbon\Carbon;
class CityRepository implements BaseRepositoryInterface{

    protected $model;
    public function __construct(City $model){
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
        $model->province_id        = $data['province_id'];

        $model->save();
        return $model->fresh();

    }

    public function update($data,$id){
        $model              = $this->getById($id);;
        $model->name        = $data['name'];
        $model->province_id        = $data['province_id'];
        
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
            1 =>'province_id',
            2 =>'name',
            3 => 'created_at'
        );

        $totalData = $this->model->count();
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))){
            $citys = $this->model->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        }else{
            $search = $request->input('search.value'); 
            $query =  $this->model->where('id','LIKE',"%{$search}%")->orWhere('name', 'LIKE',"%{$search}%");
            $count = $query->count();
            $citys = $query->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
            $totalFiltered = $count;
        }

        $data = array();

        if(!empty($citys)){
            $angka =$start+1;
            foreach ($citys as $u){
                $url_edit =  route('city.edit',$u->id);
                $url_delete = route('city.destroy',$u->id);

                $edit = '<a href="'.$url_edit.'" class="btn btn-sm btn-primary small-modal-show btn-edit" title="Edit : '.$u->name.'"><i class="fas fa-edit"></i> </a>';
                $delete = '<a href="'.$url_delete.'" class="btn btn-sm btn-danger sw-delete" title="'.$u->name.'"><i class="fas fa-trash-alt"></i> </a>';
                $nestedData['angka'] = $angka;
                $nestedData['id'] = $u->id;
                $nestedData['name'] = $u->name;
                $nestedData['province_id'] = ($u->province) ? $u->province->name : null;
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
        $province_id = $request->province_id;


        $citys =$this->model->orderby('name','asc')->select('id','name');

        if($request->search){
            $citys = $citys->where('name', 'like', '%' .$search . '%');
        }

        if($request->province_id){
            $citys = $citys->where('province_id',$province_id);
        }

        $citys = $citys->limit(10)->get();

        $response = array();
        foreach($citys as $r){
            $response[] = array(
                "id"=>$r->id,
                "text"=>$r->name
            );
        }
        return $response;
    }

}
