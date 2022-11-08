<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!auth()->user()->can('view_user')){
            return \Helper::forbidden();
        }
        $module_name = 'User';
        $breadcrumb  = true;
        $breadcrumbs = [
            [
                'name'      => 'User',
                'link'      => route('users.index'),
                'active'    => false
            ],
            [
                'name' => 'Index',
                'link' => '#',
                'active'    => true  
                ]
            ];

        return view('administrator.user.index',compact('module_name','breadcrumb','breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->can('add_user')){
            return 403;
        }
        $data = null;
        return view('administrator.user.form',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->can('add_user')){
            return 403;
        }
        try {
            $result = $this->userService->store($request->all());
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
        if(!auth()->user()->can('edit_user')){
            return 403;
        }
        $data = $this->userService->getById($id);
        return view('administrator.user.form',compact('data'));
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
        if(!auth()->user()->can('edit_user')){
            return 403;
        }
        try {
            $result = $this->userService->update($request->all(),$id);
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
        if(!auth()->user()->can('delete_user')){
            return 403;
        }
        try {
            $result = $this->userService->destroy($id);
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
        $json_data = $this->userService->table($request);
        echo json_encode($json_data); 
    }

    public function my_profile(){
        $data = $this->userService->getById(auth()->user()->id);
        $module_name = 'My Profile';
        $breadcrumb  = true;
        $breadcrumbs = [
            [
                'name'      => 'My Profile',
                'link'      => '#',
                'active'    => false
            ],
            [
                'name' => ucwords($data->name),
                'link' => '#',
                'active'    => true  
                ]
            ];

        return view('administrator.user.profile',compact('module_name','breadcrumb','breadcrumbs','data'));
    }

    public function update_profile(Request $request){
        try {
            $result = $this->userService->update_profile($request->all(),auth()->user()->id);
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
