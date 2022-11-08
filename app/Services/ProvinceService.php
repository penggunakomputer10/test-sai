<?php

namespace App\Services;
use App\Repositories\ProvinceRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class ProvinceService implements BaseServiceInterface{
    protected $provinceRepository;

    public function __construct(ProvinceRepository $provinceRepository){
        $this->provinceRepository = $provinceRepository;
    }

    public function getData($order='DESC',$pagination=null){

    }
    public function getById($id){
        return $this->provinceRepository->getById($id);
    }
    public function store($data){
        $validator = Validator::make($data, [
            'name' => 'required',
        ]);

        if ($validator->fails()) { 
            throw new InvalidArgumentException($validator->errors());
        }
        $result = $this->provinceRepository->store($data);
        return $result;
    }
    public function update($data,$id){
        $validator = Validator::make($data, [
            'name' => 'required'
            
        ]);

        if ($validator->fails()) { 
            throw new InvalidArgumentException($validator->errors());
        }
        $result = $this->provinceRepository->update($data,$id);
        return $result;

    }
    public function destroy($id){
        return $this->provinceRepository->destroy($id);

    }
    public function table($data){
        return $this->provinceRepository->table($data);
    }

    public function select2($request){
        return $this->provinceRepository->select2($request);
    }

}