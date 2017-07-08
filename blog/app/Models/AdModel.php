<?php
/**
 * Created by PhpStorm.
 * User: gongming
 * Date: 2017/6/6
 * Time: 17:35
 */
namespace App\Models;

use App\Models\Base\DB91lsme;

class AdModel extends DB91lsme {
	public $table = 'ls_ad';
	public $timestamps = false;
	protected $appends = [
		'is_link_text',
		'imgurl_show'
	];
	public $fillable = [
		'imgurl',
		'title',
		'is_link',
		'jumpurl',
		'create_time',
	];

	public function getIsLinkTextAttribute() {
		if(isset($this->attributes['is_link'])) {
			switch($this->attributes['is_link']) {
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

	public function getImgurlShowAttribute() {
		if(isset($this->attributes['imgurl'])) {
			if(strpos($this->attributes['imgurl'], '/storage/') !== false) {
				return $this->attributes['imgurl'];
			} else {
				return 'http://www.91lsme.com/' . $this->attributes['imgurl'];
			}
		} else {
			return '';
		}
	}

}