<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use yii\web\View;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\box\models\searchs\BoxApplyLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Box Apply Logs';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="box-apply-log-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => require(__DIR__.'/_columns.php'),
            'containerOptions'=>['style'=>'overflow: scroll'],
            'headerRowOptions'=>['class'=>'kartik-sheet-style'],
            'filterRowOptions'=>['class'=>'kartik-sheet-style'],
            'tableOptions' => [
                
            ],
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'刷新']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],  
            'export' => [
                'fontAwesome' => true,
                'target'=>'_blank',
            ],         
            'striped' => true,
            'condensed' => true,
            'responsive' => true,  
            'hover'=>true,
            'pjax'=>true,
            'condensed'=>true,
            'bordered'=>true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;列表详情',
                'before'=>'<em>* 可以通过拖动列边调整表列，就像电子表格一样.</em>',
                // 'after'=>BulkButtonWidget::widget([
                //             'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; 删除选中',
                //                 ["bulk-delete"] ,
                //                 [
                //                     "class"=>"btn btn-danger btn-xs",
                //                     'role'=>'modal-remote-bulk',
                //                     'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                //                     'data-request-method'=>'post',
                //                     'data-confirm-title'=>'确认提示',
                //                     'data-confirm-message'=>'你确定要删除选中的项目吗？'
                //                 ]),
                //         ]).                        
                //         '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>

