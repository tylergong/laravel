<?php

namespace App\Http\Controllers\Admin;

use App\Models\ChannelModel;
use App\Models\ArticleModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaticController extends Controller {

	public function __construct() {
		$this->middleware('auth.admin:admin');
	}

	// 列表页面(默认显示页)
	// GET
	// /admin/ad
	public function index(Request $request) {
		return view('admin.static');
	}

	public function upHome() {

	}

	public function upChannel() {

	}

	public function upArticle() {

	}
}
