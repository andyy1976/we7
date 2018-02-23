<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="format-detection" content="telephone=no, email=no" />
	<title>分类列表</title>
	<script>
        (function (doc, win) {
            var docEl = doc.documentElement,
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function () {
                    var clientWidth = docEl.clientWidth;
                    if (!clientWidth) return;
                    if(clientWidth>=750){
                        // 这里的640 取决于设计稿的宽度
                        docEl.style.fontSize = '100px';
                    }else{
                        docEl.style.fontSize = 100 * (clientWidth / 750) + 'px';
                    }
                };

            if (!doc.addEventListener) return;
            win.addEventListener(resizeEvt, recalc, false);
            doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);
	</script>
	<style>
		*{
			list-style:none;
			margin:0;
			padding:0;
		}
		html,body{
			width:100%;
			height:100%;
			overflow: hidden;
			background:#f2f2f2;
		}
		ul{
			width:100%;
			height:100%;
			overflow: hidden;
		}
		a{
			width:48%;
			height:3.4rem;
			display: block;
			float:left;
			margin:0.2rem 1% 0 1%;
			text-decoration:none;
		}
		li{
			width:100%;
			height:2.4rem;
			float:left;
		}
		p{
			width:100%;
			height:0.7rem;
			color:#000;
			font-size:0.3rem;
			text-align: center;
			line-height:0.7rem;
		}
	</style>
</head>
<body>
	<ul>
		<?php  if(is_array($themelist)) { foreach($themelist as $theme) { ?>
		<a href="<?php  echo $this->createMobileUrl('feedback',array('op'=>'train_list','id'=>$theme['id'],'type'=>'ccate'));?>">
			<li style="background-image:url(http://h5.lwest.cn/hellot_admin/thinkphp3/Public/uploads/<?php  echo $theme['thumb'];?>);background-size:100%;background-repeat: no-repeat;background-position:center"></li>
			<p><?php  echo $theme['name'];?></p>
		</a>
		<?php  } } ?>
	</ul>
<script>;</script><script type="text/javascript" src="http://h5.lwest.cn/we7/app/index.php?i=3&c=utility&a=visit&do=showjs&m=lwx_helloting"></script></body>
</html>
