<?php

namespace App\Http\Controllers\Admin;

use App\Models\ArticleModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleRecycleController extends Controller {

	public function __construct() {
		$this->middleware('auth.admin:admin');
	}

	// 列表页面(默认显示页)
	// GET
	// /admin/articleRecycle
	public function index(Request $request) {
		if($request->ajax()) {
			$list['data'] = ArticleModel::select('id', 'title', 'is_link', 'jumpurl', 'is_show', 'create_time', 'cid', 'up')
				->where('is_del', 1)
				->orderBy('up', 'desc')
				->orderBy('id', 'desc')
				->get()
				->toArray();
			die(json_encode($list));
		} else {
			return view('admin.articleRecycle.list');
		}
	}

	// 删除数据(逻辑恢复)
	// DELETE
	// /admin/articleRecycle/{id}
	public function destroy($id) {
		$rtn = array(
			'code' => 0,
			'msg' => 'error'
		);
		$detail = ArticleModel::find($id);
		$detail->is_del = 0;
		$detail->up_time = date('Y-m-d H:i:s', time());
		$res = $detail->save();
		if($res) {
			$rtn = array(
				'code' => 1,
				'msg' => 'ok'
			);
		}
		die(json_encode($rtn));
	}
}
