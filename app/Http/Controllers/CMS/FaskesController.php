<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FaskesService;
class FaskesController extends Controller
{
    protected $faskesService, $type;
    public function __construct(FaskesService $faskesService){
        $this->faskesService = $faskesService;
        $this->type = ['rumah sakit','puskesmas','klinik'];

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!auth()->user()->can('view_faskes')){
            return \Helper::forbidden();
        }
        $module_name = 'Faskes';
        $breadcrumb  = true;
        $breadcrumbs = [
            [
                'name'      => 'Faskes',
                'link'      => route('faskes.index'),
                'active'    => false
            ],
            [
                'name' => 'Index',
                'link' => '#',
                'active'    => true  
                ]
            ];

        return view('administrator.faskes.index',compact('module_name','breadcrumb','breadcrumbs'));
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->can('add_faskes')){
            return 403;
        }
        $data = null;
        $type = $this->type;
        $module_name = 'Faskes';
        $breadcrumb  = true;
        $breadcrumbs = [
            [
                'name'      => 'Faskes',
                'link'      => route('faskes.index'),
                'active'    => false
            ],
            [
                'name'      => 'Create',
                'link'      => '#',
                'active'    => true
            ]
        ];
        return view('administrator.faskes.form',compact('data','type','module_name','breadcrumb','breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->can('add_faskes')){
            return 403;
        }
        try {
            $result = $this->faskesService->store($request->all());
            
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

    public function getBySlug($slug){
       return $this->faskesService->getBySlug($slug);
    }

    public function row(){
        $uniqId = \Str::random(40);
        return view('administrator.faskes.row',compact('uniqId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!auth()->user()->can('edit_faskes')){
            return 403;
        }
        $data = $this->faskesService->getById($id);
        $type = $this->type;
        $module_name = 'Faskes';
        $breadcrumb  = true;
        $breadcrumbs = [
            [
                'name'      => 'Faskes',
                'link'      => route('faskes.index'),
                'active'    => false
            ],
            [
                'name'      => 'Edit '. $data->name,
                'link'      => '#',
                'active'    => true
            ]
        ];

        return view('administrator.faskes.form',compact('data','type','module_name','breadcrumb','breadcrumbs'));
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
        if(!auth()->user()->can('edit_faskes')){
            return 403;
        }
        try {
            $action = $this->faskesService->update($request->all(),$id);
            $result['success'] = true;
            $result['code']    = 200;
            $result['message'] = $action['message'];
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
        if(!auth()->user()->can('delete_faskes')){
            return 403;
        }
        try {
            $result['success'] = true;
            $result['code']    = 200;
            $action = $this->faskesService->destroy($id);
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
        $json_data = $this->faskesService->table($request);
        echo json_encode($json_data); 
    }

}
