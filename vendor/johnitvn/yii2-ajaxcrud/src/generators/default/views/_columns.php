<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$actionParams = $generator->generateActionParams();

echo "<?php\n";

?>
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use kartik\grid\GridView;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use kartik\editable\Editable;
use kartik\depdrop\DepDrop;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'header' => '序号',
        'width' => '50px',
    ],
    <?php
    $count = 0;
    foreach ($generator->getColumnNames() as $name) {   
        if ($name=='id'||$name=='created_at'||$name=='updated_at'){
            echo "    // [\n";
            echo "        // 'class'=>'\kartik\grid\DataColumn',\n";
            echo "        // 'attribute'=>'" . $name . "',\n";
            echo "        // 'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],\n";
            echo "        // 'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],\n";
            echo "    // ],\n";
        } else if (++$count < 8) {
            echo "    [\n";
            echo "        'class'=>'\kartik\grid\DataColumn',\n";
            echo "        'attribute'=>'" . $name . "',\n";
            echo "        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],\n";
            echo "        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],\n";
            echo "    ],\n";
        } else {
            echo "    // [\n";
            echo "        // 'class'=>'\kartik\grid\DataColumn',\n";
            echo "        // 'attribute'=>'" . $name . "',\n";
            echo "        // 'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],\n";
            echo "        // 'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],\n";
            echo "    // ],\n";
        }
    }
    ?>
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'<?=substr($actionParams,1)?>'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'查看','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'更新', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'删除', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'确认提示',
                          'data-confirm-message'=>'你确定要删除选中的列吗？'], 
    ],

];   