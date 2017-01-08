<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->params['title'] = $exception->statusCode;
$this->params['message'] = $exception->getMessage();

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= Html::encode($this->params['title']) ?> | 错误</title>

    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown">
        <h1><?= Html::encode($this->params['title']) ?></h1>
        <h3 class="font-bold"><?= nl2br(Html::encode($this->params['message'])) ?></h3>

        <div class="error-desc" style="line-height: 24px;">
            抱歉, 服务器在处理您的请求时发生了错误, 如果您认为这是一个服务器错误，请及时与我们联系，谢谢。
            ( <span id="sec" style="color:red;font-weight:bold">5</span> )秒后将返回上一页
            <a href="javascript:history.back()">点击立即返回</a>
        </div>
    </div>
    <script>
            var seco=document.getElementById("sec");
            var time= 5;
            var tt=setInterval(function(){
                    time--;
                    seco.innerHTML=time;    
                    if(time<=0){
                        clearInterval(tt);
                        history.back();
                        return;
                    }
                }, 1000);
    </script>


</body>

</html>
