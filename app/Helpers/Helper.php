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

    public function resultOutPut($success, $code,$message,$errors = null,$data =null){
        $result = [
            'success'   => $success,
            'code'      => $code,
            'message'   => $message,
            'errors'    => $errors,
            'data'      => $data,
        ];

        return $result;
    }

    public static function getGeneralSetting($key){
        $data = GeneralSetting::where('key',$key)->first();
        return $data->value;
    }
}