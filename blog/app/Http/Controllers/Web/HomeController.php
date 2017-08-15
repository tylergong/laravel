<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ChannelModel;
use App\Models\ArticleModel;
use Illuminate\Pagination\Paginator;

class HomeController extends Controller {

	public function __construct() {
		//$this->middleware('auth');
	}

	// 首页
	public function index(Request $request) {
		// 分别获取频道列表前6篇文章
		$data = ArticleModel::select('id', 'title', 'is_link', 'jumpurl', 'up')
			->where('is_del', 0)
			->where('up', 1)
			->orderBy('up', 'desc')
			->orderBy('id', 'desc')
			->limit(6)
			->get()
			->toArray();

		return view('web.home')->with('data', $data);
	}

	// 频道列表页
	public function channel(Request $request, $id) {
		$c_detail = ChannelModel::find($id);
		return view('web.list', compact('c_detail'));
	}

	// ajax获取文章列表数据(带翻页)
	public function getLists(Request $request) {
		$cid = $request->input('cid', 1);
		$length = $request->input('length', 10);
		$cur = $request->input('cur', 0);

		if($request->isMethod('get')) {
			Paginator::currentPageResolver(function () use ($cur) {
				return $cur;
			});

			$data['lists'] = ArticleModel::where('cid', $cid)
				->where('is_del', 0)
				->orderBy('up', 'desc')
				->orderBy('id', 'desc')
				->paginate($length)
				->toArray();

			$data['hot_lists'] = $this->hotList();

			die(json_encode($data));
		}
	}

	// 文章详情页
	public function detail(Request $request, $id) {
		// 详情
		$details = ArticleModel::find($id)
			->toArray();

		// 热门列表
		$hot_lists = $this->hotList();

		// 上一篇\下一篇
		$previous = ArticleModel::select('id', 'title')
			->where('is_del', 0)
			->where('cid', $details['cid'])
			->where('id', '>', $details['id'])
			->orderBy('id', 'asc')
			->first();
		$next = ArticleModel::select('id', 'title')
			->where('is_del', 0)
			->where('cid', $details['cid'])
			->where('id', '<', $details['id'])
			->orderBy('id', 'desc')
			->first();

		return view('web.detail')
			->with('details', $details)
			->with('hot_lists', $hot_lists)
			->with('previous', $previous)
			->with('next', $next);
	}

	// 搜索页面(不带翻页,最多显示50篇)
	public function search(Request $request) {
		$words = $request->input('words', '');
		if(!empty($words)) {
			$lists = ArticleModel::select('id', 'title', 'content')
				->where('is_del', 0)
				->where('title', 'like', "%$words%")
				->limit(50)
				->get()
				->toArray();
		} else {
			$lists = [];
		}

		return view('web.search')
			->with('lists', $lists)
			->with('words', $words);
	}

	// 热门推荐(获取置顶的文章)
	protected function hotList() {
		$lists = ArticleModel::select('id', 'title')
			->where('up', 1)
			->where('is_del', 0)
			->get()
			->toArray();
		return $lists;
	}
}
