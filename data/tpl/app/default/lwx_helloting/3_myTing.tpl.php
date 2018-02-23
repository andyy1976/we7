<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="format-detection" content="telephone=no, email=no" />
	<title>我★汀</title>
	<link href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/style.min.css">
	
<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/ting.min.css">

</head>
<body>
	<!-- head layout -->
	

	
<div class="ting-box">
	<section>
		<div class="section-box">
			<a href="<?php  echo $this->createMobileUrl('feedback', array('op'=>'myTing_newgoods'));?>">
				<div class="section-list__link">新货反馈表</div>
			</a>
		</div>
		<div class="section-box">
			<a href="<?php  echo $this->createMobileUrl('feedback', array('op'=>'myTing_feedback'));?>">
				<div class="section-list__link">质量反馈</div>
			</a>
		</div>
		<div class="section-box">
			<a href="<?php  echo $this->createMobileUrl('feedback', array('op'=>'opening1'));?>">
				<div class="section-list__link">开业满意度评分表</div>
			</a>
		</div>
		<div class="section-box">
			<a href="<?php  echo $this->createMobileUrl('feedback', array('op'=>'opening5'));?>">
				<div class="section-list__link">店铺设计及道具满意度评分表</div>
			</a>
		</div>
	</section>
</div> 


	<!-- foot layout -->
	<footer>
	<div class="footer-but ih-href" data-href="<?php  echo $this->createMobileUrl('feedback');?>">
		<img class="footer__image" src="../addons/lwx_helloting/template/mobile/public/images/common_nav_btn_home_n.png" alt="">
		<img class="footer-active__image" src="../addons/lwx_helloting/template/mobile/public/images/common_nav_btn_home_s.png" alt="">
		<div>主页</div>
	</div>
	<div class="footer-but ih-href" data-href="<?php  echo $this->createMobileUrl('feedback', array('op'=>'message'));?>">
		<img class="footer__image" src="../addons/lwx_helloting/template/mobile/public/images/common_nav_btn_message_n.png" alt="">
		<img class="footer-active__image" src="../addons/lwx_helloting/template/mobile/public/images/common_nav_btn_message_s.png" alt="">
		<div>消息</div>
	</div>
	<div class="footer-but release-info ih-href" data-href="<?php  echo $this->createMobileUrl('feedback', array('op'=>'publish'));?>">
		<img src="../addons/lwx_helloting/template/mobile/public/images/common_nav_btn_release.png" alt="">
	</div>
	<div class="footer-but ih-href" data-href="<?php  echo $this->createMobileUrl('feedback', array('op'=>'myTing'));?>">
		<img class="footer__image" src="../addons/lwx_helloting/template/mobile/public/images/common_nav_btn_form_n.png" alt="">
		<img class="footer-active__image" src="../addons/lwx_helloting/template/mobile/public/images/common_nav_btn_form_s.png" alt="">
		<div>我★汀</div>
	</div>
	<div class="footer-but ih-href" data-href="<?php  echo $this->createMobileUrl('feedback', array('op'=>'me'));?>">
		<img class="footer__image" src="../addons/lwx_helloting/template/mobile/public/images/common_nav_btn_me_n.png" alt="">
		<img class="footer-active__image" src="../addons/lwx_helloting/template/mobile/public/images/common_nav_btn_me_s.png" alt="">
		<div>我</div>
	</div>
</footer>

	
    <script src="https://cdn.bootcss.com/zepto/1.2.0/zepto.min.js"></script>
	<script src="https://cdn.bootcss.com/touchjs/0.2.14/touch.min.js"></script>
	<script src="../addons/lwx_helloting/template/mobile/public/js/common.js"></script>
	
	<script type="text/javascript">
		;(function($) {
			$(".footer-but").eq(3).addClass("footer-active");

			$(".footer-but").on("tap", function() {
				location.href = $(this).data("href");
			});
		})(Zepto)
	</script>
	


<script>;</script><script type="text/javascript" src="http://h5.lwest.cn/we7/app/index.php?i=3&c=utility&a=visit&do=showjs&m=lwx_helloting"></script></body>
</html>
