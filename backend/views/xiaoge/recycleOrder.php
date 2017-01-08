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
		<title>我的收货单</title>
		<link rel="stylesheet" href="/xiaoge/css/common.css">
		<link rel="stylesheet" href="/xiaoge/css/style.css">
		<script type="text/javascript" src="/js/plugins/jQuery/jquery-2.2.3.min.js"></script>
		<script type="text/javascript">
			localStorage.removeItem('coins');
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

			$(document).on('click' , '.submit' , function(){
				var id = $(this).data('orderId');
				var coins = localStorage.getItem('coins');
				if(coins === null || coins === undefined || coins === ''){
					showBox('请确认回收币');
					return false;
				}
				$.ajax({
					url:"<?=Url::to(['xiaoge/confirm-order'])?>",
					type:'post',
					data:{
						id:id,
						status:7,
						coins:localStorage.getItem('coins'),
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

		$(document).on('click' , '.circle i' ,function(){
			localStorage.setItem('coins' , $(this).data('recycleCoins'));
			$('.circle i').removeClass('on');
			$(this).addClass('on');
		})
		</script>
	</head>
	<body>
		<div class="page">
			<header>
				<img src="/xiaoge/images/hd.png"/>
			</header>
			<div class="list">
				<?php 
					foreach ($orderList as $order) {
				?>	
				<div class="item" id="item<?=$order->id?>">
					<ul>
						<li>订单编号:
							<span class="orderId"><?= $order->order_no ?></span>
							<span class="kefu">
								<a href="tel:00788888"><i></i>联系客服反应问题</a>
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
											<div class="rt" id="address"><?=$order->address?> </div>
										</div>
										<div class="clearfix"></div>
								</div>
								<div class="clearfix"></div>
							</div>
							<p class="bot-p">下单时间:<span class="creatTime"><?=$order->create_dt?></span></p>
							<p class="bot-p">订单状态:<span class="flag"><?=BoxRecycleOrder::$orderStatus[$order->status]?></span></p>
						</li>
						<li class="last">
							<div class="jinbi">
								<div class="content">
									<span class="active">空空如也=1回收币</span>
									<span class="active">未满半箱=10回收币</span>
									<span class="active">满1箱=20回收币</span>
								</div>
								<div class="circle">
									<span><i data-recycle-coins="1"></i></span>
									<span><i data-recycle-coins="10"></i></span>
									<span><i data-recycle-coins="20"></i></span>
								</div>
							</div>
							<span class="submit on" data-order-id="<?=$order->id?>">提交订单</span>
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
