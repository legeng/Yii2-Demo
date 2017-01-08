<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Login;
use yii\helpers\Url;


class BaseController extends Controller
{
    private $_startTime;//记录运行时间

    public function beforeAction($action)
    {   
        if(Yii::$app->user->isGuest){
            return $this->redirect(Url::toRoute(['/site/login']));
        }

        $this->_startTime = microtime(true);

        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        $runTime = microtime(true) - $this->_startTime;
        Yii::trace('操作(Action) ' . $action->uniqueId . ' 耗时 ' . $runTime . '秒');

        return $result;
    }

    public function actionError(){

        $exception = Yii::$app->errorHandler->exception;

        if(!empty($exception)){
            return $this->renderPartial('/site/error' , ['exception' => $exception]);
        }

    }
}
