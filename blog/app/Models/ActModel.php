<?php
/**
 * Created by PhpStorm.
 * User: gongming
 * Date: 2017/6/6
 * Time: 17:35
 */
namespace App\Models;

use App\Models\Base\DBFensi;

class ActModel extends DBFensi {
	public $table = 'oops_act';
	public $timestamps = false;
	protected $appends = ['main_text',
						  'matter_type_text',
						  'act_rule_type_text',];

	public function getMainTextAttribute() {
		if(isset($this->attributes['main'])) {
			switch($this->attributes['main']) {
				case 1:
					return '团';
				break;
				case 2:
					return '个人';
				break;
				default:
					return '其他';
			}
		} else {
			return '';
		}
	}

	public function getMatterTypeTextAttribute() {
		if(isset($this->attributes['matter_type'])) {
			switch($this->attributes['matter_type']) {
				case 1:
					return '实物';
				break;
				case 2:
					return '兑换券';
				break;
				case 3:
					return '偶币';
				break;
				case 4:
					return '演出票';
				break;
				case 5:
					return '商品';
				break;
				case 6:
					return '虚拟物';
				break;
				default:
					return '';
			}
		} else {
			return '';
		}
	}

	public function getActRuleTypeTextAttribute() {
		if(isset($this->attributes['act_rule_type'])) {
			switch($this->attributes['act_rule_type']) {
				case 1:
					return '福利';
				break;
				case 2:
					return '抽奖';
				break;
				case 3:
					return '秒抢';
				break;
				case 4:
					return '打卡';
				break;
				default:
					return '';
			}
		} else {
			return '';
		}
	}

}