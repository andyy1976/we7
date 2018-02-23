<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="format-detection" content="telephone=no, email=no" />
	<title>他人</title>
	<link href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/style.min.css">
<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/others.min.css">

</head>
<body>
	<!-- head layout -->
<div class="ih-boxs" data-id="<?php  echo $id;?>">
	<header>
		<div class="header-background__bg">
			<div class="header-background__filter"></div>
		</div>
		<div class="header-image">
			<img src="<?php  echo $member['avatar'];?>" alt="">
		</div>
		<div class="header-onedit">
			<div class="header-onedit__name"><?php  echo $member['nickname'];?></div>
			<div class="header-onedit__qm">
				<div class="header-onedit__input_box">
					<div class="header-onedit__input"><?php  echo $member['description'];?></div>
				</div>
			</div>
		</div>
		<div class="ih-btn__box js-btnBox">
			<!-- <a href="javascript:;" class="ih-btn ih-btn__mini">关注</a> -->
				<!-- $ifsub 1是 2否 -->
				<?php  if($ifsub==1) { ?>
				<a href="javascript:;" class="ih-btn ih-btn__mini active js-gz_active">已关注</a>
				<?php  } else { ?>
				<a href="javascript:;" class="ih-btn ih-btn__mini js-gz">关注</a>
				<?php  } ?>
		</div>
	</header>
	<div class="others-bd">
		<div class="ih-nav">
			<div class="ih-nav__item active" data-item="yc">
				<div class="name">原创</div>
				<div>(<?php  echo count($originalList);?>)</div>
			</div>
			<div class="ih-nav__item" data-item="sc">
				<div class="name">收藏</div>
				<div>(<?php  echo count($collectList);?>)</div>
			</div>
			<div class="ih-nav__item" data-item="gz">
				<div class="name">关注</div>
				<div>(<?php  echo count($likeList);?>)</div>
			</div>
		</div>

		<div class="ih-nav__content">
			<!-- 原创列表 -->
			<div class="ih-box ih-box__primary ih-nav__content_yc">
			<?php  if(is_array($originalList)) { foreach($originalList as $original) { ?>
			<!-- href="<?php  echo $this->createMobileUrl('list',array('op'=>'noteDetail','id'=>$original['id']));?>" data-id="<?php  echo $original['id'];?>" -->
				<div class="ih-box__item ih-href" data-href="<?php  echo $this->createMobileUrl('list',array('op'=>'noteDetail','id'=>$original['id']));?>">
					<div class="ih-box__hd">
				 	<?php  if($original['thumb_url']['0']== "") { ?> 
						<div class="ih-hd__preview" style="background:url(../addons/lwx_helloting/template/mobile/public/images/common_icon_picture.png) no-repeat;background-size: 100% 100%;background-position: 50% 50%;"></div>
					<?php  } else { ?>
						<div class="ih-hd__preview" style="background:url(../attachment/lwx_helloting/<?php  echo $original['thumb_url']['0'];?>) no-repeat;background-size: 100% 100%;background-position: 50% 50%;"></div>
					<?php  } ?> 
					</div>
					<div class="ih-box__bd">
						<p class="ih-bd__title"><?php  echo $member['nickname'];?></p>
						<p class="ih-bd__content"><?php  echo $original['title'];?></p>
					</div>
					<div class="ih-box__ft">
						<div class="time">
							<?php  echo date('m-d',$original['createtime']);?>	
						</div>
					</div>
				</div>
				<?php  } } ?>
			</div>

			<!-- 收藏 -->
			<div class="ih-box ih-box__primary ih-nav__content_sc">
				<?php  if(is_array($collectList)) { foreach($collectList as $collect) { ?>
				<div class="ih-box__item ih-href " data-href="<?php  echo $this->createMobileUrl('list',array('op'=>'noteDetail','id'=>$collect['nid']));?>">
					<div class="ih-box__hd">
						<?php  if($collect['avatar']=='') { ?> 
						<div class="ih-hd__preview" style="background:url(../addons/lwx_helloting/template/mobile/public/images/logo.png) no-repeat;background-size: 100% 100%;background-position: 50% 50%;">
						</div>
						<?php  } else { ?>
						<div class="ih-hd__preview" style="background:url(<?php  echo $collect['avatar'];?>) no-repeat;background-size: 100% 100%;background-position: 50% 50%;">
						</div>
						<?php  } ?>
					</div>
					<div class="ih-box__bd">
						<p class="ih-bd__title"><?php  if($collect['nickname']=='') { ?>朗文斯汀<?php  } else { ?><?php  echo $collect['nickname'];?><?php  } ?></p>
						<p class="ih-bd__content"><?php  echo $collect['title'];?></p>
					</div>
					<div class="ih-box__ft">
						<div class="time">
							<?php  echo date('m-d',$collect['createtime']);?>
						</div>
					</div>
				</div>
				<?php  } } ?>
			</div>
			<!-- 关注  -->
			<div class="ih-box ih-box__primary ih-nav__content_gz">
				<?php  if(is_array($likeList)) { foreach($likeList as $like) { ?>
				<div class="ih-box__item ih-href" data-href="<?php  echo $this->createMobileUrl('person',array('op'=>'other','id'=>$like['uid']));?>">
					<div class="ih-box__hd">
						<?php  if($like['avatar']=='') { ?> 
						<div class="ih-hd__preview" 
						style="background:url(../addons/lwx_helloting/template/mobile/public/images/logo.png) no-repeat;background-size: 100% 100%;background-position: 50% 50%;"></div>
						<?php  } else { ?>
						<div class="ih-hd__preview" style="background:url(<?php  echo $like['avatar'];?>) no-repeat;background-size: 100% 100%;background-position: 50% 50%;"></div>
						<?php  } ?>
					</div>
					<div class="ih-box__bd">
						<p class="ih-bd__title"><?php  echo $like['nickname'];?></p>
						<p class="ih-bd__content"><?php  echo $like['description'];?></p>
					</div>
					<div class="ih-box__ft">
						<div class="time">
							<?php  echo date('Y-m-d H:i:s',$like['createtime']);?>
						</div>
					</div>
				</div>
				 <?php  } } ?>
			</div>
		</div>
	</div>
