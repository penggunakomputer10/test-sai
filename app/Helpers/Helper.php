<?php
namespace App\Helpers;
use App\Models\GeneralSetting;
class Helper {

    // admin cms sidemenu
    public static function sideMenu(){
        $menu = file_get_contents(base_path('resources/json/Menu.json'));
        $menu = json_decode($menu);
        return $menu;
    }


    // cek url
    public static function path_url(){
        $path_arr = [];
            foreach(explode('/',request()->path()) as $key => $p){
            $path_arr[$key] = $p;
        }
        return $path_arr;
    }


    public static function forbidden(){
        return view('administrator.error.403',[
            'module_name' => 'Forbidden',
            'breadcrumb'  => false,
            'breadcrumbs' => []
        ]);

    }

    public static function api_pagination($format_data, $pagging){
        $datapagging = [
            'pagination'       => [
                'total'         => $pagging->total(),
                'count'         => $pagging->count(),
                'per_page'      => $pagging->perPage(),
                'current_page'  => $pagging->currentPage(),
                'total_pages'   => $pagging->lastPage(),
                'links'         => [
                    'previous'  => $pagging->previousPageUrl(),
                    'next'      => $pagging->nextPageUrl()
                ]
            ]
        ];

        return [
            'data' => $format_data,
            'meta' => $datapagging,
            'draw'    => (request()->draw) ? request()->draw : 1,
            "recordsTotal" => $pagging->total(),
            "recordsFiltered" => $pagging->total(),
        ];
    }


    public static function getGeneralSetting($key){
        $data = GeneralSetting::where('key',$key)->first();
        return $data->value;
    }
}