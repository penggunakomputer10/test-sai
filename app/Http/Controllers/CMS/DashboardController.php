<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FaskesService;

// use App\Helpers\Helper;
class DashboardController extends Controller
{
    protected $faskesService;
    public function __construct(FaskesService $faskesService){
        $this->faskesService = $faskesService;
    }
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

        $faskes = $this->faskesService->dashboard();
        return view('administrator.dashboard.index',compact('module_name','breadcrumb','breadcrumbs','faskes'));
    }
}
