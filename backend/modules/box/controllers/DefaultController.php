<?php

namespace backend\modules\box\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use backend\controllers\BaseController;

/**
 * Default controller for the `box` module
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->redirect(Url::toRoute(['order/index']));
    }
}
