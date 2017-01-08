<?php

use yii\widgets\DetailView;
use backend\modules\box\models\BoxRecycleOrder;
use common\models\Region;

/* @var $this yii\web\View */
/* @var $model backend\modules\box\models\BoxRecycleOrder */
?>
<div class="box-recycle-order-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_no',
            [
                'label'=>'上门人员',
                'value'=> !empty($model->assignUser->username) ? $model->assignUser->username.'('.$model->assignUser->phone.')' : '(未分配)',
            ],
            [
                'label' => '区域名称',
                'value' => Region::getParents($model->region_id)
            ],
            [
                'label' => '用户信息',
                'value' => $model->link_name.'  ( '.BoxRecycleOrder::$sexType[$model->sex].' )  Tel：'.$model->mobile,
            ],
            'address',
            [
                'label' => '服务方式',
                'value' => BoxRecycleOrder::$serviceType[$model->service_type],
            ],
            [
                'label' => '订单金额',
                'value' => $model->price/100,
            ],
            [
                'label' => '优惠金额',
                'value' => $model->reward_price/100,
            ],
            [
                'label' => '订单状态',
                'value' => BoxRecycleOrder::$orderStatus[$model->status]
            ],
            [
                'label' => '预约时间',
                'value' => $model->expect_start_dt.'~~~'.$model->expect_end_dt,
            ],
            'source',
            'create_dt',
            'update_dt',
            'remarks',
        ],
    ]) ?>

</div>
