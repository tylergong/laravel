<?php

namespace App\Http\Controllers\Admin;

use App\Models\ChannelModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChannelController extends Controller {

	public function __construct() {
		$this->middleware('auth.admin:admin');
	}

	// 列表页面(默认显示页)
	// GET
	// /admin/channel
	public function index(Request $request) {
		if($request->ajax()) {
			$list['data'] = ChannelModel::get()
				->toArray();
			die(json_encode($list));
		} else {
			return view('admin.channel.list');
		}
	}

	// 创建(显示表单)
	// GET
	// /admin/channel/create
	public function create() {
		// 初始化默认数据
		$detail = [
			'id' => 0,
			'cname' => '',
			'is_show' => 1,
		];
		return view('admin.channel.create', compact('detail'));
	}

	// 保存创建数据
	// POST
	// /admin/channel
	public function store(Request $request) {
		$code = -1;
		$msg = 'error';

		$data = $request->all();
		$detail['cname'] = $data['cname'];
		$detail['is_show'] = $data['is_show'];
		$res = ChannelModel::create($detail);
		if($res->id > 0) {
			$code = 0;
			$msg = 'ok';
		}
		die(json_encode(array(
			'code' => $code,
			'msg' => $msg
		)));
	}

	// 编辑(显示表单)
	// GET
	// /admin/channel/{id}/edit
	public function edit($id) {
		$detail = ChannelModel::find($id)
			->toArray();
		return view('admin.channel.create', compact('detail'));
	}

	// 保存编辑数据
	// PUT\PATCH
	// /admin/channel/{id}
	public function update(Request $request, $id) {
		$code = -1;
		$msg = 'error';

		$data = $request->all();
		$detail = ChannelModel::find($id);
		$detail->cname = $data['cname'];
		$detail->is_show = $data['is_show'];
		$res = $detail->save();
		if($res) {
			$code = 0;
			$msg = 'ok';
		}
		die(json_encode(array(
			'code' => $code,
			'msg' => $msg
		)));
	}

	// 删除数据
	// DELETE
	// /admin/channel/{id}
	public function destroy($id) {
		$code = -1;
		$msg = 'error';

		$res = ChannelModel::destroy($id);
		if($res) {
			$code = 0;
			$msg = 'ok';
		}
		die(json_encode(array(
			'code' => $code,
			'msg' => $msg
		)));
	}

	// 显示数据
	// GET
	// /admin/channel/{id}
	public function show() {
		return false;
	}
}
