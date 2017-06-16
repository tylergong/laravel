<?php
namespace App;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Created by PhpStorm.
 * User: duomi
 * Date: 2016/8/4 0004
 * Time: 15:11
 */
class Helper {
	public static function getImageResize($SourceUrl = '', $Width = 100, $Height = 100, $Quality = 100, $Cut = 0, $Original = 0)
	{
		if (empty($SourceUrl)) {
			return null;
		}
		$Width = intval($Width);
		$Height = intval($Height);
		$Quality = intval($Quality);
		$Cut = intval($Cut);
		$Original = intval($Original);

		// 区分图片来源cdn（是否是网速服务器）
		if(strpos($SourceUrl, 'http://') !== false && strpos($SourceUrl, 'matocloud') !== false) {
			if($Original) {
				$imgurl = $SourceUrl;
			} else {
				$imgurl = $SourceUrl . '?op=imageView2&mode=2&width=' . $Width . '&height=' . $Height;
			}
		} else {
			// 检测图片路径服务路径
			if(strpos($SourceUrl, 'http://') === false) {
				$SourceUrl = env('OOPS_IMGAGE_CDN_URL') . $SourceUrl;
			}
			if(env('OOPS_IS_USE_IMGAGE_SCALE_URL') == 'true') {
				$imgurl = env('OOPS_IMGAGE_SCALE_URL') . $SourceUrl . '&w=' . $Width . '&h=' . $Height . '&s=' . $Quality . '&c=' . $Cut . '&o=' . $Original;
			} else {
				$imgurl = $SourceUrl;
			}
		}
		return $imgurl;
	}

	public static function writeLog($file_prefix, $path, $content, $date_format = 'Y-m-d')
	{
		// 初始化日志
		$monolog = new Logger('script');
		$monolog->pushHandler(new StreamHandler(storage_path() . '/logs/' . $path . '/' . $file_prefix . date($date_format) . '.log', Logger::NOTICE));
		$monolog->notice($content);
	}
}
