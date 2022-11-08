<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Helpers\Helper;
class DashboardController extends Controller
{
    public function index(){
        if(!auth()->user()->can('view_dashboard')){
            return \Helper::forbidden();
        }
        $module_name = 'Dashboard';
        $breadcrumb  = true;
        $breadcrumbs = [
            [
                'name'      => 'Dashboard',
                'link'      => route('dashboard.index'),
                'active'    => false
            ],
            [
                'name' => 'Index',
                'link' => '#',
                'active'    => true  
            ]
        ];
        return view('administrator.dashboard.index',compact('module_name','breadcrumb','breadcrumbs'));
    }
}
