<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs;

    protected $prefNames = [
		'北海道','青森県','岩手県','宮城県','秋田県',
		'山形県','福島県','茨城県','栃木県','群馬県',
		'埼玉県','千葉県','東京都','神奈川県','新潟県',
		'富山県','石川県','福井県','山梨県','長野県',
		'岐阜県','静岡県','愛知県','三重県','滋賀県',
		'京都府','大阪府','兵庫県','奈良県','和歌山県',
		'鳥取県','島根県','岡山県','広島県','山口県',
		'徳島県','香川県','愛媛県','高知県','福岡県',
		'佐賀県','長崎県','熊本県','大分県','宮崎県',
		'鹿児島県','沖縄県',
	];
    protected $gradeNames = [
		'未就学','年少','年中','年長','小学１年',
		'小学２年','小学３年','小学４年','小学５年','小学６年',
		'中学１年','中学２年','中学３年','高校１年','高校２年',
		'高校３年','大学１年','大学２年','大学３年','大学４年'
	];
}
