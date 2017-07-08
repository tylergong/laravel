<?php
/**
 * Created by PhpStorm.
 * User: gongming
 * Date: 2017/6/6
 * Time: 17:35
 */
namespace App\Models;

use App\Models\Base\DB91lsme;

class FriendLinksModel extends DB91lsme {
	public $table = 'ls_flinks';
	public $timestamps = false;
	protected $appends = ['is_show_text'];
	public $fillable = [
		'fname',
		'flink',
		'is_show'
	];

	public function getIsShowTextAttribute() {
		if(isset($this->attributes['is_show'])) {
			switch($this->attributes['is_show']) {
				case 1:
					return '是';
					break;
				default:
					return '否';
			}
		} else {
			return '';
		}
	}

}