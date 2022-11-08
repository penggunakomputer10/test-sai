<?php

namespace App\Repositories;
use App\Models\GeneralSetting;
class GeneralSettingRepository                                    {

    protected $model;
    public function __construct(GeneralSetting $model){
        $this->model = $model;
    }

    public function getData($order='DESC',$pagination=null){
       return $this->model::all();
    }

    public function byKey($key){
        return $this->model::where('key',$key)->first();
    }

   

    public function update($data){
       if(isset($data['app_name'])){
           $this->model::where('key', 'app_name')->update(['value' => $data['app_name']]);
       }

       if(isset($data['company_name'])){
           $this->model::where('key', 'company_name')->update(['value' => $data['company_name']]);
       }

       if(isset($data['copy_right'])){
           $this->model::where('key', 'copy_right')->update(['value' => $data['copy_right']]);
       }
       
       return response()->json([
            'success' => true,
            'code'    => 200,
            'message' => 'General setting has been updated successfully',
            'errors'  => null,
            'data'    => $this->getData()
        ]);
        

    }


   

}
