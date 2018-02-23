<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="format-detection" content="telephone=no, email=no" />
	<title>设置</title>
	<link href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/style.min.css">
	
<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/me.min.css">

</head>
<body>
	<!-- head layout -->
	

	
<div class="me-box">
  <section>
<!--     <div class="section-box">
				<div class="section-list__link ih-href" data-href="<?php  echo $this->createMobileUrl('person',array('op'=>'set_password'));?>">设置新密码</div>
		</div> -->
    <div class="section-box">
				<div class="section-list__link ih-href" data-href="<?php  echo $this->createMobileUrl('person',array('op'=>'set_help'));?>">帮助反馈</div>
				<div class="section-list__link">关于HELLO★汀</div>
		</div>
  </section>
<!--   <div class="ih-btn ih-btn__out">
    退出登录
  </div> -->
</div>


	
    <script src="https://cdn.bootcss.com/zepto/1.2.0/zepto.min.js"></script>
	<script src="https://cdn.bootcss.com/touchjs/0.2.14/touch.min.js"></script>
	<script src="../addons/lwx_helloting/template/mobile/public/js/common.js"></script>


	<script>
		$('.section-list__link').on("touchend",function(){
		    location.href="http://h5.lwest.cn/we7/app/index.php?i=3&c=entry&op=about_hello&do=person&m=lwx_helloting";
		})
	</script>

<script>;</script><script type="text/javascript" src="http://h5.lwest.cn/we7/app/index.php?i=3&c=utility&a=visit&do=showjs&m=lwx_helloting"></script></body>
</html>
