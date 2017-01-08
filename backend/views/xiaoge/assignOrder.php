<?php
use backend\modules\box\models\BoxRecycleOrder;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1.0" />
	    <meta name="apple-mobile-web-app-capable" content="yes">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="screen-orientation" content="portrait">
	    <meta name="x5-orientation" content="portrait">
		<title>派发订单</title>
		<link rel="stylesheet" href="/xiaoge/css/common.css">
		<link rel="stylesheet" href="/xiaoge/css/style.css">
		<script type="text/javascript" src="/js/plugins/jQuery/jquery-2.2.3.min.js"></script>
		<script type="text/javascript">
			var showBox = function(msg) {
		        $("#showBox").remove();
		        $('body').append($("<div id='showBox' style='display:none'><p>" + msg + "</p></div>"));
		        $('#showBox').css({
		          'display': 'block',
		          'position': 'fixed',
		          'top': 0,
		          'left': 0,
		          'bottom':0,
		          'right':0,
		          'margin':'auto',
		          'background-color': 'rgba(0,0,0,0.65)',
		          'width': '250px',
		          'height': '32px',
		          'font-size':'16px',
		          'color': '#fff',
		          'line-height': '32px',
		          'text-align': 'center',
		          'border-radius': '3px',
		          'padding': '10px 20px',
		          'z-index':99999
		        });
		        setTimeout(function () {
		          $("#showBox").remove();
		        }, 1800);
		    }

			$(document).on('click' , '.submits' , function(){
				var id = $(this).data('orderId');
				$.ajax({
					url:"<?=Url::to(['xiaoge/confirm-order'])?>",
					type:'post',
					data:{
						id:id,
						status:3,
						user_id:<?=Yii::$app->request->get('user_id')?>,
						access_token:<?=Yii::$app->request->get('access_token')?>
					},
					dataType:'json'
				}).done(function(e){
					if(e.code == '0'){
						showBox(e.message);
						$("#item"+id).slideUp(function(){
							$("#item"+id).remove();
						});

						if($(".item").length == 0){

						}
					}
				}).fail(function(){

				})
		})
		</script>
	</head>
	<body>
		<div class="page">
			<header>
				<img src="/xiaoge/images/top.png"/>
			</header>
			<div class="list">
				<?php
					foreach($orderList as $order){
				?>
				<div class="item" id="item<?=$order->id?>">
					<ul>
						<li>订单编号:
							<span class="orderId"><?= $order->order_no ?></span>
							<span class="kefu">
								<a href="tel:00788888"><i></i>联系客服取消订单</a>
							</span>
						</li>
						<li class="item-center">
							<p class="time">预约开始时间:	 <span class="expectDate"><?= $order->expect_start_dt ?></span></p>
							<p class="time">预约结束时间:	 <span class="expectDate"><?= $order->expect_end_dt ?></span></p>
							<div class="info-bor">
								<img src="/xiaoge/images/box.png"/>
								<div class="xq">
										<div class="con-bor">
											<div class="left">联系人:</div>
											<div class="rt" id="linkPeople">
												<?= $order->link_name ?>  <?=BoxRecycleOrder::$sexType[$order->sex]?>
												<span class="tel"><?= $order->mobile?></span>
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="con-bor add">
											<div class="left">地&nbsp;&nbsp;&nbsp;址:</div>
											<div class="rt" id="address"><?=$order->address?></div>
										</div>
										<div class="clearfix"></div>
								</div>
								<div class="clearfix"></div>
							</div>
						</li>
						<li>下单时间：
							<span class="creatTime"><?=$order->create_dt?></span>
							<span class="jiedan_btn submits" data-order-id="<?=$order->id?>">确认接单</span>
						</li>
					</ul>
				</div>
				<?php 
					}
				?>
			</div>
		</div>
	</body>
</html>
