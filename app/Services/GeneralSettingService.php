<?php

namespace App\Services;
use App\Repositories\GeneralSettingRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class GeneralSettingService{
    protected $generalSettingRepository;

    public function __construct(GeneralSettingRepository $generalSettingRepository){
        $this->generalSettingRepository = $generalSettingRepository;
    }

    public function getData(){
        return $this->generalSettingRepository->getData();
    }
    
    public function update($data){
        
        $array = [
            'app_name' => 'required',
            'company_name' => 'required',
            'copy_right' => 'required',
        ];
        
        $validator = Validator::make($data, $array);
        
        if ($validator->fails()) { 
            throw new InvalidArgumentException($validator->errors());
        }
        return $this->generalSettingRepository->update($data);

    }
}