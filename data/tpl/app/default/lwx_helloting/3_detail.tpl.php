<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="format-detection" content="telephone=no, email=no" />
	<title>详情</title>
	<link href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/style.min.css">
	<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/detail.min.css">
	<style>
		.ih-boxs img{
			width:100%;
		}
	</style>
</head>
<body>
	<!-- head layout -->
	
	<div class="ih-body">
		<div class="ih-body__bd">
			<section class="ih-boxs">
				<div class="ih-hd__title">
					<h1><?php  echo $note['title'];?></h1>
					<div class="collection">
						<?php  if($ifcollect==2) { ?>
						<img class="js-collection_n" src="../addons/lwx_helloting/template/mobile/public/images/common_btn_collect_n.png" alt="">
						<?php  } else { ?>
						<img class="js-collection_s" src="../addons/lwx_helloting/template/mobile/public/images/common_btn_collect_s.png" alt="">
						<?php  } ?>
					</div>
				</div>
				<?php  if($note['content']=='') { ?>
				暂无文章。。。
				<?php  } else { ?>
				<?php  echo $note['content'];?>
				<?php  } ?>


					<?php  if($note['pdf_url'] != "") { ?>
					<div class="ih-href" style="display: flex;margin-top: 10px" data-href="http://h5.lwest.cn/hellot_admin/thinkphp3/Public/uploads/<?php  echo $note['pdf_url'];?>">
						<img style="width: 44px; height: 44px;margin-right: 5px;" src="../addons/lwx_helloting/template/mobile/public/images/pdf.png" alt="">
						<div style="line-height: 44px"><?php  echo $note['pdf_name'];?></div>
					</div>
					<?php  } ?>


				<div class="ih-bd__box">
					<ul class="weui-media-box__info ih-media-box__info">
		                <li class="weui-media-box__info__meta ih-media-box__info__meta weui-media-box__info__meta_extra">点赞 <span class="js-dztext"><?php  echo $note['likeno'];?></span></li>
		                <li class="weui-media-box__info__meta ih-media-box__info__meta">创建于<?php  echo date('m-d',$note['createtime']);?></li>
		            </ul>
				</div>
				<div class="ih-bd__box">
					<div class="ih-function__info">
						<?php  if($iflike == 1) { ?>
						<div class="ih-function-praise__info js-goods_s"></div>
						<?php  } else { ?>
						<div class="ih-function-praise__info js-goods_n"></div>
						<?php  } ?>
					</div>
					<!-- 点赞头像列表 -->

					<?php  if($note['likeno']>0) { ?>
					<div class="ih-bd__box ih-list__box">
						<ul class="ih-list">
							<?php  if(is_array($likeList)) { foreach($likeList as $l) { ?>
							<li class="ih-list__item">
								<img src="<?php  echo $l['avatar'];?>" alt="">
							</li>
							<?php  } } ?>
						</ul>
					</div>
					<?php  } ?>
				</div>
			</section>
			<div class="ih-box">
				<div class="ih-box__item">
					<div class="ih-box__hd">
						<div class="ih-border__image">
							<?php  if($authid>0) { ?>
							<img src="<?php  echo $member['avatar'];?>" alt="">
							<?php  } else { ?>
							<img src="../addons/lwx_helloting/template/mobile/public/images/logo.png" alt="">
							<?php  } ?>
						</div>
					</div>
					<!-- 发布人   -->
					<div class="ih-box__bd">
						<p class="ih-bd__title"><?php  echo $member['nickname'];?></p>
						<p class="ih-bd__content"><?php  echo $member['description'];?></p>
					</div>
						<!-- 如果发布人为粉丝用户，可以进行关注 -->
						<div class="ih-box__ft">
						<div class="ih-btn__box">
						<?php  if($ifsub == 2) { ?>
							<a href="javascript:;" class="ih-btn ih-btn__mini js-gz">关注</a>
						<?php  } else { ?>
							<a href="javascript:;" class="ih-btn ih-btn__mini" style="background-color: #e96c68;color: #fff">已关注</a>
						<?php  } ?>
						</div>
						<!-- 关注  <?php  echo $this->createMobileUrl('list',array('op'=>'subsribemember'));?>
						     data:id  为当前帖主粉丝的id ，也就是$authid 
						            返回值说明 1 关注成功   2已经关注，不可重复关注
						 -->
						<!-- <a href="javascript:;" class="weui-btn ih-btn_mini weui-btn_warn">关注</a> -->
					</div>
					
				</div>
			</div>

			<div class="ih-boxs__title">评论<em class="ih-em"><?php  echo $note['commentno'];?></em></div>
			<!-- 评论列表 -->
			<div class="ih-box ih-box__comment">
				<?php  if(count($commentlist) > 0) { ?>
					<?php  if(is_array($commentlist)) { foreach($commentlist as $comment) { ?>
					<div class="ih-box__item" data-name="<?php  echo $comment['nickname'];?>" data-uid="<?php  echo $comment['uid'];?>">
						<div class="ih-box__hd">
							<div class="ih-border__image">
								<img src="<?php  echo $comment['avatar'];?>" alt="">
							</div>
						</div>
						<div class="ih-box__bd">
							<p class="ih-bd__title"><?php  echo $comment['nickname'];?></p>
							<p class="ih-bd__content">
								<span class="ih-man" style="margin: 0"><?php  echo $comment['replynickname'];?></span>
								<?php  echo $comment['content'];?>
							</p>
						</div>
						<div class="ih-box__ft">
							<div class="time">
								<?php  echo date('m-d',$comment['createtime']);?>
							</div>
						</div>
					</div>
					 <?php  } } ?>
					
					<?php  if(count($commentlist) > 5) { ?>
					<div class="more">
						加载更多+
					</div>
					<?php  } ?>
				<?php  } else { ?>
				<div class="ih-box__item" style="background-color: #f5f5f5;font-size:12px;text-align: center;display:block;color:#ccc">
					请快来抢沙发吧~
			 	</div>
				<?php  } ?>
			</div>

			<div class="ih-boxs__title">相关文章</div>
			<div class="ih-box">
				<!-- 相关文章列表 -->			
				<?php  if(is_array($aboutnote)) { foreach($aboutnote as $article) { ?>
				<div class="ih-box__item ih-relevant__item" onclick="myRedirect('<?php  echo $_W['script_name'];?>?i=3&c=entry&op=noteDetail&id=<?php  echo $article['id'];?>&do=list&m=lwx_helloting')">
					<div class="ih-box__bd">
						<h1><?php  echo $article['title'];?></h1>
						<div class="ih-bd__content"><?php  echo date('m月d日',$article['createtime']);?> <?php  echo $article['nickname'];?></div>
					</div>
					<div class="ih-box__ft">
				<?php  if($article['thumb_url']['0'] == "") { ?>
				<!--<div class="thumbnail" style="background:url(../addons/lwx_helloting/template/mobile/public/images/common_icon_picture.png) no-repeat;background-size: cover;background-position: 50% 50%;"></div>-->
				
				<?php  } else { ?>
				<div class="thumbnail" style="background:url(../attachment/lwx_helloting/<?php  echo $article['thumb_url']['0'];?>) no-repeat;background-size: cover;background-position: 50% 50%;"></div>

				<?php  } ?>


						
					</div>
				</div>
				<?php  } } ?>
			 
			</div>
		</div>
	</div>
	<div class="ih-eidt">
		<div class="ih-edit__hd">
			<input type="text" placeholder="说点什么......">
		</div>
		<div class="ih-eidt__ft">
			<div class="ih-tap__fb js-comment">发布</div>
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
		;(function($) {
			var Main = {
				handleClickgood: function() {
					var ft = "<?php  echo $iflike?>";
					if (ft == "2") {
						a();
					}

					if (ft == "1") {
						b();
					}

					function a () {
						// 点赞
						$(".ih-function__info").on("tap",".js-goods_n", function(e) {
							$(".ih-function__info").off("tap",".js-goods_n");
							var _self = $(this);
							var num = "<?php  echo $note['likeno'];?>";
							var numDz = $(".js-dztext").html();

							$.ajax({
								url: "<?php  echo $this->createMobileUrl('list',array('op'=>'addnotelike'));?>",
								data: {
									id: <?php  echo $id;?>
								},
								type: "get",
								success: function(result) {
									if (result == 1) {

										if (num == "0") {
										    //盒子
											var htmls = '<div class="ih-bd__box ih-list__box"><ul class="ih-list">'
													+ '</ul></div>';
											_self.parent().parent().append(htmls);
										}
										//大拇指
										var html = '<div class="ih-function-praise__info js-goods_s"></div>';
										_self.parent().html(html);
										var htmlheard = '<li class="ih-list__item"><img src="<?php  echo $avatar;?>" alt=""></li>'
										$(".ih-list__box .ih-list").prepend(htmlheard);
										$(".js-dztext").html(parseInt(numDz) + 1);

										b();
									} else {
										console.log("点赞失败");
										a();
									}
								}
							})
						});
					} 
					
					function b () {
						// 取消点赞
						$(".ih-function__info").on("tap",".js-goods_s",  function(e) {
							$(".ih-function__info").off("tap",".js-goods_s");
							var _self = $(this);
							var num = "<?php  echo $note['likeno'];?>";
							var numDz = $(".js-dztext").html();
							// 头像
							var _avatar = "<?php  echo $avatar;?>";
							var $srcAvatar = $(".ih-list__item img");
							var srcAvatarNum = $srcAvatar.length;

							$.ajax({
								url: "<?php  echo $this->createMobileUrl('list',array('op'=>'chalenotelike'));?>",
								data: {
									id: <?php  echo $id;?>
								},
								type: "get",
								success: function(result) {
									if (result == 1) {
										if (num == "0") {
											var htmls = '<div class="ih-bd__box ih-list__box"><ul class="ih-list">'
													+ '<li class="ih-list__item"><img src="<?php  echo $avatar;?>" alt=""></li></ul></div>';
											_self.parent().siblings(".ih-bd__box").remove();
										}

										for (var i = 0; i < srcAvatarNum; i++) {
											var srcAvatar = $srcAvatar.eq(i).attr("src");
											if (srcAvatar == _avatar) {
												$srcAvatar.eq(i).parent().remove();
											}
										}

										var html = '<div class="ih-function-praise__info js-goods_n"></div>';
										_self.parent().html(html);
										$(".js-dztext").html(parseInt(numDz) - 1);

										a();
									} else {
										console.log("取消点赞失败");
										b();
									}
								}
							})
						});
					}
				},
				handleClickfollow: function() {
					// 关注
					$(".js-gz").off("tap").on("tap", function() {
						$.ajax({
							url: "<?php  echo $this->createMobileUrl('list',array('op'=>'subsribemember'));?>",
							type: "post",
							data: {
								id: <?php  echo $authid;?>
							},
							success: function(result) {
								if (result == 1) {
									console.log("关注成功");
									var html = '<a href="javascript:;" class="ih-btn ih-btn__mini" style="background-color: #e96c68;color: #fff">已关注</a>';
									$(".ih-btn__box").html(html);
								} else {
									console.log("关注失败"+result);
								}
							}
						})
					})
				},
				handleClickcomment: function() {
					// 评论
					$(".ih-eidt").on("tap",".js-comment", function() {
						var eidtContent = $(this).parents(".ih-eidt").find("input[type=text]").val();
						var _num = "{count($commentlist)}";
						var $em = $(".ih-boxs__title .ih-em");
						var replyName = "";
						var replyContent = "";
						var replyReg = /^@[\u4e00-\u9fa5(0-9a-zA-Z)\S]+/;
						var _uid = $(this).parents(".ih-eidt").data("uid");
						console.log("回复:" + _uid);

						if (_uid) {
							// 匹配 各种字符
							replyName = replyReg.exec(eidtContent)[0];
						}
 
						if (replyName != null) {
							replyContent = eidtContent.substring(replyName.length, eidtContent.length);
						}

						console.log(replyName, replyContent);
						

						if ($.trim(eidtContent) == "") {
							ih.dialogAlert(null, "评论内容不能为空");

							return false;
						}

						if ( _num == "0") {
							$(".ih-box__comment").empty();
						}
						//防止重复点击
						$('.js-comment').attr('disabled', true);
$(".ih-eidt input[type=text]").val("");
						$.ajax({
							url: "<?php  echo $this->createMobileUrl('list',array('op'=>'addnotecomment'));?>",
							data: {
								id: <?php  echo $id;?>,
								uid: _uid,
								content: replyContent
							},
							success: function(result) {
								if (result == 1) {
									var html = '<div class="ih-box__item">'
											+ '<div class="ih-box__hd">'
											+ '<div class="ih-border__image">'
											+ '<img src="<?php  echo $avatar;?>" alt=""></div></div>'
											+ '<div class="ih-box__bd">'
											+ '<p class="ih-bd__title"><?php  echo $nickname;?></p>'
											+ '<p class="ih-bd__content"><span class="ih-man">'+ replyName +'</span>'+ replyContent +'</div>'
											+ '<div class="ih-box__ft"><div class="time">'
											+  new Date().format("MM-dd")  +'</div></div></div>';
									$(".ih-box__comment").prepend(html);
									$(".ih-eidt input[type=text]").val("");

									var plnum = $em.html();
									$em.html(parseInt(plnum)+1);

								} else {
									console.log(result);
								}
							}
						});
					});

					// 回复评论
					$(".ih-box__comment").off("tap",".ih-box__item").on("tap", ".ih-box__item", function() {
						var name = $(this).data("name");
						$(".ih-eidt input[type=text]").val("@"+name+" ");
						$(".ih-eidt").data("uid", $(this).data("uid"));
					});
				},
				handleClickcollection: function() {
					var ft = "<?php  echo $ifcollect?>";

					if (ft == "2") {
						a();
					}

					if (ft == "1") {
						b();
					}
					
					function a () {
						// 收藏
						$(".collection").on("tap",".js-collection_n" , function(e) {
							$(".collection").off("tap", ".js-collection_n");
							var _self = $(this);
							$.ajax({
								url: "<?php  echo $this->createMobileUrl('list',array('op'=>'addnotecollect'));?>",
								data: {
									id: <?php  echo $id;?>
								},
								type: 'post',
								success: function(result) {
									if (result == 1) {
										ih.dialogAlert(null, "收藏成功!", function () {
											var html = '<img class="js-collection_s" src="../addons/lwx_helloting/template/mobile/public/images/common_btn_collect_s.png" alt="">';
											
											_self.parent().html(html);
											b();
										});
									} else {
										ih.dialogAlert(null, "已经收藏，不可重复");
									}
								}
							})
						});
					}

					function b () {
						// 取消收藏
						$(".collection").on("tap", ".js-collection_s", function(e) {
							$(".collection").off("tap", ".js-collection_s");
							var _self = $(this);
							$.ajax({
								url: "<?php  echo $this->createMobileUrl('list',array('op'=>'chalenotecollect'));?>",
								data: {
									id: <?php  echo $id;?>
								},
								type: 'post',
								success: function(result) {
									if (result == 1) {
										ih.dialogAlert(null, "取消收藏成功!", function () {
											var html = '<img class="js-collection_n" src="../addons/lwx_helloting/template/mobile/public/images/common_btn_collect_n.png" alt="">';

											_self.parent().html(html);
											a();
										});
									} else {
										ih.dialogAlert(null, "取消收藏失败!");
									}
								}
							})
						});
					}
				},
				init: function() {
					var plcontent = "<?php  echo $comment['content']?>";



					this.handleClickgood();
					this.handleClickcomment();
					this.handleClickcollection();
					this.handleClickfollow();
				}

			};

			Main.init();
		})(Zepto);

        window.onload = function(){
            var aaa=$("#content").val();
            $('#content1').html(aaa);
        }

        function myRedirect(str){
			location.href=str;
		}
	</script>
<script>;</script><script type="text/javascript" src="http://h5.lwest.cn/we7/app/index.php?i=3&c=utility&a=visit&do=showjs&m=lwx_helloting"></script></body>
</html>
