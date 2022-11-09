<?php

namespace App\Services;
use App\Repositories\FaskesRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class FaskesService implements BaseServiceInterface{
    protected $faskesRepository;

    public function __construct(FaskesRepository $faskesRepository){
        $this->faskesRepository = $faskesRepository;
    }

    public function getData($order='DESC',$pagination=null){
        return $this->faskesRepository->getData($order,$pagination);
    }

   
    public function getById($id){
        return $this->faskesRepository->getById($id);
    }


    public function store($data){
        $validator = Validator::make($data, [
            'name'         => 'required',
            'type'         => 'required',
            'province_id'  => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'telephone' => 'required|numeric',
        ]);
        // dd($validator->errors());

        

        // dd($data['vaccine_id']);
        if ($validator->fails()) { 
            throw new InvalidArgumentException($validator->errors());
        }

        if(!isset($data['vaccine_id'])){
            return [
                'success' => false,
                'code'    => 400,
                'message' => 'Vaccine belum di input'
            ];
        }

        $duplicate = array_diff_assoc($data['vaccine_id'], array_unique($data['vaccine_id']));

        if(count($duplicate) > 0){
            return [
                'success' => false,
                'code'    => 400,
                'message' => 'tidak boleh ada vaccine yang sama di satu faskes'
            ];
        }

        foreach($data['quota'] as $q){
            if($q == null){
                return [
                    'success' => false,
                    'code'    => 400,
                    'message' => 'quota blm di input'
                ]; 
            }
        }
        $result = $this->faskesRepository->store($data);
        return $result;
    }
    public function update($data,$id){
        $validator = Validator::make($data, [
            'name'         => 'required',
            'type'         => 'required',
            'province_id'  => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'telephone' => 'required|numeric',
        ]);

        if ($validator->fails()) { 
            throw new InvalidArgumentException($validator->errors());
        }
        $result = $this->faskesRepository->update($data,$id);
        return $result;

    }
    public function destroy($id){
        return $this->faskesRepository->destroy($id);

    }
    public function table($data){
        return $this->faskesRepository->table($data);
    }

    public function dashboard(){
        return $this->faskesRepository->dashboard();
    }

    public function getReport($request){
        return $this->faskesRepository->getReport($request);
    }

  

  

}