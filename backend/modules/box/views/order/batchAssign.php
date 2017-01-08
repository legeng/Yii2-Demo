<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;

?>
<!--分配订单模态框-->

<?php $form = ActiveForm::begin([
	'id' => 'assgin-order-form',
	'options' => [
		'class' => 'form-horizontal',
	],
	'action' => Url::toRoute(['order/batch-assign']),
	'enableClientValidation' => true,
	'validateOnType' => false,//输入时验证
	'validationDelay' => 200,
	'validateOnSubmit' => true, //提交时验证
	'validateOnChange' => false, //输入框值改变时验证
]); ?>
<div class="modal-body">
		<div class="form-group">
			<?php
			foreach ($orderList as $order) {
				echo '<div class="col-lg-6"><span class="form-control">'.$order['link_name']." ( ".$order['mobile'].' )</span></div>';
			}
			?>
		</div>

		<?= Html::hiddenInput('orderIds', $value = $orderIds, $options = []) ?>
        <?php echo Select2::widget([
        		'name' => 'engineer_id',
        		'value' => '0',
			    'initValueText' => '随机分配', 
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
			]);
		?>
</div>	
<?php ActiveForm::end(); ?>
<!--分配订单模态框-->