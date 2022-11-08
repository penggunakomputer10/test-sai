<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProvinceService;
class ProvinceController extends Controller
{
    protected $provinceService;
    public function __construct(ProvinceService $provinceService){
        $this->provinceService = $provinceService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!auth()->user()->can('view_province')){
            return \Helper::forbidden();
        }
        $module_name = 'Province';
        $breadcrumb  = true;
        $breadcrumbs = [
            [
                'name'      => 'Province',
                'link'      => route('province.index'),
                'active'    => false
            ],
            [
                'name' => 'Index',
                'link' => '#',
                'active'    => true  
                ]
            ];

        return view('administrator.province.index',compact('module_name','breadcrumb','breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->can('add_province')){
            return 403;
        }
        $data = null;
        return view('administrator.province.form',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->can('add_province')){
            return 403;
        }
        try {
            $action = $this->provinceService->store($request->all());
            $result['success'] = true;
            $result['code']    = 201;
            $result['message'] = $action->name.' has been saved';
            $result['data'] = $action;
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!auth()->user()->can('edit_province')){
            return 403;
        }
        $data = $this->provinceService->getById($id);
        return view('administrator.province.form',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!auth()->user()->can('edit_province')){
            return 403;
        }
        try {
            $action = $this->provinceService->update($request->all(),$id);
            $result['success'] = true;
            $result['code']    = 200;
            $result['message'] = $action->name.' has been updated';
            $result['data'] = $action;
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!auth()->user()->can('delete_province')){
            return 403;
        }
        try {
            $result['success'] = true;
            $result['code']    = 200;
            $action = $this->provinceService->destroy($id);
            $result['message'] = ' has been deleted!';
            $result['data'] = $action;
        } catch (Exception $e) {
            //throw $th;
            $result = [
                'success'     => false,
                'code'        => $e->getCode(),
                'message'     => $e->getMessage(),
                'errors'      => $e->getMessage()
            ];
        }

        return $result;
    }

    public function table(Request $request){
        $json_data = $this->provinceService->table($request);
        echo json_encode($json_data); 
    }

    public function permission($group_id){
        if(!auth()->user()->can('permission_province')){
            return \Helper::forbidden();
        }
        if($group_id == 1){
            return \Helper::forbidden();
        }
        $role = $this->provinceService->getById($group_id);
        $module_name = 'Province';
        $breadcrumb  = true;
        $breadcrumbs = [
            [
                'name'      => 'Province',
                'link'      => route('province.index'),
                'active'    => false
            ],
            [
                'name' => $role->name,
                'link' => '#',
                'active'    => true  
                ]
            ];

        if(!auth()->user()->can('view_province')){
            return \Helper::forbidden();
        }

        return view('administrator.province.permission',compact('module_name','breadcrumb','breadcrumbs','role'));
    }

    public function permission_update(Request $request,$id){
        if(!auth()->user()->can('permission_province')){
            return \Helper::forbidden();
            
        }
        try {
            $result['success'] = true;
            $result['code']    = 200;
            $action = $this->provinceService->updatePermission($request,$id);
            $result['message'] = $action->name.' permission has been updated';
            $result['data'] = $action;
        } catch (Exception $e) {
            //throw $th;
            $result = [
                'success'     => false,
                'code'        => 400,
                'errors'      => $e->getMessage()
            ];
        }

        return $result;
    }

    public function select2(Request $request){
        $response = $this->provinceService->select2($request);

        echo json_encode($response);
    }
}
