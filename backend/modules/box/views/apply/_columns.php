<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use kartik\grid\GridView;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use kartik\editable\Editable;
use kartik\depdrop\DepDrop;
use common\models\Region;
use backend\modules\box\models\BoxApplyLog;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class'=>'\kartik\grid\EditableColumn',
        'attribute'=>'link_name',
        'width' => '15%',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'editableOptions'=> function ($model, $key, $index) {
            return [
                'name' => '用户姓名',
                'header'=>'用户姓名', 
                'asPopover' => true,
                'inputType' => Editable::INPUT_TEXT,
                'formOptions' => [
                    'action' => ['apply/edit']
                ],
                'afterInput'=>function ($form, $widget) use ($model, $index) {
                    return $form->field($model, "sex")->dropDownList(BoxApplyLog::$sexType)."\n" . 
                           $form->field($model, 'mobile')->textInput()->label('用户手机') . "\n";
                },

            ];
        },
        'refreshGrid' => true,
        'value' => function($model){
            return $model->link_name.' （  '.BoxApplyLog::$sexType[$model->sex].'  ）<br/> Tel: '. $model->mobile;
        },
        'format' => 'raw',
    ],
    [
        'class'=>'\kartik\grid\EditableColumn',
        'attribute'=>'region_id',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'editableOptions'=> function ($model, $key, $index) {
            return [
                'name'=>'省市区', 
                'header'=>'省市区', 
                'formOptions' => [
                    'action' => ['apply/edit']
                ],
                'asPopover' => true,
                'inputType' => Editable::INPUT_DEPDROP,
                'options' => [
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options'=> ['pluginOptions'=>['allowClear'=>true]],
                    'options' => ['id'=>'region_id_'.$index, 'placeholder' => '请选择区域'],
                    'pluginOptions'=>[
                        'depends'=>['city_id_'.$index],
                        'url' => Url::to(['region/region'])
                    ]
                ],
                'data' => ArrayHelper::map(Region::find()->select(['id' , 'name'])->where(['pid'=>$model->province_id])->asArray()->all(),'id', 'name'),
                'editableValueOptions'=>['class'=> 'text-success'],
                'beforeInput'=>function ($form, $widget) use ($model, $index) {
                            $model->province_id = 0;
                    return  $form->field($model, 'province_id')->dropDownList(ArrayHelper::map(
                            Region::find()->select(['id' , 'name'])->where(['pid'=>0,'level'=>1])->asArray()->all()
                            ,'id', 'name'), ['id'=>'province_id_'.$index,'class' => 'form-control','prompt'=>'请选择省'])->label(false) . "\n" . 
                            $form->field($model, 'city_id')->widget(DepDrop::classname(), [
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'select2Options'=> ['pluginOptions'=>['allowClear'=>true]],
                                    'options' => ['id'=>'city_id_'.$index,'placeholder' => '请选择市/区'],
                                    'pluginOptions'=>[
                                        'depends'=>['province_id_'.$index],
                                        'url' => Url::to(['region/region'])
                                    ]
                                ])->label(false) . "\n" ;

                },

            ];
        },
        'value' => function($model){
            return Region::getParents($model->region_id);
        },
        'filterType'=>GridView::FILTER_SELECT2,
        'filterInputOptions'=>['placeholder'=>'区域搜索'],
        'filterWidgetOptions'=>[
            'model' => $searchModel,
            'initValueText' => !empty($searchModel->region->id)? Region::getParents($searchModel->region->id) : '',
            'attribute' => 'region_id',
            'pluginOptions'=>[
                'allowClear'=>true,
                'minimumInputLength' => 1,
                    'ajax' => [
                        'url' => Url::to(['region/search-region']),
                        'dataType' => 'json',
                        'delay' => 250,
                        'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function (region) { return region.text; }'),
                    'templateSelection' => new JsExpression('function (region) { return region.text; }'),
            ],
        ],
        'refreshGrid' => true,
    ],
    [
        'class'=>'\kartik\grid\EditableColumn',
        'attribute'=>'address',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'editableOptions'=> function ($model, $key, $index) {
            return [ 
                'header'=>'详细地址', 
                'formOptions' => [
                    'action' => ['apply/edit']
                ],
                'asPopover' => true,
                'inputType' => Editable::INPUT_TEXTAREA,
            ];
        },
        'format' => 'raw',
        'value' => function($model){
            return $model->address;
        }
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'open_id',
    //     'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
    //     'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
    //     'value' => function($model){
    //         return !empty($model->open_id) ? $model->open_id : '未设置';
    //     }
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'express_no',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'value' => function($model){
            return !empty($model->express_no) ? $model->express_no : '未设置';
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'create_dt',
        'width' => '20%',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'filterType'=>GridView::FILTER_DATE,
        'filterWidgetOptions'=>[
            'model' => $searchModel,
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'attribute' => 'create_dt',
            'options' => ['class' => 'input-sm'],
            'pluginOptions'=>[
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ],
        ],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'apply_type',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'value'=>function($model){
            if($model->apply_type == 1){
                return '申请BOX';
            }else{
                return '开通区域';
            }
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'box_number',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
    ],
    [
        'class'=>'\kartik\grid\EditableColumn',
        'attribute'=>'status',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'editableOptions'=> function ($model, $key, $index) {
            return [
                'name'=>'订单状态', 
                'header'=>'订单状态', 
                'formOptions' => [
                    'action' => ['apply/edit']
                ],
                'asPopover' => true,
                'inputType' => Editable::INPUT_DROPDOWN_LIST,
                'data' => BoxApplyLog::$changeStatus[$model->status],
                'displayValueConfig' => BoxApplyLog::$changeStatus[$model->status],
                'editableValueOptions'=>['class'=>$model->status == 0 ? 'text-warning strong' : 'text-success'],

            ];
        },
        'value' => function($model){
            return  BoxApplyLog::$applyStatus[$model->status];
        },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter' => BoxApplyLog::$applyStatus,
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'请选择状态'],
    ],
    [
        'class'=>'\kartik\grid\EditableColumn',
        'attribute'=>'remarks',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
         'editableOptions'=> function ($model, $key, $index) {
            return [
                'name' => '备注',
                'header'=>'备注', 
                'size'=>'md',
                'asPopover' => false,
                'inputType' => Editable::INPUT_TEXTAREA,
                'formOptions' => [
                    'action' => ['apply/edit']
                ],
            ];
        },
        'format' => 'raw',
        'value' => function($model){
            return '<div style="width:150px;">'.$model->remarks.'</div>';
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'template' => '{view}',
        'viewOptions'=>['role'=>'modal-remote','title'=>'查看','data-toggle'=>'tooltip'], 
    ],

];   