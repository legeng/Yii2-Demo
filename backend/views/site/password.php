<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<!--修改密码模态框-->
<?php $form = ActiveForm::begin([
	'id' => 'update-password-form',
	'options' => [
		'class' => 'form-horizontal',
	],
	'action' => Url::toRoute(['/site/password' , 'id'=>$model->id]),
	'enableClientValidation' => true,
	'validateOnType' => false,//输入时验证
	'validationDelay' => 200,
	'validateOnSubmit' => true, //提交时验证
	'validateOnChange' => false, //输入框值改变时验证
]); ?>
<div class="modal-body">
        <div class="form-group"><label class="col-lg-2 control-label">旧密码</label>
            <div class="col-lg-10"><input type="password" name="oldPassword" placeholder="请输入旧密码" class="form-control" required ></div>
        </div>
        <div class="form-group"><label class="col-lg-2 control-label">新密码</label>
            <div class="col-lg-10"><input type="password" name="newPassword" placeholder="请输入新密码" class="form-control" required ></div>
        </div>
</div>
	
<?php ActiveForm::end(); ?>
<!--修改密码模态框-->