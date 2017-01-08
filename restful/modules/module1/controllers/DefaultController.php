<?php

namespace restful\modules\module1\controllers;

use yii\rest\ActiveController; 

/**
 * Default controller for the `module1` module
 */
class DefaultController extends ActiveController
{
	public $modelClass = 'restful\models\CityStore'; 
}
