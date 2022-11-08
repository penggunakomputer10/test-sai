<?php
namespace App\Services;

interface BaseServiceInterface{
    public function getData($order='DESC',$pagination=null);
    public function getById($id);
    public function store($data);
    public function update($data,$id);
    public function destroy($id);
    public function table($data);

}