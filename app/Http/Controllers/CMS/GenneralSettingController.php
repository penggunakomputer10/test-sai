<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GeneralSettingService;
class GenneralSettingController extends Controller
{
    protected $generalSettingService;
    public function __construct(GeneralSettingService $generalSettingService){
        $this->generalSettingService = $generalSettingService;
    }

    public function index(){
        
        if(!auth()->user()->can('general_setting')){
            return \Helper::forbidden();
        }
        $module_name = 'Setting';
        $breadcrumb  = true;
        $breadcrumbs = [
            [
                'name'      => 'Setting',
                'link'      => '#',
                'active'    => true
            ],
            [
                'name'      => 'Genneral Setting',
                'link'      => '#',
                'active'    => true
            ]
        ];
        $data = $this->getData();
        return view('administrator.general_setting.index',compact('module_name','breadcrumb','breadcrumbs','data'));
    }


    private function getData(){
        $data = [];

        foreach ($this->generalSettingService->getData() as $g) {
            $data[$g->key] = $g->value;
        }

        return $data;
    }

    public function update(Request $request){
        try {
            $result = $this->generalSettingService->update($request->all());
        } catch (\Exception $e) {
            //throw $th;
            $result = [
                'success'     => false,
                'code'        => ($e->getCode()== 0 ? 422 : $e->getCode()),
                'message'     => ($e->getCode()== 0 ? 'Error Validation' : $e->getMessage()),
                'errors'      => $e->getMessage()
            ];
        }
        return $result;
    }
}
