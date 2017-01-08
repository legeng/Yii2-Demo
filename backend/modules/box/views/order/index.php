<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\web\View;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\box\models\searchs\BoxRecycleOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单列表';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

$this->registerJsFile(
    '/js/plugins/layer/laydate/laydate.js'
);


?>

<div class="box-recycle-order-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id' => 'crud-datatable-pjax',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => require(__DIR__.'/_columns.php'),
            'containerOptions'=>['style'=>'overflow: scroll;height:480px;'],
            'headerRowOptions'=>['class'=>'kartik-sheet-style'],
            'filterRowOptions'=>['class'=>'kartik-sheet-style'],
            'tableOptions' => [
                'style'=>'width:120%;max-width:150%',
            ],
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>'刷新']).
                    '{toggleData}'.
                    '{export}'
                ],
            ], 
            'export' => [
                'fontAwesome' => true,
                'target'=>'_blank',
            ],       
            'striped' => true,
            'responsive'=>true,
            'perfectScrollbar'=>true,
            'floatHeader'=>true,
            'hover'=>true,
            'pjax'=>true,
            'condensed'=>true,
            'bordered'=>true,        
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;列表详情',
                'before'=>'<em>* 可以通过拖动列边调整表列，就像电子表格一样.</em>',
                'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a(
                                '<i class="glyphicon glyphicon-user"></i>&nbsp; 批量分配',
                                ['batch-assign'] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-get-field'=>'ids',
                                    'data-confirm'=>false, 
                                    'data-method'=>false,
                                ]),
                        ]).'<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>


