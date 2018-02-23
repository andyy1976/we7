<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta name="full-screen" content="yes">
	<meta name="x5-fullscreen" content="true">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script src="../addons/lwx_helloting/template/mobile/public/new/js/zepto.min.js"></script>
	<script src="../addons/lwx_helloting/template/mobile/public/new/js/common.js"></script>
	<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/new/css/common.css">
	<title>HELLO★汀</title>
	<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/new/css/dropload.css">
	<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/new/css/index.css">
	<script src="../addons/lwx_helloting/template/mobile/public/new/js/dropload.min.js"></script>
</head>
<body class="iphonex">
<section class="box">
	<div class="scrolls">
		<div class="zhuti">
			<!--轮播-->
			<div class="swiper-container swiper1">
				<div class="swiper-wrapper">
					<?php  if(is_array($advlist)) { foreach($advlist as $adv) { ?>
					<div class="swiper-slide">
						<a href="<?php  echo $adv['link'];?>" style="display:block;width:100%;height:100%;">
							<img style="vertical-align: middle;width:100%;height:100%;" src="http://h5.lwest.cn/hellot_admin/thinkphp3/Public/uploads/<?php  echo $adv['thumb'];?>"/>
						</a>
					</div>
					<?php  } } ?>
					<div class="swiper-pagination"></div>
				</div>
			</div>
			<!--导航-->
			<nav class="one">
				<div class="box">
					<a class="two active"  data-id="1" href="#">汀荐</a>
					<a class="two active2"  data-id="2" href="#">汀图</a>
					<a class="two active3"  data-id="3" href="#">汀向标</a>
					<a class="two active4"  href="#">汀颜馆</a>
					<a class="two active5"  data-id="4" href="#">汀直播</a>
				</div>
			</nav>
			<!--/*********推荐-->

			<div class="content-box">
				<ul class="list list_one">
				</ul>

				<!--/*********PO图-->
				<ul class="list list_two" data-id="2">
				</ul>

				<!--/*********汀向标-->
				<ul class="list list_three" data-id="3">

				</ul>


				<!--/*********汀颜馆-->
				<ul class="list list_four" data-id="4">
					<?php  if(is_array($themelist)) { foreach($themelist as $theme) { ?>
					<li>
						<div class="img" style="background-image:url(http://h5.lwest.cn/hellot_admin/thinkphp3/Public/uploads/<?php  echo $theme['thumb'];?>)" data-id="$theme['id']">
							<a <?php  if($theme['havachid']==0) { ?>
							href="<?php  echo $this->createMobileUrl('feedback', array('op'=>'train_list','id'=>$theme['id'],'type'=>'pcate'));?>";
							<?php  } else { ?>
							href="<?php  echo $this->createMobileUrl('feedback', array('op'=>'train','id'=>$theme['id']));?> "
							<?php  } ?>">
							</a>
						</div>

						<div class="title"><?php  echo $theme['name'];?></div>
					</li>
					<?php  } } ?>
				</ul>



				<!--/*********汀直播-->
				<ul class="list list_five" data-id="5">
				</ul>
			</div>


		</div>
	</div>





	<footer>
		<div>
			<a href="<?php  echo $this->createMobileUrl('feedback');?>">
				<img src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_nav_btn_home_s.png" alt="">
				<span>首页</span>
			</a>
		</div>
		<div>
			<a href="<?php  echo $this->createMobileUrl('feedback', array('op'=>'message'));?>">
				<img src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_nav_btn_message_n.png" alt="">
				<span>消息</span>
			</a>
		</div>
		<div>
			<a href="<?php  echo $this->createMobileUrl('feedback', array('op'=>'publish'));?>">
				<img src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_nav_btn_release.png" alt="">
			</a>
		</div>
		<div>
			<a href="<?php  echo $this->createMobileUrl('feedback', array('op'=>'myTing'));?>">
				<img src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_nav_btn_form_n.png" alt="">
				<span>我★汀</span>
			</a>
		</div>
		<div>
			<a href="<?php  echo $this->createMobileUrl('feedback', array('op'=>'me'));?>">
				<img src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_nav_btn_me_n.png" alt="">
				<span>我</span>
			</a>
		</div>
	</footer>
</section>
<script>;</script><script type="text/javascript" src="http://h5.lwest.cn/we7/app/index.php?i=3&c=utility&a=visit&do=showjs&m=lwx_helloting"></script></body>
<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/new/css/swiper.min.css">
<script src="../addons/lwx_helloting/template/mobile/public/new/js/swiper.min.js"></script>
<script src="../addons/lwx_helloting/template/mobile/public/new/js/iscroll.js"></script>
</html>

<script>
    //滚动
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 1,
        loop: true,
        autoplay:true,
    });
    //nav 选中状态
    $(".two").forEach(function(value,index){
//        var type=index+1;
        $(value).on("touchend",function(){
            var type=$(value).attr("data-id");

            $(this).addClass("active");
            $(this).siblings().removeClass("active");
            $(".list").eq(index).show();
            $(".list").eq(index).siblings().hide();
            myScroll.refresh();
            var page=-1;
            if(type){
                // dropload
                $('.content-box').dropload({
                    scrollArea : window,
                    loadDownFn : function(me){
                        page++;
                        var box11=$("<ul>");
                        var box22=$("<ul>");
                        var box33=$("<ul>");
                        var box55=$("<ul>");
                        $.ajax({
                            type: 'post',
                            url:  "<?php  echo $this->createMobileUrl('feedback',array('op'=>'nextf5'));?>",
                            dataType: 'json',
                            data: {type:type, page: page},
                            success: function(data){
                                var arrLen = data.length;
                                if(arrLen > 0){
                                    console.log(type);
                                    /****************111111111111111111111111111111111111*/
                                    if(type==1){
                                        for (var i = 0; i < data.length; i++) {
                                            var box1 = $("<li>");
                                            var img = $(`<div class='img' style="background-image:url(${data[i].thumb})" data-id="${data[i].id}"></div>`);
                                            var a = $(`<a href="./index.php?i=3&c=entry&op=noteDetail&id=${data[i].id}&do=list&m=lwx_helloting"></a>`);
                                            if (data[i].ishot == 1) {
                                                a.html(`<img src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_icon_hot.png" alt="" class="hot">`);
                                            }
                                            if (data[i].isnew == 1) {
                                                a.html(`<img src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_icon_new.png" alt="" class="new">`)
                                            }
                                            var title = $(`<div class="title">${data[i].title}</div>`);

                                            var message=$(`<div class="message"></div>`);

                                            if(data[i].cateid==2){
                                                var ting=$(`<span>汀图</span><span>|</span>`);
                                            }else{
                                                var ting=$(`<span>汀向标</span><span>|</span>`);
                                            }
                                            if(data[i].nickname==""){
                                                var name=$(`<span>朗文斯汀</span></span><span class="mes_num">${data[i].commentno}</span><img class="mes" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/comment.png" alt=""><span class="good_num">${data[i].likeno}</span>`);
                                            }else{
                                                var name=$(`<span>${data[i].nickname}</span><span class="mes_num">${data[i].commentno}</span><img class="mes" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/comment.png" alt=""><span class="good_num">${data[i].likeno}</span>`);
                                            }
                                            if(data[i].iflike==1){
                                                var like=$(`<img class="good" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_btn_like_s.png" alt="">`);
                                            }else{
                                                var like=$(`<img class="good" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_btn_like_n.png" alt="">`);
                                            }
                                            img.append(a);
                                            box1.append(img);
                                            box1.append(title);
                                            message.append(ting);
                                            message.append(name);
                                            message.append(like);
                                            box1.append(message);
                                            box11.append(box1);
                                        }
									}
                                    /********************************2******************/
                                    if(type==2){
                                        console.log(arrLen);
                                        for (var i = 0; i < data.length; i++) {
                                            var box2 = $("<li>");
                                            if(data[i].thumb_url==null){
                                                var img = $(`<div class='img' style="background-image:url(../addons/lwx_helloting/template/mobile/public/images/common_icon_picture.png)" data-id="${data[i].id}"></div>`);
                                            }else{
                                                var img = $(`<div class='img' style="background-image:url(../attachment/${data[i].thumb_url[0]})" data-id="${data[i].id}"></div>`);
                                            }
                                            var a = $(`<a href="./index.php?i=3&c=entry&op=noteDetail&id=${data[i].id}&do=list&m=lwx_helloting"></a>`);
                                            if (data[i].ishot == 1) {
                                                a.html(`<img src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_icon_hot.png" alt="" class="hot">`);
                                            }
                                            if (data[i].isnew == 1) {
                                                a.html(`<img src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_icon_new.png" alt="" class="new">`)
                                            }

                                            var title = $(`<div class="title">${data[i].title}</div>`);

                                            var message=$(`<div class="message"></div>`);

                                            var ting=$(`<span>汀图</span><span>|</span>`);

                                            if(data[i].nickname==""){
                                                var name=$(`<span>朗文斯汀</span></span><span class="mes_num">${data[i].commentno}</span><img class="mes" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/comment.png" alt=""><span class="good_num">${data[i].likeno}</span>`);
                                            }else{
                                                var name=$(`<span>${data[i].nickname}</span><span class="mes_num">${data[i].commentno}</span><img class="mes" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/comment.png" alt=""><span class="good_num">${data[i].likeno}</span>`);
                                            }

                                            if(data[i].iflike==1){
                                                var like=$(`<img class="good" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_btn_like_s.png" alt="">`);
                                            }else{
                                                var like=$(`<img class="good" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_btn_like_n.png" alt="">`);
                                            }
                                            img.append(a);
                                            message.append(ting);
                                            message.append(name);
                                            message.append(like);
                                            box2.append(img);
                                            box2.append(title);
                                            box2.append(message);
                                            box22.append(box2);
                                            console.log(box22);
                                        }
									}
                                    /***********33333333333333333333333333333******************/
                                    if(type==3){
                                        console.log(data.length);
                                        for (var i = 0; i < data.length; i++) {
                                            var box3 = $("<li>");
                                            var img = $(`<div class='img' style="background-image:url(http://h5.lwest.cn/hellot_admin/thinkphp3/Public/uploads/${data[i].thumb})" data-id="${data[i].id}"></div>`);
                                            var a = $(`<a href="./index.php?i=3&c=entry&op=noteDetail&id=${data[i].id}&do=list&m=lwx_helloting"></a>`);
                                            if (data[i].ishot == 1) {
                                                a.html(`<img src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_icon_hot.png" alt="" class="hot">`);
                                            }
                                            if (data[i].isnew == 1) {
                                                a.html(`<img src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_icon_new.png" alt="" class="new">`)
                                            }
                                            var title = $(`<div class="title">${data[i].title}</div>`);

                                            var message=$(`<div class="message"></div>`);

                                            if(data[i].cateid==2){
                                                var ting=$(`<span>汀图</span><span>|</span>`);
                                            }else{
                                                var ting=$(`<span>汀向标</span><span>|</span>`);
                                            }
                                            if(data[i].nickname==""){
                                                var name=$(`<span>朗文斯汀</span></span><span class="mes_num">${data[i].commentno}</span><img class="mes" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/comment.png" alt=""><span class="good_num">${data[i].likeno}</span>`);
                                            }else{
                                                var name=$(`<span>${data[i].nickname}</span><span class="mes_num">${data[i].commentno}</span><img class="mes" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/comment.png" alt=""><span class="good_num">${data[i].likeno}</span>`);
                                            }
                                            if(data[i].iflike==1){
                                                var like=$(`<img class="good" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_btn_like_s.png" alt="">`);
                                            }else{
                                                var like=$(`<img class="good" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_btn_like_n.png" alt="">`);
                                            }
                                            img.append(a);
                                            box3.append(img);
                                            box3.append(title);
                                            message.append(ting);
                                            message.append(name);
                                            message.append(like);
                                            box3.append(message);
                                            box33.append(box3);
                                        }
                                    }
                                    /***********5555555555555555555555555555555******************/
                                    if(type==4){
                                        console.log(data.length);
                                        for (var i = 0; i < data.length; i++) {
                                            var box5 = $("<li>");
                                            var img = $(`<div class='img' style="background-image:url(http://h5.lwest.cn/hellot_admin/thinkphp3/Public/uploads/${data[i].thumb})" data-id="${data[i].id}"></div>`);
                                            var a = $(`<a href="./index.php?i=3&c=entry&op=noteDetail&id=${data[i].id}&do=list&m=lwx_helloting"></a>`);

                                            var title = $(`<div class="title">${data[i].title}</div>`);

                                            var message=$(`<div class="message"></div>`);

                                            var ting=$(`<span>品牌资讯</span><span>|</span>`);

                                            var name=$(`<span>朗文斯汀</span></span><span class="mes_num">${data[i].commentno}</span><img class="mes" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/comment.png" alt=""><span class="good_num">${data[i].likeno}</span>`);

                                            if(data[i].iflike==1){
                                                var like=$(`<img class="good" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_btn_like_s.png" alt="">`);
                                            }else{
                                                var like=$(`<img class="good" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_btn_like_n.png" alt="">`);
                                            }
                                            img.append(a);
                                            box5.append(img);
                                            box5.append(title);
                                            message.append(ting);
                                            message.append(name);
                                            message.append(like);
                                            box5.append(message);
                                            box55.append(box5);
                                            console.log(box5)
                                            console.log(box55)
                                        }
                                    }
                                    // 如果没有数据
                                }else{
                                    // 锁定
                                    me.lock();
                                    // 无数据
                                    me.noData();
                                }
                                setTimeout(function(){
                                    // 插入数据到页面，放到最后面
                                    if(type==1){
                                        $('.list_one').append(box11);
                                    }else if(type==2){
                                        $('.list_two').append(box22);
                                    }else if(type==3){
                                        $('.list_three').append(box33);
                                    }else if(type==4){
                                        $('.list_five').append(box55);
                                    }

                                    myScroll.refresh();
                                    // 每次数据插入，必须重置
                                    me.resetload();
                                },1000);

                            },
                            error: function(xhr, type){
//                                alert('Ajax error!');
                                // 即使加载出错，也得重置
                                me.resetload();
                            }
                        });
                    }
                });
			}

            myScroll.refresh();
        })
    })
    //滚动
    var myScroll = new IScroll('.scrolls', {
        mousewheel:true,
        click:true,
    });
	//点赞
	$(".list").delegate(".good","touchend",function(){
	    var id=$(this).parents("li").children(".img").attr("data-id");
	    var num=$(this).parents(".message").children(".good_num").html();
	    var that=$(this);
	    if(that.attr("src")=="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_btn_like_s.png"){
            $.ajax({
                url: "<?php  echo $this->createMobileUrl('list',array('op'=>'chalenotelike'));?>",
                data: {
                    id: id
                },
                type: "get",
                success: function(result) {
                    if (result == 1) {
                        var num_=parseInt(num) - 1;
                        that.parents(".message").children(".good_num").html(num_);
                        that.attr("src","http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_btn_like_n.png");
                    } else {
                        console.log("取消点赞失败");
                    }
                }
            })
		}else{
            $.ajax({
                url: "<?php  echo $this->createMobileUrl('list',array('op'=>'addnotelike'));?>",
                data: {
                    id: id
                },
                type: "get",
                success: function(result) {
                    if (result == 1) {
                        var num_=parseInt(num) + 1;
                        that.parents(".message").children(".good_num").html(num_);
                        that.attr("src","http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_btn_like_s.png");
                    } else {
                        console.log("点赞失败");
                    }
                }
            })
		}

	})
	//下拉刷新.html
	var page=-1;
    // dropload
    $('.content-box').dropload({
        scrollArea : window,
        loadDownFn : function(me){
            page++;
            var box=[];
            $.ajax({
                type: 'post',
                url:  "<?php  echo $this->createMobileUrl('feedback',array('op'=>'nextf5'));?>",
                dataType: 'json',
                data: {type:1, page: page},
                success: function(data){
                    console.log(data);
                    var arrLen = data.length;
                    var boxx=$("<ul>");
                    if(arrLen > 0){
						for (var i = 0; i < data.length; i++) {
							var box1 = $("<li>");
							var img = $(`<div class='img' style="background-image:url(${data[i].thumb})" data-id="${data[i].id}"></div>`);
							var a = $(`<a href="./index.php?i=3&c=entry&op=noteDetail&id=${data[i].id}&do=list&m=lwx_helloting"></a>`);
							if (data[i].ishot == 1) {
								a.html(`<img src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_icon_hot.png" alt="" class="hot">`);
							}
							if (data[i].isnew == 1) {
								a.html(`<img src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_icon_new.png" alt="" class="new">`)
							}
							var title = $(`<div class="title">${data[i].title}</div>`);

							var message=$(`<div class="message"></div>`);

							if(data[i].cateid==2){
								var ting=$(`<span>汀图</span><span>|</span>`);
							}else{
								var ting=$(`<span>汀向标</span><span>|</span>`);
							}
							if(data[i].nickname==""){
								var name=$(`<span>朗文斯汀</span></span><span class="mes_num">${data[i].commentno}</span><img class="mes" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/comment.png" alt=""><span class="good_num">${data[i].likeno}</span>`);
							}else{
								var name=$(`<span>${data[i].nickname}</span><span class="mes_num">${data[i].commentno}</span><img class="mes" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/comment.png" alt=""><span class="good_num">${data[i].likeno}</span>`);
							}
							if(data[i].iflike==1){
								var like=$(`<img class="good" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_btn_like_s.png" alt="">`);
							}else{
								var like=$(`<img class="good" src="http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/common_btn_like_n.png" alt="">`);
							}
							img.append(a);
							box1.append(img);
							box1.append(title);
							message.append(ting);
							message.append(name);
							message.append(like);
							box1.append(message);
							boxx.append(box1);
						}

                        // 如果没有数据
                    }else{
                        // 锁定
                        me.lock();
                        // 无数据
                        me.noData();
                    }
                    setTimeout(function(){
                        // 插入数据到页面，放到最后面
                        $('.list_one').append(boxx);
                        myScroll.refresh();
                        // 每次数据插入，必须重置
                        me.resetload();
                    },2000);
                },
                error: function(xhr, type){
                    alert('Ajax error!');
                    // 即使加载出错，也得重置
                    me.resetload();
                }
            });
        }
    });


</script>