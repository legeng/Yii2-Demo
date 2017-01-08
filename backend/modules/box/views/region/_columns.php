<?php
use yii\helpers\Url;

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
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
        // 'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        // 'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'pid',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'service_type',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'level',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'open_flag',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'path',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'short',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'remarks',
        // 'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        // 'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'确认提示',
                          'data-confirm-message'=>'你确定要删除选中的列吗？'], 
    ],

];   