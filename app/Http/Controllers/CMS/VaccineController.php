<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VaccineService;
class VaccineController extends Controller
{
    protected $vaccineService;
    public function __construct(VaccineService $vaccineService){
        $this->vaccineService = $vaccineService;
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
        $module_name = 'Vaccine';
        $breadcrumb  = true;
        $breadcrumbs = [
            [
                'name'      => 'Vaccine',
                'link'      => route('vaccine.index'),
                'active'    => false
            ],
            [
                'name' => 'Index',
                'link' => '#',
                'active'    => true  
                ]
            ];

        return view('administrator.vaccine.index',compact('module_name','breadcrumb','breadcrumbs'));
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
        return view('administrator.vaccine.form',compact('data'));
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
            $action = $this->vaccineService->store($request->all());
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
        $data = $this->vaccineService->getById($id);
        return view('administrator.vaccine.form',compact('data'));
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
            $action = $this->vaccineService->update($request->all(),$id);
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
            $action = $this->vaccineService->destroy($id);
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
        $json_data = $this->vaccineService->table($request);
        echo json_encode($json_data); 
    }

    public function permission($group_id){
        if(!auth()->user()->can('permission_province')){
            return \Helper::forbidden();
        }
        if($group_id == 1){
            return \Helper::forbidden();
        }
        $role = $this->vaccineService->getById($group_id);
        $module_name = 'Vaccine';
        $breadcrumb  = true;
        $breadcrumbs = [
            [
                'name'      => 'Vaccine',
                'link'      => route('vaccine.index'),
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

        return view('administrator.vaccine.permission',compact('module_name','breadcrumb','breadcrumbs','role'));
    }

    public function permission_update(Request $request,$id){
        if(!auth()->user()->can('permission_province')){
            return \Helper::forbidden();
            
        }
        try {
            $result['success'] = true;
            $result['code']    = 200;
            $action = $this->vaccineService->updatePermission($request,$id);
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
        $response = $this->vaccineService->select2($request);

        echo json_encode($response);
    }
}
