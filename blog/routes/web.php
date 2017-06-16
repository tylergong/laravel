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

Route::get('/', function() {
	return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')
	 ->name('home');

// 前台需要验证登录的请求
Route::group(['middleware' => 'auth'], function() {
	Route::resource('/vueTable', 'Tables\VueTablesController');

	Route::resource('/dataTable', 'Tables\DataTablesController');
	Route::post('/dataTable/setStatus', 'Tables\DataTablesController@setStatus');
	Route::post('/dataTable/setPushNum', 'Tables\DataTablesController@setPushNum');
	Route::post('/dataTable/setStop', 'Tables\DataTablesController@setStop');
	Route::post('/dataTable/setShowList', 'Tables\DataTablesController@setShowList');
	Route::post('/dataTable/setOrderBy', 'Tables\DataTablesController@setOrderBy');

	Route::resource('/dataTableService', 'Tables\DataTableServiceController');
});


// 后台登录 退出
Route::group(['prefix' => 'admin',
			  'namespace' => 'Admin'], function($router) {
	$router->get('login', 'LoginController@showLoginForm')
		   ->name('admin.login');
	$router->post('login', 'LoginController@login');
	$router->post('logout', 'LoginController@logout')
		   ->name('admin.logout');

	$router->get('/', 'DashboardController@index');
	$router->get('dash', 'DashboardController@index');
});

//// 后台需要验证登录的请求
Route::group(['middleware' => 'auth:admin'], function() {

	Route::resource('admin/dataTable2', 'Admin\DataTables2Controller');
});