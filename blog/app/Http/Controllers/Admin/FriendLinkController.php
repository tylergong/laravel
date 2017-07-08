<?php

namespace App\Http\Controllers\Admin;

use App\Models\FriendLinksModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FriendLinkController extends Controller {

	public function __construct() {
		$this->middleware('auth.admin:admin');
	}

	// 列表页面(默认显示页)
	// GET
	// /admin/ad
	public function index(Request $request) {
		if($request->ajax()) {
			$list['data'] = FriendLinksModel::orderBy('orderby', 'desc')
				->get()
				->toArray();
			die(json_encode($list));
		} else {
			return view('admin.fl.list');
		}
	}

	// 创建(显示表单)
	// GET
	// /admin/ad/create
	public function create() {
		// 初始化默认数据
		$detail = [
			'id' => 0,
			'fname' => '',
			'flink' => '',
			'is_show' => 0,
		];
		return view('admin.fl.create', compact('detail'));
	}

	// 保存创建数据
	// POST
	// /admin/ad
	public function store(Request $request) {
		$rtn = array(
			'code' => 0,
			'msg' => 'error'
		);

		$detail['fname'] = $request->input('fname', '');
		$detail['flink'] = $request->input('flink', '');
		$detail['is_show'] = $request->input('is_show', 0);

		$res = FriendLinksModel::create($detail);

		if($res->id > 0) {
			// 更新排序
			$detail['orderby'] = $res->id;
			$detail->save();

			$rtn = array(
				'code' => 1,
				'msg' => 'ok'
			);
		}
		die(json_encode($rtn));
	}

	// 编辑(显示表单)
	// GET
	// /admin/ad/{id}/edit
	public function edit($id) {
		$detail = FriendLinksModel::find($id)
			->toArray();
		return view('admin.fl.create', compact('detail'));
	}

	// 保存编辑数据
	// PUT\PATCH
	// /admin/ad/{id}
	public function update(Request $request, $id) {
		$rtn = array(
			'code' => 0,
			'msg' => 'error'
		);

		$detail = FriendLinksModel::find($id);
		$detail->fname = $request->input('fname', '');
		$detail->flink = $request->input('flink', '');
		$detail->is_show = $request->input('is_show', 0);
		$res = $detail->save();

		if($res) {
			$rtn = array(
				'code' => 1,
				'msg' => 'ok'
			);
		}
		die(json_encode($rtn));
	}

	// 删除数据
	// DELETE
	// /admin/ad/{id}
	public function destroy($id) {
		$rtn = array(
			'code' => 0,
			'msg' => 'error'
		);

		$res = FriendLinksModel::destroy($id);
		if($res) {
			$rtn = array(
				'code' => 1,
				'msg' => 'ok'
			);
		}
		die(json_encode($rtn));
	}

	// 显示数据
	// GET
	// /admin/ad/{id}
	public function show() {
		return false;
	}

	// 移动显示顺序
	public function setSort(Request $request) {
		$rtn = array(
			'code' => 0,
			'msg' => 'error'
		);

		$id = $request->input('id', '');
		$opt = $request->input('opt', '');
		$detail = FriendLinksModel::find($id);

		if($opt == 'up') {
			$ex_detail = FriendLinksModel::where('orderby', '>', $detail->orderby)
				->orderBy('orderby', 'asc')
				->first();
		} else {
			$ex_detail = FriendLinksModel::where('orderby', '<', $detail->orderby)
				->orderBy('orderby', 'desc')
				->first();
		}
		if($ex_detail) {
			$tmp = $detail->orderby;
			$detail->orderby = $ex_detail->orderby;
			$ex_detail->orderby = $tmp;
			$detail->save();
			$ex_detail->save();

			$rtn = array(
				'code' => 1,
				'msg' => 'ok'
			);
		}
		die(json_encode($rtn));
	}
}
