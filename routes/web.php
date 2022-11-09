<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CMS\DashboardController;
use App\Http\Controllers\CMS\UserGroupController;
use App\Http\Controllers\CMS\UserController;
use App\Http\Controllers\CMS\GenneralSettingController;
use App\Http\Controllers\CMS\ProvinceController;
use App\Http\Controllers\CMS\CityController;
use App\Http\Controllers\CMS\VaccineController;
use App\Http\Controllers\CMS\FaskesController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('administrator')->group(function () {
    Auth::routes(['register' => false]);
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Prefix CMS And Middelware
Route::group(['middleware' => ['auth'], 'prefix' => 'administrator'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // User Group
    Route::resource('/user_group', UserGroupController::class);
    Route::get('/user_group/{group_id}/permission/', [UserGroupController::class,'permission'])->name('user_group.permission');
    Route::put('/user_group/permission_update/{group_id}', [UserGroupController::class,'permission_update'])->name('user_group.permission_update');
    Route::post('/table/user_group',[UserGroupController::class, 'table'])->name('user_group.table');
    Route::get('/select2/user_group',[UserGroupController::class, 'select2'])->name('user_group.select2');


    // User 
    Route::resource('/users', UserController::class);
    Route::get('my_profile',[UserController::class,'my_profile'])->name('users.my_profile');
    Route::put('my_profile/update',[UserController::class,'update_profile'])->name('users.update_profile');
    Route::post('/table/users',[UserController::class, 'table'])->name('users.table');

    // General Setting
    Route::get('setting/general',[GenneralSettingController::class,'index'])->name('general.index');
    Route::put('setting/general/update',[GenneralSettingController::class,'update'])->name('general.update');

    Route::resource('/province', ProvinceController::class);
    Route::post('/table/province',[ProvinceController::class, 'table'])->name('province.table');
    Route::get('/select2/province',[ProvinceController::class, 'select2'])->name('province.select2');
    
    Route::resource('/city', cityController::class);
    Route::post('/table/city',[cityController::class, 'table'])->name('city.table');
    Route::get('/select2/city',[cityController::class, 'select2'])->name('city.select2');

    Route::resource('/vaccine', VaccineController::class);
    Route::post('/table/vaccine',[VaccineController::class, 'table'])->name('vaccine.table');
    Route::get('/select2/vaccine',[VaccineController::class, 'select2'])->name('vaccine.select2');

    Route::resource('/faskes', FaskesController::class);
    Route::post('/table/faskes',[FaskesController::class, 'table'])->name('faskes.table');
    Route::get('/row/faskes',[FaskesController::class, 'row'])->name('faskes.row');






});
