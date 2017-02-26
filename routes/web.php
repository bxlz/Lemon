<?php

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
use Illuminate\Support\Facades\Auth;
/*
Route::get('/', function () {
    //return view('welcome');
    //dd(0);
    return view('User.login');
});
Auth::routes();

Route::get('/home', 'HomeController@index');*/

Route::get('/', function () {
    if (Auth::guard('user')->check()) {
        return redirect('user/home');
    }else{
        return redirect('user/login');
    }
});
Route::get('tool/code', 'ToolController@captcha');
Route::post('tool/captchaJudge','ToolController@captchaJudge');
Route::group(['prefix' => 'user','namespace' => 'User'],function($route){
    $route->post('login','LoginController@login');
    $route->get('login', 'LoginController@showLoginForm')->name('user.login');
    $route->post('checkIfExist', 'LoginController@checkIfExist');
});
Route::group(['prefix' => 'user','namespace' => 'User', 'middleware' => 'auth.user:user'],function ($router)
{
    //登出
    $router->get('logout', 'LoginController@logout');
    $router->post('logout', 'LoginController@logout');

    $router->get('home', 'HomeController@index');
    $router->get('user', 'UserController@index');
    $router->post('editUser','UserController@editUser');
    $router->post('deleteUser','UserController@deleteUser');
});
