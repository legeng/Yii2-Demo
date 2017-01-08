
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>登录</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/css/skins/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/css/skins/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/plugins/iCheck/square/blue.css">
  
   <!-- style -->
  <link rel="stylesheet" href="/css/style.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="/"><b>后台管理</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
      <?php 
            use yii\helpers\Html;
            use yii\widgets\ActiveForm;

            $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'm-t ','role'=>'form',],
                'action' => ['/site/login'],
                'method'=>'post',
            ]); ?>

            <?= $form->field($model, 'phone')->textInput(['autofocus' => true,'placeholder'=>'请输入名称','required'=>""])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'请输入密码','required'=>""])->label(false) ?>

            <?= $form->field($model, 'rememberMe',[
                'template' => '{label}{input}<label class="pull-right"><a href="#" class="forget-password">忘记登录密码?</a></label>',
            ])->checkbox()->label(false) ?>
               
            <?= Html::submitButton('登 录', ['class' => 'btn btn-primary btn-lg block full-width m-b']) ?>

            <?php ActiveForm::end(); 
      ?>

    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-google btn-lg block full-width m-b">注   册</a>
    </div>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
