<?php

namespace App\Http\Controllers\Tables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActModel;

class VueTablesController extends Controller {
	//
	public function index(Request $request) {
		if($request->ajax()) {
			$length = $request->input('length', config('webConfig.PAGE_SIZE'));
			$list = ActModel::where('source', 1)
							->where('type', 1)
							->paginate($length)
							->toArray();
			die(json_encode($list));
		} else {
			return view('tables.vueTables');
		}
	}

	public function show() {

	}

	public function create() {

	}

	public function store() {

	}

}
