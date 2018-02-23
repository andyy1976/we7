<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="format-detection" content="telephone=no, email=no" />
	<title><?php  echo $title;?></title>
	<link href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/style.min.css">
	
<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/train.min.css">

</head>
<body>
	<!-- head layout -->
	

	
<div class="ih-box ih-box__train">

<?php  if(is_array($notelist)) { foreach($notelist as $note) { ?>
<!--4  手册进detail  5 视频进train_detail页面   -->
<?php  if($note['cateid']==4) { ?>
<div class="ih-box__item ih-href" data-href="<?php  echo $this->createMobileUrl('list', array('op'=>'noteDetail','id'=>$note['id']));?>">
<?php  } else { ?>
<div class="ih-box__item ih-href" data-href="<?php  echo $this->createMobileUrl('feedback', array('op'=>'train_detail','id'=>$note['id']));?>">
<?php  } ?>
  
		<div class="ih-box__hd">
			<div class="ih-border__image">
				<div style="background-image:url(http://h5.lwest.cn/hellot_admin/thinkphp3/Public/uploads/<?php  echo $note['thumb'];?>);background-size:100%;background-repeat:no-repeat;background-position:center;height: 100%;"></div>
			</div>
		</div>
		<div class="ih-box__bd">
			<p class="ih-bd__title" style="height: 42px;"><?php  echo $note['title'];?></p>
			<div class="ih-bd__content">
        <div class="ih-bd__content_fd"><?php  if($note['cateid']==4) { ?>培训手册/朗文斯汀<?php  } else { ?>培训视频/朗文斯汀<?php  } ?></div>
        <div class="ih-bd__content_bd"><img src="../addons/lwx_helloting/template/mobile/public/images/look.png" alt=""><span><?php  echo $note['readno'];?></span></div>
      </div>
		</div>
	</div>
<?php  } } ?>
</div>


	
    <script src="https://cdn.bootcss.com/zepto/1.2.0/zepto.min.js"></script>
	<script src="https://cdn.bootcss.com/touchjs/0.2.14/touch.min.js"></script>
	<script src="../addons/lwx_helloting/template/mobile/public/js/common.js"></script>

	
<script>
  ;(function($) {

  })(Zepto)
</script>

<script>;</script><script type="text/javascript" src="http://h5.lwest.cn/we7/app/index.php?i=3&c=utility&a=visit&do=showjs&m=lwx_helloting"></script></body>
</html>
