<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadsController extends Controller {

	public function __construct() {
	}

	/**
	 * 上传文件
	 *
	 * @param Request $request
	 *
	 * @return string
	 */
	public function uploadFile(Request $request) {
		if($request->files->count() > 1) {
			$files = $request->files;
			foreach($files as $file) {
				$path[] = $this->handlerFile($file);
			}
		} else {
			$path[] = $this->handlerFile(current($request->file()));
		}

		// wangEditor 返回图片要求数据格式
		$rtn = array(
			'errno' => 0,
			'data' => $path,
		);
		return json_encode($rtn);
	}


	/**
	 * 文件路径处理 [ 采用laravel5.4封装的图片上传处理 ]
	 *
	 * @param $file
	 *
	 * @return mixed
	 */
	public function handlerFile($file) {
		// 保存本地方法 [http://laravelacademy.org/post/6885.html]
		// 使用 config/filesystems.php 中 public 的disk,文件被存在 storage/app/public 目录下
		// 执行 php artisan storage:link 建立软链 public/storage 指向 storage/app/public
		// 前台访问  http://loaclhost/storage/XXXXX.jpg
		if($file->isValid()) {
			$ext = $file->getClientOriginalExtension();    // 扩展名
			$realPath = $file->getRealPath();    // 临时文件的绝对路径
			$filename = date('YmdHis') . '-' . uniqid() . '.' . $ext;    // 定义新的文件名

			// 直接使用store方式存入 public 空间
			// 这里直接返回路径 public/XXXXXXX.jpeg,存入数据是还需要修改
			// $path = $file->store('public');

			// 使用 storage 方式存入 public 空间
			$bool = Storage::disk('public')
				->put($filename, file_get_contents($realPath));
			if($bool) {
				$path = Storage::url($filename);    // 返回 '/storage/'.$filename
			}
		}
		return $path;
	}


	/**
	 * 文件流处理
	 *
	 * @param $file
	 *
	 * @return string
	 */
	public function handlerFileByBase64($file) {
		// mime 和 扩展名 的映射
		$mimes = array(
			'image/bmp' => 'bmp',
			'image/gif' => 'gif',
			'image/jpeg' => 'jpg',
			'image/png' => 'png',
			'image/x-icon' => 'ico'
		);
		$tmp = explode(',', $file);    // 拆分图片流头和内容

		preg_match('/^data:(.*?);base64/is', $tmp[0], $matches);
		$ext = $mimes[$matches[1]];

		$filename = date('YmdHis') . '-' . uniqid() . '.' . $ext;    // 定义新的文件名
		$filepath = storage_path('app/public/') . $filename;    // 图片存储路径

		file_put_contents($filepath, base64_decode($tmp[1]));    // 保存图片到自定义的路径
		$path = '/storage/' . $filename;    // 返回 图片url
		return $path;
	}
}
