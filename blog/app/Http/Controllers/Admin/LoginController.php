<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller {

	/**
	 * |--------------------------------------------------------------------------
	 * | Login Controller
	 * |--------------------------------------------------------------------------
	 * |
	 * | This controller handles authenticating users for the application and
	 * | redirecting them to your home screen. The controller uses a trait
	 * | to conveniently provide its functionality to your applications.
	 * |
	 */

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login / registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/admin/dash';
	protected $username;

	/**
	 * Create a new controller instance.
	 * LoginController constructor.
	 */
	public function __construct() {
		$this->middleware('guest:admin', ['except' => 'logout']);
		$this->username = config('admin.global.username');
	}

	/**
	 * 重写登录视图页面
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showLoginForm() {
		return view('admin.auth.login');
	}

	/**
	 * 重写退出方法
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function logout(Request $request) {

		$this->guard()
			 ->logout();

		//$request->session()->flush();

		//$request->session()->regenerate();

		return redirect($this->redirectPath());
	}

	/**
	 * 自定义认证驱动
	 *
	 * @return mixed
	 */
	protected function guard() {
		return auth()->guard('admin');
	}
}
