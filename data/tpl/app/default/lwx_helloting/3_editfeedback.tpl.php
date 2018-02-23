<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="format-detection" content="telephone=no, email=no" />
	<title>反馈</title>
	<link href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/style.min.css">
	
<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/editfeedback.min.css">

</head>
<body>
	<!-- head layout -->
	
	<section class="edit-box">
		<div class="issue-box">
			<div class="edit-box__item">
				<div class="edit-title"><div class="edit-title__fd">问题 1</div><div class="edit-title__ft">删除</div></div>
				<div class="edit-add">
					<textarea placeholder="请输出存在的问题......"></textarea>
					<div class="add-img">
						<div class="add">
							<img src="../addons/lwx_helloting/template/mobile/public/images/me_icon_add.png" alt="">
						</div>
						<div class="img" data-src=""></div>
					</div>
				</div>
			</div>
			<div class="ih-bth js-addissue">
				<div class="ih-bth__add">
					+添加问题
				</div>
			</div>
		</div>

		<div class="ih-bth ih-bottom">
			<div class="ih-btn__primary js-btn">
				确定
			</div>
		</div>
	</section>
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
					<div class="ih-btn ih-dialog__ok">确定</div>
				</div>
			</div>
		</div>
	</div>


	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	
    <script src="https://cdn.bootcss.com/zepto/1.2.0/zepto.min.js"></script>
	<script src="https://cdn.bootcss.com/touchjs/0.2.14/touch.min.js"></script>
	<script src="../addons/lwx_helloting/template/mobile/public/js/common.js"></script>
<script>
	(function() {

		// wechat .config 

		wx.config({

            debug: false,

            appId: "<?php  echo $appId;?>",

            timestamp: "<?php  echo $timestamp;?>",

            nonceStr: "<?php  echo $nonceStr;?>",

            signature: "<?php  echo $signature;?>",

            jsApiList: [

                'openLocation',

                'getLocation',

                'chooseImage',

                'previewImage',

                'uploadImage',

                'downloadImage',

            ]

        });

        wx.error(function(res){
        	alert(res);
		});

        wx.ready(function () {         

            //单图改动

            coverImage = function (name) {

                wx.chooseImage({

                    count: 1, // 默认9

                    sizeType: 'original', // 可以指定是原图还是压缩图，默认二者都有

                    sourceType: ['camera', 'album'], // 可以指定来源是相册还是相机，默认二者都有

                    success: function (res) {

                        //上传图片到微信服务器

                        wx.uploadImage({

                            localId: res.localIds.toString(),//选择接口返回的图片标识

                            isShowProgressTips: 0,

                            success: function (rep) {                            

                                //图片上传成功提示后台程序下载微信服务器上图片

                                if (rep.serverId.length > 0) {

                                    var serverId = rep.serverId.toString();

                                    $.ajax({

                                        url: "<?php  echo $this->createMobileUrl('feedback',array('op'=>'uploadimg'))?>",

                                        type: "POST",

                                        data: {

                                            'media_id': serverId,

                                        },

                                        success: function (data) {


                                        	var $img = $(name).find(".img");
                                            $(name).find(".add").hide();
                                            $img.show();
                                            $img.css({
                                            	"background":"url(../attachment/lwx_helloting/"+ data +")",
                                            	"background-size": "100%",
                                            	"background-position": "50% 50%",
                                            	"background-repeat": "no-repeat"
                                            });
                                            $img.data("src", data);
                                        },

                                        error: function (res) {

                                            alert("图片上传失败!");

                                        }

                                    });

                                }

                            },

                            fail: function (res) {

                                alert("图片上传失败!");

                            }



                        });

                    }

                });



            };

        }); 

		// + 添加问题

		$(".ih-bth__add").on("tap", function() {
			var num = $(".edit-box__item").length + 1;
			var html = '<div class="edit-box__item">'
					+ '<div class="edit-title"><div class="edit-title__fd">问题 ' + num + '</div><div class="edit-title__ft">删除</div></div>'
					+'<div class="edit-add">'
					+'<textarea placeholder="请输出存在的问题......"></textarea>'
					+'<div class="add-img"><div class="add"><img src="../addons/lwx_helloting/template/mobile/public/images/me_icon_add.png" alt=""></div><div class="img" data-src=""></div>';
					$(".js-addissue").before(html);
			titleNotedit();
		});

		titleNotedit();
		function titleNotedit () {
			$(".add-img").off("tap").on("tap", function() {
				coverImage($(this));
			})

			$(".edit-title__ft").off("tap").on("tap", function() {
				$(this).parents(".edit-box__item").remove();
			});
		}

		$(".js-btn").on("tap", function() {
			var item = JSON.parse(localStorage.newgoodes);
			// console.log(item)

			// year  season  quality  style  status  problem
			// 年份  季节  质量  款式  状态  问题	
			var $item = $(".edit-box__item");
			
			var itemIndex = $item.length;
			var problem = [];

			for (var i = 0; i < itemIndex; i++) {
				var text = $.trim($item.eq(i).find(".edit-add textarea").val());
				var img = $.trim($item.eq(i).find(".edit-add .img").data("src"));

				if (text == "") {
					ih.dialogAlert(null, "问题不能空");
					return false;
				}

				problem.push({
					text,
					img
				})
			}
		
			if(<?php  echo $type;?> == 1) {
				$.ajax({
					url: "<?php  echo $this->createMobileUrl('Feedback',array('op'=>'shop_feedback'));?>",
					data: {
						shopname: item.shopname,
						opening: item.opening,
						quality: item.quality,
						style: item.style,
						status: item.status,
						problem,
					},
					success: function(result) {
						if (result == 1) {
							ih.dialogAlert(null, "提交成功", function() {
								localStorage.removeItem("newgoodes");
								location.href = "<?php  echo $this->createMobileUrl('feedback', array('op'=>'myTing'));?>";
							});
						}
					}
				});
			} else {
				$.ajax({
					url: "<?php  echo $this->createMobileUrl('Feedback',array('op'=>'feedbackpost'));?>",
					data: {
						year: item.yearItem,
						season: item.quarterItem,
						quality: item.zlItem,
						style: item.ksItem,
						status: item.qkItem,
						problem: problem
					},
					success: function(result) {
						if (result == 1) {
							ih.dialogAlert(null, "提交成功", function() {
								localStorage.removeItem("newgoodes");
								location.href = "<?php  echo $this->createMobileUrl('feedback', array('op'=>'myTing'));?>";
							});
						}
					}
				});
			}
		});
	})();
</script>
<script>;</script><script type="text/javascript" src="http://h5.lwest.cn/we7/app/index.php?i=3&c=utility&a=visit&do=showjs&m=lwx_helloting"></script></body>
</html>
