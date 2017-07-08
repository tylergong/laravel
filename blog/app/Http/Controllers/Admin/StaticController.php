<?php

namespace App\Http\Controllers\Admin;

use App\Models\ChannelModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;

class StaticController extends Controller {

	public function __construct() {
		$this->middleware('auth.admin:admin');
	}

	public function index(Request $request) {
		if($request->ajax()) {
			$list['data'] = ChannelModel::get()->toArray();
			die(json_encode($list));
		} else {
			return view('admin.channel.list');
		}
	}
}
