<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Region */
?>
<div class="region-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'pid',
            'name',
            'service_type',
            'level',
            'open_flag',
            'path',
            'short',
            'remarks',
        ],
    ]) ?>

</div>
