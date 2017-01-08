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
use common\models\User;
use common\models\Region;
use backend\modules\box\models\BoxRecycleOrder;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '1%',
    ],
    // [
    //  'class'=>'\kartik\grid\ExpandRowColumn',
    //  'value'=>function ($model, $key, $index, $column) {
    //      return kartik\grid\GridView::ROW_COLLAPSED;
    //  },

    //  'detail'=> function($model,$key,$index,$column) {
    //     return Yii::$app->controller->renderPartial('expand', [
    //         'model' => $model,
    //     ]);   
    //  },
    //  //'detailUrl' => \yii\helpers\Url::to(['test']),
    //  'detailAnimationDuration'=>100,
    //  //'expandIcon'=>'<span class="fa fa-angle-right"></span>',
    //  //'collapseIcon'=>'<span class="fa fa-angle-down"></span>',
    //  'headerOptions'=>['class'=>'kartik-sheet-style'],
    //  'expandOneOnly'=>true
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'width'=>'10%',
        'attribute'=>'order_no',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
    ],
    [
        'class'=>'\kartik\grid\EditableColumn',
        'attribute'=>'link_name',
        'width'=>'15%',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'editableOptions'=> function ($model, $key, $index) {
            return [
                'name' => '用户姓名',
                'header'=>'用户姓名', 
                'asPopover' => true,
                'inputType' => Editable::INPUT_TEXT,
                'formOptions' => [
                    'action' => ['order/editOrder']
                ],
                'afterInput'=>function ($form, $widget) use ($model, $index) {
                    return $form->field($model, "sex")->dropDownList(BoxRecycleOrder::$sexType)."\n" . 
                           $form->field($model, 'mobile')->textInput()->label('用户手机') . "\n";
                },

            ];
        },
        'refreshGrid' => true,
        'value' => function($model){
            return $model->link_name.' （  '.BoxRecycleOrder::$sexType[$model->sex].'  ）<br/> Tel: '. $model->mobile;
        },
        'format' => 'raw',
    ],
    // [
    //     'class'=>'\kartik\grid\EditableColumn',
    //     'attribute'=>'mobile',
    //     'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
    //     'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
    //     'editableOptions'=> function ($model, $key, $index) {
    //         return [
    //             'name' => '用户手机',
    //             'header'=>'用户手机', 
    //             'asPopover' => true,
    //             'inputType' => \kartik\editable\Editable::INPUT_TEXT,
    //             'formOptions' => [
    //                 'action' => ['order/editOrder']
    //             ],
    //         ];
    //     }
    // ],
    [
        'class'=>'\kartik\grid\EditableColumn',
        'attribute'=>'region_id',
        'width' => '15%',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle ligenligen'],
        'editableOptions'=> function ($model, $key, $index) {
            return [
                'name'=>'省市区', 
                'header'=>'省市区', 
                'formOptions' => [
                    'action' => ['order/editOrder']
                ],
                'asPopover' => true,
                'inputType' => Editable::INPUT_DEPDROP,
                'options' => [
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options'=> ['pluginOptions'=>['allowClear'=>true]],
                    'options' => ['id'=>'region_id_'.$index, 'placeholder' => '请选择区域'],
                    'pluginOptions'=>[
                        'depends'=>['county_id_'.$index],
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
                                ])->label(false) . "\n" .
                            $form->field($model, 'county_id')->widget(DepDrop::classname(), [
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'select2Options'=> ['pluginOptions'=>['allowClear'=>true]],
                                    'options' => ['id'=>'county_id_'.$index,'placeholder' => '请选择市/区'],
                                    'pluginOptions'=>[
                                        'depends'=>['city_id_'.$index],
                                        'url' => Url::to(['region/region'])
                                    ]
                                ])->label(false);

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
        'width' => '15%',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'editableOptions'=> function ($model, $key, $index) {
            return [ 
                'header'=>'详细地址', 
                'formOptions' => [
                    'action' => ['order/editOrder']
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
    [
        'class'=>'\kartik\grid\EditableColumn',
        'attribute'=>'create_dt',
        'width' => '25%',
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'editableOptions'=> function ($model, $key, $index) {
            return [
                'name'=>'创建时间', 
                'header'=>'创建时间', 
                'formOptions' => [
                    'action' => ['order/editOrder']
                ],
                'asPopover' => true,
                'inputType' => Editable::INPUT_HIDDEN,
                'editableValueOptions'=>['class'=> 'text-success'],
                'afterInput'=>function ($form, $widget) use ($model, $index) {
                    return  $form->field($model, 'expect_start_dt')->textInput([
                                'onclick'=>"laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" ,
                                'class'=>'form-control laydate-icon',
                            ])->label('预约开始时间') . "\n" .
                            $form->field($model, 'expect_end_dt')->textInput([
                                'onclick'=>"laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" ,
                                'class'=>'form-control laydate-icon',
                            ])->label('预约结束时间') . "\n";

                },

            ];
        },
        'value' => function($model){
            $time[] = '下单时间：' . $model->create_dt;
            if(!empty($model->expect_start_dt)){
                $time[] = '预约开始：' . $model->expect_start_dt;
            }
            if(!empty($model->expect_end_dt)){
                $time[] = '预约结束：' . $model->expect_end_dt;
            }
            if(!empty($model->confirm_dt)){
                $time[] = '接单时间：' . $model->confirm_dt;
            }
            if(!empty($model->finish_dt)){
                $time[] = '完成时间：' . $model->finish_dt;
            }
            return implode("<br/>" , $time);
        },
        'format' => 'raw',
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
        'refreshGrid' => true,
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
                    'action' => ['order/editOrder']
                ],
                'asPopover' => true,
                'inputType' => Editable::INPUT_DROPDOWN_LIST,
                'data' => BoxRecycleOrder::$changeStatus[$model->status],
                'editableValueOptions'=>['class'=>$model->status == 0 ? 'text-warning strong' : 'text-success'],
                'afterInput'=>function ($form, $widget) use ($model, $index) {
                    return $form->field($model,'exception')->checkbox();
                }

            ];
        },
        'value' => function($model){
            if(!empty($model->exception)){
                return  BoxRecycleOrder::$orderStatus[$model->status].' (异 常)';
            }else{
                return  BoxRecycleOrder::$orderStatus[$model->status];
            }
        },
        'filterType'=>GridView::FILTER_SELECT2,
        'filter' => BoxRecycleOrder::getOrderStatus(),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'请选择状态'],
        'refreshGrid' => true
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'engineer_id',
        'value' => function($model){
            if(!empty($model->assignUser->username)){
                return $model->assignUser->username . ' ('.$model->assignUser->phone.')';
            }else{
                return '未分配';
            }
            
        },
        'headerOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'contentOptions' => ['class' => 'kv-align-center kv-align-middle'],
        'filterType'=>GridView::FILTER_SELECT2,
        'filterInputOptions'=>['placeholder'=>'搜索上门人员'],
        'filterWidgetOptions'=>[
            'model' => $searchModel,
                'initValueText' => ($user = User::findOne($searchModel->engineer_id)) ? $user->username.$user->phone : '' ,
                'attribute' => 'engineer_id',
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 1,
                    'ajax' => [
                        'url' => Url::to(['user-list']),
                        'dataType' => 'json',
                        'delay' => 250,
                        'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function (user) { return user.text; }'),
                    'templateSelection' => new JsExpression('function (user) { return user.text; }'),
                ],
        ],
    ],
    [
        'class'=>'\kartik\grid\EditableColumn',
        'attribute'=>'remarks',
        // 'noWrap' => true,
        // 'hidden' => true,
        // 'width' => '150px',
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
                    'action' => ['order/editOrder']
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
        'template' => '{signle-assign}{view}',
        'viewOptions'=>['role'=>'modal-remote','title'=>'查看','data-toggle'=>'tooltip'], 
        'buttons' => [
            'signle-assign' => function ($url, $model, $key) {
                if(in_array($model->status , [1,2])){
                    return  Html::a('<span class="glyphicon glyphicon-user"></span>', $url, [
                        'title' => !empty($model->engineer_id) ? '改分配' : '分配',
                        'data-pjax' => 0,
                        'role' => 'modal-remote',
                        'data-toggle' => 'tooltip',
                    ]);
                }else{
                    return  Html::a('<span class="glyphicon glyphicon-user"></span>', 'javascript:void(0)', [
                        'title' => '不能分配',
                        'data-toggle' => 'tooltip',
                    ]);
                }
                
            },
        ],
    ],

];   