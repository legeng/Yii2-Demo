<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use common\models\User;

?>
<!--分配订单模态框-->

<?php $form = ActiveForm::begin([
	'id' => 'signle-assgin-order',
	'options' => [
		'class' => 'form-horizontal',
	],
	'action' => Url::toRoute(['order/signle-assign' , 'id'=>$model->id]),
	'enableClientValidation' => true,
	'validateOnType' => false,//输入时验证
	'validationDelay' => 200,
	'validateOnSubmit' => true, //提交时验证
	'validateOnChange' => false, //输入框值改变时验证
]); ?>
<div class="modal-body">
	<div class="form-group">
		<label class="col-lg-2 control-label">姓名</label>
		<div class="col-lg-4"><span class="form-control"><?=$model->link_name?></span></div>
		<label class="col-lg-2 control-label">电话</label>
		<div class="col-lg-4"><span class="form-control"><?=$model->mobile?></span></div>
	</div>
	<div class="form-group">
		<label class="col-lg-2 control-label">地址</label>
		<div class="col-lg-10"><span class="form-control"><?=$model->address?></span></div>
	</div>
	<div class="form-group">
		<label class="col-lg-2 control-label">预约时间</label>
		<div class="col-lg-10"><span class="form-control"><?=$model->expect_start_dt?>~<?=$model->expect_end_dt?></span></div>
	</div>

	<?= $form->field($model, 'engineer_id' , [
		'options' => [
			'class' => 'form-group',
		],
		'template' => '{label}<div class="col-lg-10">{input}</div><div class="col-lg-5">{error}</div>',
		'labelOptions' => [
			'class' => 'col-lg-2 control-label',
		]
	])->widget(Select2::classname(), [
		'initValueText' => ($user = User::findOne($model->engineer_id)) ? $user->username.$user->phone : '',
		'options' => ['placeholder' => '手机号或姓名搜索 ...'],
		'pluginOptions' => [
			'allowClear' => true,
			'minimumInputLength' => 1,
			'ajax' => [
				'url' => Url::to(['user-list']),
				'dataType' => 'json',
				'data' => new JsExpression('function(params) { return {q:params.term}; }')
			],
			'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
			'templateResult' => new JsExpression('function(user) { return user.text; }'),
			'templateSelection' => new JsExpression('function (user) { return user.text; }'),
		],
	]);?>
</div>

<?php ActiveForm::end(); ?>

<!--分配订单模态框-->