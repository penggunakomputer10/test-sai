<?php

namespace App\Services;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class UserService implements BaseServiceInterface{
    protected $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function getData($order='DESC',$pagination=null){

    }
    public function getById($id){
        return $this->userRepository->getById($id);
    }
    public function store($data){
        $array = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ];

        if(isset($data['image'])){
            $array += ['image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'];
        }

        if(isset($data['user_group'])){
            $array += ['user_group' => 'required'];
        }
        $validator = Validator::make($data, $array);

        if ($validator->fails()) { 
            throw new InvalidArgumentException($validator->errors());
        }
        try {
            
            $result = $this->userRepository->store($data);
            
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'success' => false,
                'code'    => $e->getCode(),
                'message' => $e->getMessage(),
                'errors'  => $e->getMessage()
            ]);
        }

        return $result;
    }
    public function update($data,$id){
        
        $array = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ];
        
        
        if(isset($data['image'])){
            $array += ['image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'];
        }
        
        if(isset($data['user_group'])){
            $array += ['user_group' => 'required'];
        }
        
        $validator = Validator::make($data, $array);
        
        if ($validator->fails()) { 
            throw new InvalidArgumentException($validator->errors());
        }
        $result = $this->userRepository->update($data,$id);
        return $result;

    }

    public function update_profile($data,$id){
        
        $array = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ];
        
        
        if(isset($data['image'])){
            $array += ['image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'];
        }
        
        if(isset($data['user_group'])){
            $array += ['user_group' => 'required'];
        }

        if(isset($data['password'])){
            $array += ['password' => 'required|confirmed'];
        }
        
        $validator = Validator::make($data, $array);
        
        if ($validator->fails()) { 
            throw new InvalidArgumentException($validator->errors());
        }
        $result = $this->userRepository->update($data,$id);
        return $result;

    }

    public function destroy($id){
        return $this->userRepository->destroy($id);

    }
    public function table($data){
        return $this->userRepository->table($data);
    }

    public function updatePermission($request,$id){
        return $this->userRepository->updatePermission($request,$id);
    }


}