<?php

namespace App\Http\Controllers\Admin;

use App\Models\ArticleModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller {

	public function __construct() {
		$this->middleware('auth.admin:admin');
	}

	// 列表页面(默认显示页)
	// GET
	// /admin/article
	public function index(Request $request) {
		if($request->ajax()) {
			$list['data'] = ArticleModel::select('id', 'title', 'is_link', 'jumpurl', 'is_show', 'create_time', 'cid', 'up')
				->where('is_del', 0)
				->orderBy('up', 'desc')
				->orderBy('id', 'desc')
				->get()
				->toArray();
			die(json_encode($list));
		} else {
			return view('admin.article.list');
		}
	}

	// 创建(显示表单)
	// GET
	// /admin/article/create
	public function create() {
		// 初始化默认数据
		$detail = [
			'id' => 0,
			'title' => '',
			'cid' => 1,
			'is_link' => 0,
			'is_show' => 0,
			'up' => 0,
		];
		//$detail = new ArticleModel();
		return view('admin.article.create', compact('detail'));
	}

	// 保存创建数据
	// POST
	// /admin/article
	public function store(Request $request) {
		$code = -1;
		$msg = 'error';

		$detail['title'] = $request->input('title', '');
		$detail['cid'] = $request->input('cid', 1);
		$detail['is_link'] = $request->input('is_link', 0);
		if($detail['is_link'] == 1) {
			$detail['jumpurl'] = $request->input('jumpurl', '');
		}
		$detail['is_show'] = $request->input('is_show', 0);
		$detail['up'] = $request->input('up', 0);
		$detail['rel_link'] = $request->input('rel_link', '');
		$detail['create_time'] = date('Y-m-d H:i:s', time());
		$detail['content'] = $request->get('content', '');

		$res = ArticleModel::create($detail);
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
	// /admin/article/{id}/edit
	public function edit($id) {
//		$detail = ArticleModel::find($id)
//			->toArray();
		$detail = [
			'id' => $id,
		];
		return view('admin.article.create', compact('detail'));
	}

	// 保存编辑数据
	// PUT\PATCH
	// /admin/article/{id}
	public function update(Request $request, $id) {
		$code = -1;
		$msg = 'error';

		$detail = ArticleModel::find($id);
		$detail->title = $request->input('title', '');
		$detail->cid = $request->input('cid', 1);
		$detail->is_link = $request->input('is_link', 0);
		if($detail->is_link == 1) {
			$detail->jumpurl = $request->input('jumpurl', '');
		}
		$detail->is_show = $request->input('is_show', 0);
		$detail->up = $request->input('up', 0);
		$detail->rel_link = $request->input('rel_link', '');
		$detail->content = $request->get('content', '');

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

	// 删除数据(逻辑删除)
	// DELETE
	// /admin/article/{id}
	public function destroy($id) {
		$code = -1;
		$msg = 'error';

		$detail = ArticleModel::find($id);
		$detail->is_del = 1;
		$detail->is_show = 0;
		$detail->up_time = date('Y-m-d H:i:s', time());
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

	// 显示数据
	// GET
	// /admin/article/{id}
	public function show() {
		return false;
	}

	// ajax获取详情
	// GET
	// /admin/article/getDetail
	public function getDetail(Request $request) {
		$id = $request->input('id', 0);
		if($request->ajax() && $id > 0) {
			$detail = ArticleModel::find($id)
				->toArray();
			die(json_encode(array(
				'code' => 0,
				'data' => $detail
			)));
		}
		die(json_encode(array(
			'code' => -1,
		)));
	}
}
