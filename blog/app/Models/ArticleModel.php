<?php
/**
 * Created by PhpStorm.
 * User: gongming
 * Date: 2017/6/6
 * Time: 17:35
 */
namespace App\Models;

use App\Models\Base\DB91lsme;
use App\Models\ChannelModel;

class ArticleModel extends DB91lsme {
	public $table = 'ls_article';
	public $timestamps = false;
	protected $appends = [
		'is_show_text',
		'is_link_text',
		'c_name'
	];
	public $fillable = [
		'title',
		'cid',
		'is_link',
		'jumpurl',
		'is_show',
		'up',
		'rel_link',
		'create_time',
		'content',
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

	public function getCNameAttribute() {
		if(isset($this->attributes['cid'])) {
			return ChannelModel::find($this->attributes['cid'])->cname;
		} else {
			return '';
		}
	}

}