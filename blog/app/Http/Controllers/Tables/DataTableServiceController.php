<?php
namespace App\Http\Controllers\Tables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActModel;
use App\Helper;
use Illuminate\Pagination\Paginator;

class DataTableServiceController extends Controller {
	//
	public function index(Request $request) {
		if($request->ajax()) {
			$draw = $request->input('draw', 0);
			$start = $request->input('start', 0);
			$length = $request->input('length', 0);
			$search = $request->input('search', '');

			$page = ceil($start / $length) + 1;
			Paginator::currentPageResolver(function() use ($page) {
				return $page;
			});
			$list = ActModel::where('source', 1)
							->where('type', 1);
			if(!empty($search['value'])) {
				$list = $list->whereRaw("concat_ws('',id,name) like '%" . $search['value'] . "%'");
			}

			$order_column = $_GET['order']['0']['column'];//那一列排序，从0开始
			$order_dir = $_GET['order']['0']['dir'];//ase desc 升序或者降序
			if(isset($order_column)) {
				$i = intval($order_column);
				switch($i) {
					case 1;
						$list = $list->orderBy('id', $order_dir);
					break;
					case 3;
						$list = $list->orderBy('name', $order_dir);
					break;
					case 5;
						$list = $list->orderBy('main', $order_dir);
					break;
					case 6;
						$list = $list->orderBy('act_rule_type', $order_dir);
					break;
					case 7;
						$list = $list->orderBy('matter_type', $order_dir);
					break;
					case 9;
						$list = $list->orderBy('click_num', $order_dir);
					break;
					default;
					break;
				}
			}
			$list = $list->paginate($length)
						 ->toArray();
			foreach($list['data'] as $k => &$v) {
				$v['start_time_format'] = date('Y-m-d H:i:s', $v['start_time']);
				$v['end_time_format'] = date('Y-m-d H:i:s', $v['end_time']);
				$v['create_time_format'] = date('Y-m-d H:i:s', $v['create_time']);
				$v['buy_vip_time1_format'] = date('Y-m-d H:i:s', $v['buy_vip_time1']);
				$v['buy_vip_time2_format'] = date('Y-m-d H:i:s', $v['buy_vip_time2']);
				$v['stop_time_format'] = date('Y-m-d H:i:s', $v['stop_time']);
				$v['list_img_format'] = Helper::getImageResize($v['list_img'], 50, 20);
			}

			$res = array(
				"draw" => intval($draw),
				"recordsTotal" => intval($list['total']),
				"recordsFiltered" => intval($list['total']),
				"data" => $list['data']);
			die(json_encode($res));
		} else {
			return view('tables.dataTables2');
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