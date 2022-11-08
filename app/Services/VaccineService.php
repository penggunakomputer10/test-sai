<?php

namespace App\Services;
use App\Repositories\VaccineRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class VaccineService implements BaseServiceInterface{
    protected $vaccineRepository;

    public function __construct(VaccineRepository $vaccineRepository){
        $this->vaccineRepository = $vaccineRepository;
    }

    public function getData($order='DESC',$pagination=null){

    }
    public function getById($id){
        return $this->vaccineRepository->getById($id);
    }
    public function store($data){
        $validator = Validator::make($data, [
            'name' => 'required',
        ]);

        if ($validator->fails()) { 
            throw new InvalidArgumentException($validator->errors());
        }
        $result = $this->vaccineRepository->store($data);
        return $result;
    }
    public function update($data,$id){
        $validator = Validator::make($data, [
            'name' => 'required'
            
        ]);

        if ($validator->fails()) { 
            throw new InvalidArgumentException($validator->errors());
        }
        $result = $this->vaccineRepository->update($data,$id);
        return $result;

    }
    public function destroy($id){
        return $this->vaccineRepository->destroy($id);

    }
    public function table($data){
        return $this->vaccineRepository->table($data);
    }

    public function select2($request){
        return $this->vaccineRepository->select2($request);
    }

}