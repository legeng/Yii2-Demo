<?php

namespace backend\rbac;

use Yii;
use yii\rbac\Rule;


class TestRule extends Rule
{
	public $name = 'testRule'; //规则名称，必须;

	//你可以修改文章，但是修改的文章必须是自己发布的
	//针对于test-update 这个权限（Permission）
	//添加Rule ,限制只有自己的文章才可以修改
	public function execute($userId , $item , $params)
	{	
		//返回false true
		return isset($params['article']) ? $params['article']['user_id'] === $userId  : false;
	}
}