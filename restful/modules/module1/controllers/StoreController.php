<?php

namespace restful\modules\module1\controllers;

use Yii;
use yii\rest\ActiveController; 
use yii\helpers\ArrayHelper;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\data\ActiveDataProvider;

/**
 * Default controller for the `module1` module
 */
class StoreController extends ActiveController
{
	public $modelClass = 'restful\models\CityStore'; 

	
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		//权限认证
	    $behaviors['authenticator'] = [
	        'class' => CompositeAuth::className(),
	        'authMethods' => [
	            HttpBasicAuth::className(),
	            HttpBearerAuth::className(),
	            QueryParamAuth::className(),
	        ],
	    ];
	    //速率限制
	    $behaviors['rateLimiter']['enableRateLimitHeaders'] = true;

    	return $behaviors;
	}

	public function actions()
	{
		$actions = parent::actions();
	
		return ArrayHelper::merge($actions , [
			'abc' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
		]);
	}

	//重写index的业务实现  
    public function actionIndex()  
    {  
        $modelClass = $this->modelClass;  
        return new ActiveDataProvider([  
            'query' => $modelClass::find()->asArray(),  
              
            'pagination' => false  
        ]);  
    } 

    public function actionVersion()
    {
    	return 1;
    }

    public function actionSearch()
    {
    	return Yii::$app->request->get('id' , 30);
    }
}
