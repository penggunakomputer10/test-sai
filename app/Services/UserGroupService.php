<?php

namespace App\Services;
use App\Repositories\UserGroupRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class UserGroupService implements BaseServiceInterface{
    protected $userGroupRepository;

    public function __construct(UserGroupRepository $userGroupRepository){
        $this->userGroupRepository = $userGroupRepository;
    }

    public function getData($order='DESC',$pagination=null){

    }
    public function getById($id){
        return $this->userGroupRepository->getById($id);
    }
    public function store($data){
        $validator = Validator::make($data, [
            'name' => 'required|unique:roles',
        ]);

        if ($validator->fails()) { 
            throw new InvalidArgumentException($validator->errors());
        }
        $result = $this->userGroupRepository->store($data);
        return $result;
    }
    public function update($data,$id){
        $validator = Validator::make($data, [
            'name' => 'required|unique:roles,name,'.$id,
            
        ]);

        if ($validator->fails()) { 
            throw new InvalidArgumentException($validator->errors());
        }
        $result = $this->userGroupRepository->update($data,$id);
        return $result;

    }
    public function destroy($id){
        return $this->userGroupRepository->destroy($id);

    }
    public function table($data){
        return $this->userGroupRepository->table($data);
    }

    public function select2($request){
        return $this->userGroupRepository->select2($request);
    }

    public function updatePermission($request,$id){
        return $this->userGroupRepository->updatePermission($request,$id);
    }


}