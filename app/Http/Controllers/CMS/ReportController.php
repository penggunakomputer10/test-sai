<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function index(){
        
        if(!auth()->user()->can('view_report')){
            return \Helper::forbidden();
        }
        $module_name = 'Report';
        $breadcrumb  = true;
        $breadcrumbs = [
            [
                'name'      => 'Report',
                'link'      => route('report.index'),
                'active'    => false
            ],
            [
                'name' => 'Index',
                'link' => '#',
                'active'    => true  
            ]
        ];


        return view('administrator.report.index',compact('module_name','breadcrumb','breadcrumbs'));
    }

    
}
