<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="format-detection" content="telephone=no, email=no" />
	<title>新货反馈表</title>
	<link href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/style.min.css">
	
<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/ting.min.css">

</head>
<body>
	<!-- head layout -->
	

	
<div class="ting-box">
	<div class="time-dropdown">
		<div class="time-dropdown__year">
			<span class="year">年份</span>
			<div class="ih-dropdown">
				<div class="ih-dropdown__text" data-item="2017">2017</div>
				<div class="ih-dropdown__list">
					<ul class="ih-dropdown__menu">
						<li class="ih-dropdown__item" data-item="2017">2017</li>
						<li class="ih-dropdown__item" data-item="2016">2016</li>
						<li class="ih-dropdown__item" data-item="2015">2015</li>
						<li class="ih-dropdown__item" data-item="2014">2014</li>
						<li class="ih-dropdown__item" data-item="2013">2013</li>
						<li class="ih-dropdown__item" data-item="2012">2012</li>
					</ul>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="time-dropdown__quarter">
			<span class="year">季度</span>
			<div class="ih-dropdown">
				<div class="ih-dropdown__text" data-item="1">春</div>
				<div class="ih-dropdown__list">
					<ul class="ih-dropdown__menu">
						<li class="ih-dropdown__item" data-item="1">春</li>
						<li class="ih-dropdown__item" data-item="2">夏</li>
						<li class="ih-dropdown__item" data-item="3">秋</li>
						<li class="ih-dropdown__item" data-item="4">冬</li>
					</ul>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<section>
		<div class="section-box feedback-box">
			<div class="section-list__link">
				<label class="weui-label">服装质量</label>
				<ul class="mark js-zl" data-item="0">
					<li class="mark-item"></li>
					<li class="mark-item"></li>
					<li class="mark-item"></li>
					<li class="mark-item"></li>
					<li class="mark-item"></li>
				</ul>
			</div>
		</div>
		<div class="section-box feedback-box">
			<div class="section-list__link">
				<label class="weui-label">季度款式</label>
				<ul class="mark js-ks" data-item="0">
					<li class="mark-item"></li>
					<li class="mark-item"></li>
					<li class="mark-item"></li>
					<li class="mark-item"></li>
					<li class="mark-item"></li>
				</ul>
			</div>
		</div>
		<div class="section-box feedback-box">
			<div class="section-list__link">
				<label class="weui-label">销售情况</label>
				<ul class="mark js-qk" data-item="0">
					<li class="mark-item"></li>
					<li class="mark-item"></li>
					<li class="mark-item"></li>
					<li class="mark-item"></li>
					<li class="mark-item"></li>
				</ul>
			</div>
		</div>
	</section>

	<div class="ih-xxx__box">
		<div class="ih-btn__red js-btn" data-href="<?php  echo $this->createMobileUrl('feedback', array('op'=>'editfeedback', 'type'=>'0'));?>">下一步</div>
	</div>
</div> 

	
	<!-- 提示框 -->
	<div class="ih-dialog__box">
		<div class="ih-mask"></div>
		<div class="ih-dialog">
			<div class="ih-dialog__hd">
				<div class="ih-dialog__title">
					提示
				</div>
			</div>
			<div class="ih-dialog__bd">
				提示内容
			</div>
			<div class="ih-dialog__ft">
				<div class="ih-btn__box">
					<div class="ih-btn ih-dialog__ok" style="color:#e96c68">确定</div>
				</div>
			</div>
		</div>
	</div>

	
    <script src="https://cdn.bootcss.com/zepto/1.2.0/zepto.min.js"></script>
	<script src="https://cdn.bootcss.com/touchjs/0.2.14/touch.min.js"></script>
	<script src="../addons/lwx_helloting/template/mobile/public/js/common.js"></script>
<script>
	(function() {
		$(".js-btn").on("tap", function() {
			// if ()
			const yearItem = $(".time-dropdown__year .ih-dropdown__text").data("item");
			const quarterItem = $(".time-dropdown__quarter .ih-dropdown__text").data("item");
			const zlItem = $(".js-zl").data("item");
			if (zlItem == "0") {
				ih.dialogAlert(null, "请选择您的评分");
				return false;
			}
			const ksItem = $(".js-ks").data("item");
			if (ksItem == "0") {
				ih.dialogAlert(null, "请选择您的评分");
				return false;
			}
			const qkItem = $(".js-qk").data("item");
			if (qkItem == "0") {
				ih.dialogAlert(null, "请选择您的评分");
				return false;
			}

			localStorage.newgoodes = JSON.stringify({
							yearItem,
							quarterItem,
							zlItem,
							ksItem,
							qkItem
						});

			location.href = $(this).data("href");

		});
	})();
</script>

<script>;</script><script type="text/javascript" src="http://h5.lwest.cn/we7/app/index.php?i=3&c=utility&a=visit&do=showjs&m=lwx_helloting"></script></body>
</html>
