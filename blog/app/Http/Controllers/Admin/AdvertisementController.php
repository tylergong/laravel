<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadsController;

class AdvertisementController extends Controller {

	public function __construct() {
		$this->middleware('auth.admin:admin');
	}

	// 列表页面(默认显示页)
	// GET
	// /admin/ad
	public function index(Request $request) {
		if($request->ajax()) {
			$list['data'] = AdModel::get()
				->toArray();
			die(json_encode($list));
		} else {
			return view('admin.ad.list');
		}
	}

	// 创建(显示表单)
	// GET
	// /admin/ad/create
	public function create() {
		// 初始化默认数据
		$detail = [
			'id' => 0,
			'imgurl' => '',
			'imgurl_show' => '',
			'title' => '',
			'is_link' => 0,
			'jumpurl' => '',
		];
		return view('admin.ad.create', compact('detail'));
	}

	// 保存创建数据
	// POST
	// /admin/ad
	public function store(Request $request) {
		$code = -1;
		$msg = 'error';

		$detail['title'] = $request->input('title', '');
		$detail['is_link'] = $request->input('is_link', 0);
		if($detail['is_link'] == 1) {
			$detail['jumpurl'] = $request->input('jumpurl', '');
		}
		$detail['create_time'] = date('Y-m-d H:i:s', time());

		$is_new_img = $request->input('new_img', 0);
		if($is_new_img) {
			// 获取图片流数据处理图片存到本地
			$file = $request->input('imgurl_show');//获取图片流
			$up = new UploadsController();
			$detail['imgurl'] = $up->handlerFileByBase64($file);
		}

		$res = AdModel::create($detail);
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
	// /admin/ad/{id}/edit
	public function edit($id) {
		$detail = AdModel::find($id)
			->toArray();
		return view('admin.ad.create', compact('detail'));
	}

	// 保存编辑数据
	// PUT\PATCH
	// /admin/ad/{id}
	public function update(Request $request, $id) {
		$code = -1;
		$msg = 'error';

		$detail = AdModel::find($id);
		$detail->title = $request->input('title', '');
		$detail->is_link = $request->input('is_link', 0);
		if($detail->is_link == 1) {
			$detail->jumpurl = $request->input('jumpurl', '');
		}

		$is_new_img = $request->input('new_img', 0);
		if($is_new_img) {
			// 获取图片流数据处理图片存到本地
			$file = $request->input('imgurl_show');//获取图片流
			$up = new UploadsController();
			$detail['imgurl'] = $up->handlerFileByBase64($file);
		}

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
	// /admin/ad/{id}
	public function destroy($id) {
		$code = -1;
		$msg = 'error';

		$res = AdModel::destroy($id);
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
	// /admin/ad/{id}
	public function show() {
		return false;
	}
}
