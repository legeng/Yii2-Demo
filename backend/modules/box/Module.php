<?php

namespace backend\modules\box;

use Yii;
use yii\helpers\Url;

/**
 * box module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\box\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        if(Yii::$app->user->isGuest){
            Yii::$app->response->redirect(Url::toRoute(['/site/login']));
            Yii::$app->end();
        }
    }
}
