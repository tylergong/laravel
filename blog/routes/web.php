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

Route::get('/', function () {
	return view('welcome');
});

Route::post('/file/upload', 'UploadsController@uploadFile');

Auth::routes();

// 前台需要验证登录的请求
Route::group(['middleware' => 'auth'], function () {

	Route::resource('/home', 'HomeController');

	Route::resource('/vueTable', 'Tables\VueTablesController');

	Route::resource('/dataTable', 'Tables\DataTablesController');
	Route::post('/dataTable/setStatus', 'Tables\DataTablesController@setStatus');
	Route::post('/dataTable/setPushNum', 'Tables\DataTablesController@setPushNum');
	Route::post('/dataTable/setStop', 'Tables\DataTablesController@setStop');
	Route::post('/dataTable/setShowList', 'Tables\DataTablesController@setShowList');
	Route::post('/dataTable/setOrderBy', 'Tables\DataTablesController@setOrderBy');

	Route::resource('/dataTableService', 'Tables\DataTableServiceController');
});


// 后台登录 退出 及其各项操作
//	[	prefix  前缀匹配包含 "/admin/login" 的 URL  ;
// 		namespace  在 "App\Http\Controllers\Admin" 命名空间下的控制器	]
Route::group([
	'prefix' => 'admin',
	'namespace' => 'Admin'
], function () {
	Route::get('login', 'LoginController@showLoginForm')
		->name('admin.login');
	Route::post('login', 'LoginController@login');
	Route::post('logout', 'LoginController@logout')
		->name('admin.logout');

	Route::get('/', 'DashboardController@index');
	Route::get('dash', 'DashboardController@index');

	// 后台需要验证登录的请求
	Route::group(['middleware' => 'auth:admin'], function () {

		Route::resource('channel', 'ChannelController');

		Route::get('article/getDetail', 'ArticleController@getDetail');
		Route::resource('article', 'ArticleController');

		Route::resource('articleRecycle', 'ArticleRecycleController');

		Route::resource('ad', 'AdvertisementController');

		Route::put('fl/setSort', 'FriendLinkController@setSort');
		Route::resource('fl', 'FriendLinkController');

		Route::resource('static', 'StaticController');

		Route::get('profile/reset/{id}', 'ProFileController@showResetPassport');
		Route::post('profile/reset/{id}', 'ProFileController@resetPassport');
		Route::resource('profile', 'ProFileController');

	});
});

