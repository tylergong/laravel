<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProFileController extends Controller {

	protected $redirectTo = '/admin';

	public function __construct() {
		$this->middleware('auth.admin:admin');
	}

	// 编辑(显示表单)
	// GET
	// /admin/profile/{id}/edit
	public function edit($id) {
		$user = $this->guard()
			->user();
		if($user->id == $id) {
			$detail = Admin::find($id)
				->toArray();
			return view('admin.profile.create', compact('detail'));
		} else {
			return view('admin.404');
		}
	}

	// 保存编辑数据
	// PUT\PATCH
	// /admin/profile/{id}
	public function update(Request $request, $id) {
		$code = 0;
		$msg = '修改成功';
		$user = $this->guard()
			->user();
		if($user->id == $id) {
			$detail = Admin::find($id);
			$detail->name = $request->input('name', '');
			$detail->email = $request->input('email', '');
			$res = $detail->save();
			if(!$res) {
				$code = -1;
				$msg = '修改失败';
			}
		} else {
			$code = -2;
			$msg = '当前用户无权修改';
		}

		die(json_encode(array(
			'code' => $code,
			'msg' => $msg
		)));
	}

	// 显示密码重设页面
	public function showResetPassport($id) {
		$user = $this->guard()
			->user();
		if($user->id == $id) {
			$detail = array(
				'id' => $id,
				'token' => $user->getRememberToken()
			);
			return view('admin.profile.reset', compact('detail'));
		} else {
			return view('admin.404');
		}
	}

	// 重设密码
	public function resetPassport(Request $request, $id) {
		$code = 0;
		$msg = 'ok';
		$user = $this->guard()
			->user();
		if($user->id == $id) {
			$credentials = $this->credentials($request);
			$is_ok = $this->validatePasswordWithDefaults($credentials);
			if($is_ok) {
				$this->resetPassword($user, $credentials['password']);
			} else {
				$code = -1;
				$msg = '二次密码不匹配,或长度小于6位';
			}
		} else {
			$code = -2;
			$msg = '当前用户无权修改';
		}
		die(json_encode(array(
			'code' => $code,
			'msg' => $msg
		)));
	}

	/**
	 * Determine if the passwords are valid for the request.
	 *
	 * @param  array $credentials
	 *
	 * @return bool
	 */
	protected function validatePasswordWithDefaults(array $credentials) {
		list($password, $confirm) = [
			$credentials['password'],
			$credentials['password_confirmation'],
		];

		return $password === $confirm && mb_strlen($password) >= 6;
	}

	/**
	 * Get the password reset credentials from the request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return array
	 */
	protected function credentials(Request $request) {
		return $request->only('password', 'password_confirmation');
	}

	/**
	 * Reset the given user's password.
	 *
	 * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
	 * @param  string                                      $password
	 *
	 * @return void
	 */
	protected function resetPassword($user, $password) {
		$user->forceFill([
			'password' => bcrypt($password),
			'remember_token' => Str::random(60),
		])
			->save();

		$this->guard()
			->login($user);
	}

	/**
	 * Get the guard to be used during password reset.
	 *
	 * @return \Illuminate\Contracts\Auth\StatefulGuard
	 */
	protected function guard() {
		return Auth::guard('admin');
	}
}
