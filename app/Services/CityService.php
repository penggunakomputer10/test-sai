<?php

namespace App\Services;
use App\Repositories\CityRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class CityService implements BaseServiceInterface{
    protected $cityRepository;

    public function __construct(CityRepository $cityRepository){
        $this->cityRepository = $cityRepository;
    }

    public function getData($order='DESC',$pagination=null){

    }
    public function getById($id){
        return $this->cityRepository->getById($id);
    }
    public function store($data){
        $validator = Validator::make($data, [
            'name' => 'required',
            'province_id' => 'required',

        ]);

        if ($validator->fails()) { 
            throw new InvalidArgumentException($validator->errors());
        }
        $result = $this->cityRepository->store($data);
        return $result;
    }
    public function update($data,$id){
        $validator = Validator::make($data, [
            'name' => 'required',
            'province_id' => 'required',

            
        ]);

        if ($validator->fails()) { 
            throw new InvalidArgumentException($validator->errors());
        }
        $result = $this->cityRepository->update($data,$id);
        return $result;

    }
    public function destroy($id){
        return $this->cityRepository->destroy($id);

    }
    public function table($data){
        return $this->cityRepository->table($data);
    }

    public function select2($request){
        return $this->cityRepository->select2($request);
    }

}