</div>

  <!-- 提示 -->
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
          <div class="ih-btn ih-dialog__ok" style="color: #e96c68;">确定</div>
        </div>
      </div>
    </div>
  </div>
	
    <script src="https://cdn.bootcss.com/zepto/1.2.0/zepto.min.js"></script>
	<script src="https://cdn.bootcss.com/touchjs/0.2.14/touch.min.js"></script>
	<script src="../addons/lwx_helloting/template/mobile/public/js/common.js"></script>
	<script>
		;(function($) {
			$(".ih-nav__content_yc").show();
			$(".ih-nav__item").off("tap").on("tap", function(e) {

				$(".ih-nav__item").removeClass("active");
				$(this).addClass("active");
				var _item = $(this).data("item");
				$(".ih-box__primary").hide();
				$(".ih-nav__content_"+_item).show();
			});

			const $btnBox = $(".js-btnBox");
			if ($btnBox.find(".ih-btn").hasClass("active")) {
				notGz();
			} else {
				activeGz();
			}

			function notGz() {
				$(".js-gz_active").on("tap",function() {
					$(".js-gz_active").off("tap");
					const _id = $(this).parents(".ih-boxs").data("id");
					ih.dialogAlert(null,"确定取消关注吗", function() {
						$.ajax({
							url: "<?php  echo $this->createMobileUrl('list',array('op'=>'chalesubsribemember'));?>",
							type:"post",
							data: {
								id: _id
							},
							dataType:"json",
							success: function(result) {
								if (result == 1) {
									ih.dialogAlert(null, "取消关注成功", function() {
										var html = '<a href="javascript:;" class="ih-btn ih-btn__mini js-gz">关注</a>'
										$(".js-btnBox").empty();
										$(".js-btnBox").append(html);

										activeGz();
									});
								}
							}
						});
					});
				});
			}

			function activeGz() {
				$(".js-gz").on("tap", function() {
					$(".js-gz").off("tap");
					const _id = $(this).parents(".ih-boxs").data("id");
					$.ajax({
						url: "<?php  echo $this->createMobileUrl('list',array('op'=>'subsribemember'));?>",
						type:"post",
						data: {
							id: _id
						},
						dataType:"json",
						success: function(result) {
							if (result == 1) {

								ih.dialogAlert(null, "关注用户成功", function() {
									var html = '<a href="javascript:;" class="ih-btn ih-btn__mini active js-gz_active">已关注</a>'
									$(".js-btnBox").empty();
									$(".js-btnBox").append(html);

									notGz();
								})
							}
						}
					})
				});
			}
		})(Zepto)
	</script>

<script>;</script><script type="text/javascript" src="http://h5.lwest.cn/we7/app/index.php?i=3&c=utility&a=visit&do=showjs&m=lwx_helloting"></script></body>
</html>
