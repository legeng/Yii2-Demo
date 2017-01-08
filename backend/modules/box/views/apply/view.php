<?php

use yii\widgets\DetailView;
use common\models\Region;
use backend\modules\box\models\BoxApplyLog;

/* @var $this yii\web\View */
/* @var $model backend\modules\box\models\BoxApplyLog */
?>
<div class="box-apply-log-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [   
                'label' => '用户信息',
                'value' => $model->link_name.' ('.BoxApplyLog::$sexType[$model->sex].')'
            ],
            'mobile',
            [
                'label' => '区域名称',
                'value' => Region::getParents($model->region_id),
            ],
            'address',
            [
                'label' => 'Open ID',
                'value' => !empty($model->open_id)? $model->open_id : '未设置',
            ],
            [
                'label' => '快递单号',
                'value' => !empty($model->express_no)? $model->express_no : '未设置',
            ],
            'create_dt',
            [
                'label' => '申请类型',
                'value' => $model->apply_type == 1 ? '申请BOX' : '开通区域',
            ],
            'box_number',
            [
                'label' => '状 态',
                'value' => BoxApplyLog::$applyStatus[$model->status],
            ],
            'remarks',
        ],
    ]) ?>

</div>
