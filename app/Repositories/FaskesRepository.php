<?php

namespace App\Repositories;
use App\Models\Faskes;
use App\Models\VaccineFaskes;
use Carbon\Carbon;
use DB;
class FaskesRepository implements BaseRepositoryInterface{

    protected $model;
    public $type;
    public function __construct(Faskes $model){
        $this->model = $model;
        $this->type = ['rumah sakit','puskesmas','klinik'];

    }

    public function getData($order='DESC',$pagination=null){
       
    }

 

    public function getById($id){
        return $this->model->where('id',$id)->first();
    }


    public function store($data){
        DB::beginTransaction();
        try {
            $model                     = new $this->model;
            $model->name               = $data['name'];
            $model->province_id        = $data['province_id'];
            $model->city_id            = $data['city_id'];
            $model->telephone          = $data['telephone'];
            $model->address            = $data['address'];
            $model->type            = $data['type'];

    
            $model->save();
            if($model->save()){
                if (isset($data['vaccine_id'])) {
                    for ($i=0; $i < count($data['vaccine_id']); $i++) { 
                        VaccineFaskes::create([
                            'faskes_id' => $model->id,
                            'vaccine_id'      => $data['vaccine_id'][$i],
                            'quota'      => $data['quota'][$i],
                        ]);
                    }
                }
            }
            DB::commit();

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
        return [
            'success' => true,
            'code'    => 201,
            'message' => $model->name.' has been saved',
            'data'    => $model->fresh()
        ];

    }

    public function update($data,$id){
        $model              = $this->getById($id);
        DB::beginTransaction();
        try {
            $model->name               = $data['name'];
            $model->province_id        = $data['province_id'];
            $model->city_id            = $data['city_id'];
            $model->telephone          = $data['telephone'];
            $model->address            = $data['address'];
            $model->type            = $data['type'];

            if($model->update()){
                if (isset($data['vaccine_id'])) {
                    VaccineFaskes::where('faskes_id',$model->id)->delete();
                    for ($i=0; $i < count($data['vaccine_id']); $i++) { 
                        VaccineFaskes::create([
                            'faskes_id' => $model->id,
                            'vaccine_id'      => $data['vaccine_id'][$i],
                            'quota'      => $data['quota'][$i],
                        ]);
                    }
                }else{
                    VaccineFaskes::where('faskes_id',$model->id)->delete();
                }
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
        return [
            'success' => true,
            'code'    => 200,
            'message' => $model->name.' has been updated',
            'data'    => $model->fresh()
        ];
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
            2 => 'type',
            3 =>'address',
            4 =>'province_id',
            5 =>'city_id',
            6 => 'created_at'
        );

        $totalData = $this->model->count();
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))){
            $categories = $this->model->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        }else{
            $search = $request->input('search.value'); 
            $query =  $this->model->where('id','LIKE',"%{$search}%")->orWhere('name', 'LIKE',"%{$search}%");
            $count = $query->count();
            $categories = $query->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
            $totalFiltered = $count;
        }

        $data = array();

        if(!empty($categories)){
            $angka =$start+1;
            foreach ($categories as $u){
                $url_edit =  route('faskes.edit',$u->id);
                $url_delete = route('faskes.destroy',$u->id);

                $edit = '<a href="'.$url_edit.'" class="btn btn-sm btn-primary" title="Edit : '.$u->name.'"><i class="fas fa-edit"></i> </a>';
                $delete = '<a href="'.$url_delete.'" class="btn btn-sm btn-danger sw-delete" title="'.$u->name.'"><i class="fas fa-trash-alt"></i> </a>';
                $nestedData['angka'] = $angka;
                $nestedData['id'] = $u->id;
                $nestedData['name'] = $u->name;
                $nestedData['type'] = $u->type;

                $nestedData['address'] = $u->address;

                $nestedData['province_id'] = @$u->province->name;
                $nestedData['city_id'] = @$u->city->name;
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

    public function dashboard(){
        $result = [];

        foreach ($this->type as $key => $t) {
            $result['data'][$key]['faskes_name'] = $t;
            $result['data'][$key]['total'] = $this->model->where('type',$t)->count();


        }
        $result['total'] = $this->model->count();

        return $result;
    }

}
