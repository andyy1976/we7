<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="format-detection" content="telephone=no, email=no" />
	<title>消息</title>
	<link href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/style.min.css">
	
<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/message.min.css">

</head>
<body>
	<!-- head layout -->
	

	
	<div class="message-box">
		<nav class="message-nav">
			<div class="message-nav__item" data-nav="fx">发现</div>
			<div class="message-nav__item nav-active" data-nav="dt">动态</div>
			<div class="message-nav__item" data-nav="pl">评论</div>
		</nav>
		<!-- 发现 -->
		<div class="message-info info__fx">
			<?php  if(is_array($notelist)) { foreach($notelist as $note) { ?>
			<a href="<?php  echo $this->createMobileUrl('list',array('op'=>'noteDetail','id'=>$note['id']));?>">
			<section class="message-section__item">
				<div class="item-head">
					<img src="<?php  echo $note['avatar'];?>" alt="">
				</div>
				<div class="item-text">
					<div><?php  echo $note['nickname'];?></div>
					<div class="item-text__bottom"><?php  echo $note['title'];?></div>
				</div>
				<div class="item-type">
					<span><?php  echo date('m-d',$note['createtime']);?></span>
				</div>
			</section>
			</a>
			<?php  } } ?>
		</div>
		
		<!-- 动态 -->
		<div class="message-info info__dt">
			<?php  if(is_array($messageList)) { foreach($messageList as $message) { ?>
				<!-- 1关注  2点赞 3打赏 4收藏 5评论 -->
				<?php  if($message['type']==1) { ?>
					<section class="message-section__item">
						<div class="item-head">
							<img src="<?php  echo $message['avatar'];?>" alt="">
						</div>
						<div class="item-text"><?php  echo $message['nickname'];?>关注了你</div>
						<div class="item-type">
							<img src="../addons/lwx_helloting/template/mobile/public/images/common_icon_collect.png" alt="">
							<span> +1</span>
						</div>
					</section>
				<?php  } else if($message['type']==2) { ?>
					<section class="message-section__item">
						<div class="item-head">
							<img src="<?php  echo $message['avatar'];?>" alt="">
						</div>
						<div class="item-text"><?php  echo $message['nickname'];?>为你点赞</div>
						<div class="item-type">
							<img src="../addons/lwx_helloting/template/mobile/public/images/common_btn_like_s.png" alt="">
							<span> +1</span>
						</div>
					</section>
				<?php  } ?>
			<?php  } } ?>
		</div>
		<!-- 评论 -->
		<div class="message-info info__pl">
			<?php  if(is_array($commentlist)) { foreach($commentlist as $comment) { ?>
			<section class="message-section__item">
				<div class="item-head">
					<img src="<?php  echo $comment['avatar'];?>" alt="">
				</div>
				<div class="item-text">
					<div><?php  echo $comment['nickname'];?></div>
					<div class="item-text__bottom"><?php  echo $comment['content'];?></div>
				</div>
				<div class="item-type">
					<span><?php  echo date('m-d ',$comment['createtime']);?></span>
				</div>
			</section>
			<?php  } } ?>
		</div>
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
			$(".footer-but").eq(1).addClass("footer-active");

			$(".footer-but").on("tap", function() {
				location.href = $(this).data("href");
			});
		})(Zepto)
	</script>
	
<script src="../addons/lwx_helloting/template/mobile/public/js/message.js"></script>

<script>;</script><script type="text/javascript" src="http://h5.lwest.cn/we7/app/index.php?i=3&c=utility&a=visit&do=showjs&m=lwx_helloting"></script></body>
</html>
