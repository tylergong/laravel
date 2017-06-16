<?php

namespace App\Http\Controllers\Tables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActModel;
use App\Helper;

class DataTablesController extends Controller {
	//
	public function index(Request $request) {
		if($request->ajax()) {
			$list = ActModel::where('source', 1)
							->where('type', 1)
							->orderBy('orderby', 'desc')
							->get()
							->toArray();
			foreach($list as $k => &$v) {
				$v['start_time_format'] = date('Y-m-d H:i:s', $v['start_time']);
				$v['end_time_format'] = date('Y-m-d H:i:s', $v['end_time']);
				$v['create_time_format'] = date('Y-m-d H:i:s', $v['create_time']);
				$v['buy_vip_time1_format'] = date('Y-m-d H:i:s', $v['buy_vip_time1']);
				$v['buy_vip_time2_format'] = date('Y-m-d H:i:s', $v['buy_vip_time2']);
				$v['stop_time_format'] = date('Y-m-d H:i:s', $v['stop_time']);
				$v['list_img_format'] = Helper::getImageResize($v['list_img'], 50, 20);
			}
			$res['data'] = $list;
			die(json_encode($res));
		} else {
			return view('tables.dataTables');
		}
	}

	// 改变活动 发布状态(只能 0 和 1 相互改变)
	public function setStatus(Request $request) {
		$id = $request->input('id', 0);

		$row = ActModel::find($id);
		if($row->status == 1) $_status = 0;
		if($row->status == 0) $_status = 1;
		$row->status = $_status;
		$res = $row->save();
		die(json_encode($res));
	}

	// 终止活动，并记录原因
	public function setStop(Request $request) {
		$id = $request->input('id', 0);
		$title = $request->input('title', '');

		$row = ActModel::find($id);
		$row->is_stop = -1;
		$row->stop_title = $title;
		$row->stop_time = time();

		$res = $row->save();
		die(json_encode($res));
	}

	// 改变活动是否在列表中显示
	public function setShowList(Request $request) {
		$id = $request->input('id', 0);

		$row = ActModel::find($id);
		if($row->is_show_list == 1) $_is_show_list = 0;
		if($row->is_show_list == 0) $_is_show_list = 1;
		$row->is_show_list = $_is_show_list;

		$res = $row->save();
		die(json_encode($res));
	}

	// push 消息（最多push 2次，js控制，程序不做控制不做）
	public function setPushNum(Request $request) {
		$id = $request->input('id', 0);

		$res = ActModel::where('id', $id)
					   ->increment('push_num');
		die(json_encode($res));
	}

	// 活动移位
	public function setOrderBy(Request $request) {
		$id = $request->input('id', 0);
		$opt = $request->input('opt', '');

		$row = ActModel::find($id);
		if($opt == 'up') {
			$ex_activity = ActModel::where('orderby', '>', $row->orderby)
								   ->where('source', 1)
								   ->where('type', 1)
								   ->orderBy('orderby', 'asc')
								   ->first();
		} else {
			$ex_activity = ActModel::where('orderby', '<', $row->orderby)
								   ->where('source', 1)
								   ->where('type', 1)
								   ->orderBy('orderby', 'desc')
								   ->first();
		}
		if($ex_activity) {
			$tmp = $row->orderby;
			$row->orderby = $ex_activity->orderby;
			$ex_activity->orderby = $tmp;
			$row->save();
			$ex_activity->save();
			return json_encode(true);
		} else {
			return json_encode(false);
		}
	}
}
