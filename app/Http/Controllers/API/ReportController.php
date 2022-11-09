<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FaskesService;

class ReportController extends Controller
{
    protected $faskesService;
    public function __construct(FaskesService $faskesService){
        $this->faskesService = $faskesService;
    }
    public function get(Request $request){
        return $this->faskesService->getReport($request);
    }


    

}
