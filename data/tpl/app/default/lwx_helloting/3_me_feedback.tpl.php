<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
	<meta name="format-detection" content="telephone=no, email=no"/>
	<title>我的反馈</title>
	<link href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/style.min.css">
	<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/me.min.css">
</head>
<body>

<input type="hidden" value="" id="inputone">
<input type="hidden" value="" id="inputtwo">

<div class="ih-box">
	<div class="ih-nav__screen">
		<div class="ih-dropdown js-type">
			<div class="ih-dropdown__text" data-item="0">全部</div>
			<div class="ih-dropdown__list">
				<ul class="ih-dropdown__menu" id="one">
					<li class="ih-dropdown__item"  data-item="0">全部</li>
					<li class="ih-dropdown__item"  data-item="1">新货反馈表</li>
					<li class="ih-dropdown__item"  data-item="2">开业满意度评分表</li>
					<li class="ih-dropdown__item"  data-item="3">店铺设计及道具满意度评分表</li>
					<li class="ih-dropdown__item"  data-item="4">质量反馈表</li>
				</ul>
			</div>
		</div>

		<div class="ih-dropdown ih-dropdown__ft js-type_time">
			<div class="ih-dropdown__text" data-item="0">默认排序</div>
			<div class="ih-dropdown__list">
				<ul class="ih-dropdown__menu" id="two">
					<li class="ih-dropdown__item" data-item="0">默认排序</li>
					<li class="ih-dropdown__item" data-item="1">最近回复</li>
					<li class="ih-dropdown__item" data-item="2">最近一月</li>
					<li class="ih-dropdown__item" data-item="3">最近三月</li>
					<li class="ih-dropdown__item" data-item="4">最近半年</li>
				</ul>
			</div>
		</div>
	</div>

	<div class="ih-box ih-box__other">
	</div>
</div>

<script src="https://cdn.bootcss.com/zepto/1.2.0/zepto.min.js"></script>
<script src="https://cdn.bootcss.com/touchjs/0.2.14/touch.min.js"></script>
<script src="../addons/lwx_helloting/template/mobile/public/js/common.js"></script>
<script>
	var aa;
    function typeone(){
        $("#one").delegate("#one .ih-dropdown__item","click",function(){
            $('#inputone').val($(this).attr("data-item"));
        })
    }
    function typetwo(){
        $("#two").delegate("#two .ih-dropdown__item","click",function(){
            $('#inputtwo').val($(this).attr("data-item"));
        })
    }
	typeone();
	typetwo();



    ;(function($) {
        var Main = {
            _ajaxList: function(a) {
                var _typeName = "";
                var ifreplyHtml = "";
                var problem = "";

                $.ajax({
                    url: "<?php  echo $this->createMobileUrl('person',array('op'=>'myfeedback'));?>",
                    data: {
                        type:$("#inputone").val(),
                        time:$("#inputtwo").val(),
                    },
                    type:"post",
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        $(".ih-box__other").empty();

                        var data = result.list;
                        data.forEach(function(item, num) {
                            var problem = item.problem;

                            switch (item.type) {
                                case 1:
                                    _typeName = "新货反馈表";
                                    if (!!problem) {
                                        problem = item.problem[0].text;
                                    } else {
                                        problem = "";
                                    }
                                    var season = "春";
                                    if (item.season == 1) {
                                        season = "春";
                                    } else if (item.season == 2) {
                                        season = "夏";
                                    } else if (item.season == 3) {
                                        season = "秋";
                                    } else if (item.season == 4) {
                                        season = "冬";
                                    }

                                    problem = "<div>年份:"+item.year+"年;季度:"+season+"</div>"
                                        + "<div>服装质量:"+item.quality+"分;季度款式:"+item.style+"分;销售情况:"+item.status+"分;</div>"
                                        + "<div>" + problem + "</div>";
                                    break;
                                case 2:
                                    _typeName = "开业满意度评分表";
                                    problem = "<div>店铺名称:"+item.shopname+";开业时间:"+item.opentime+"</div>"
                                        +"<div>促销活动:"+item.cuxiaoscore+"分;货品情况:"+item.hpqkscore+"分;督导区域经理现场表现:"+item.jlbxscore+"分;</div>";
                                    break;
                                case 3:
                                    _typeName = "店铺设计及道具满意度评分表";
                                    if (!!problem) {
                                        problem = item.problem[0].text;
                                    } else {
                                        problem = "";
                                    }
                                    problem = "<div>店铺名称:"+item.shopname+";开业时间:"+item.opentime+"</div>"
                                        +"<div>店铺动线布局:"+item.dxbj+"分;效果图:"+item.xgt+"分;设计师服务满意度:"+item.sjsfw+"分;</div>"
                                        + "<div>" + problem + "</div>";
                                    break;
                                case 4:
                                    _typeName = "质量反馈";
                                    if (!!problem) {
                                        problem = item.problem[0].text;
                                    } else {
                                        problem = "";
                                    }
                                    problem = "<div>" + problem + "</div>";
                                    break;
                            }

                            if(item.ifnewreply == 2) {
                                // 没有回复
                                ifreplyHtml = '<div class="ih-box__ft__def" style="display:flex;"><img src="../addons/lwx_helloting/template/mobile/public/images/common_icon_message01.png" alt="">暂无回复</div>';
                            } else {
                                // 有回复
                                ifreplyHtml = '<div class="ih-box__ft__active" style="display:flex;"><img src="../addons/lwx_helloting/template/mobile/public/images/common_icon_message02.png" alt="">有新的回复咯~</div>';
                            }

                            var html = '<div class="ih-box__item ih-href" data-href="<?php  echo $this->createMobileUrl("person",array ("op"=>"feedbackDetail"));?>&id='+item.id+'&type='+item.type+'">'
                                + '<div class="ih-box__hd">'
                                + '<div class="ih-hd__title">'+ _typeName +'</div>'
                                + '<div class="ih-hd__time">'+ item.createtime +'</div></div>'
                                + '<div class="ih-box__bd">'+ problem +'</div><div class="ih-box__ft">'
                                + ifreplyHtml
                                + '</div></div>';
                            $(".ih-box__other").append(html);

                        });

//						ih.handleHref();
                    }
                })
            },
            init: function() {
                this._ajaxList({
                    type: 0,
                    time: 0
                });

                ih.handleDropdown(function() {
                    var _type = typeone();
                    var _typeTime = typetwo();

                    Main._ajaxList({
                        type:$("#inputone").val(),
                        time:$("#inputtwo").val(),
                    });
                });
            }
        };
//        $(".js-type").bind('DOMNodeInserted', function(e) {
        Main.init();
//        })
    })(Zepto)

    $(".js-type").bind('DOMNodeInserted', function(e) {




        ;(function($) {

            var Main = {
                init: function() {
                    this._ajaxList({
//                        type: $(".js-type .ih-dropdown__text").data("item"),
                        type:$("#inputone").val(),
                        time:$("#inputtwo").val(),
                    });

//                    ih.handleDropdown(function() {
//                        var _type = $(".js-type .ih-dropdown__text").data("item");
//                        var _typeTime = $(".js-type_time .ih-dropdown__text").data("item");

//                        Main._ajaxList({
//                            type: _type,
//                            time: _typeTime
//                        });
//                    });
                },
                _ajaxList: function(a) {
                    var _typeName = "";
                    var ifreplyHtml = "";
                    var problem = "";

                    $.ajax({
                        url: "<?php  echo $this->createMobileUrl('person',array('op'=>'myfeedback'));?>",
                        data: {
                            type:$("#inputone").val(),
                            time:$("#inputtwo").val(),
                        },
                        type:"post",
                        dataType: "json",
                        success: function(result) {
                            $(".ih-box__other").empty();
                            var data = result.list;
                            console.log(data);
                            data.forEach(function(item, num) {
                                var problem = item.problem;
                                console.log(item.type)
                                switch (item.type) {
                                    case 1:
                                        _typeName = "新货反馈表";
                                        if (!!problem) {
                                            problem = item.problem[0].text;
                                        } else {
                                            problem = "";
                                        }
                                        var season = "春";
                                        if (item.season == 1) {
                                            season = "春";
                                        } else if (item.season == 2) {
                                            season = "夏";
                                        } else if (item.season == 3) {
                                            season = "秋";
                                        } else if (item.season == 4) {
                                            season = "冬";
                                        }

                                        problem = "<div>年份:"+item.year+"年;季度:"+season+"</div>"
                                            + "<div>服装质量:"+item.quality+"分;季度款式:"+item.style+"分;销售情况:"+item.status+"分;</div>"
                                            + "<div>" + problem + "</div>";
                                        break;
                                    case 2:

                                        _typeName = "开业满意度评分表";
                                        problem = "<div>促销活动:"+item.shopname+";货品情况:"+item.opentime+"</div>"
                                            +"<div>督导区域经理现场表现:"+item.quality+"分;季度款式:"+item.style+"分;销售情况:"+item.status+"分;</div>";
                                        break;
                                    case 3:

                                        _typeName = "店铺设计及道具满意度评分表";
                                        if (!!problem) {
                                            problem = item.problem[0].text;
                                        } else {
                                            problem = "";
                                        }
                                        problem = "<div>店铺名称:"+item.shopname+";开业时间:"+item.opentime+"</div>"
                                            +"<div>店铺动线布局:"+item.quality+"分;效果图:"+item.style+"分;设计师服务满意度:"+item.status+"分;</div>"
                                            + "<div>" + problem + "</div>";
                                        break;
                                    case 4:
                                        _typeName = "质量反馈";
                                        if (!!problem) {
                                            problem = item.problem[0].text;
                                        } else {
                                            problem = "";
                                        }
                                        problem = "<div>" + problem + "</div>";
                                        break;
                                }

                                if(item.ifnewreply == 2) {
                                    // 没有回复
                                    ifreplyHtml = '<div class="ih-box__ft__def" style="display:flex;"><img src="../addons/lwx_helloting/template/mobile/public/images/common_icon_message01.png" alt="">暂无回复</div>';
                                } else {
                                    // 有回复
                                    ifreplyHtml = '<div class="ih-box__ft__active" style="display:flex;"><img src="../addons/lwx_helloting/template/mobile/public/images/common_icon_message02.png" alt="">有新的回复咯~</div>';
                                }

                                var html = '<div class="ih-box__item ih-href" data-href="<?php  echo $this->createMobileUrl("person",array ("op"=>"feedbackDetail"));?>&id='+item.id+'&type='+item.type+'">'
                                    + '<div class="ih-box__hd">'
                                    + '<div class="ih-hd__title">'+ _typeName +'</div>'
                                    + '<div class="ih-hd__time">'+ item.createtime +'</div></div>'
                                    + '<div class="ih-box__bd">'+ problem +'</div><div class="ih-box__ft">'
                                    + ifreplyHtml
                                    + '</div></div>';
                                $(".ih-box__other").append(html);

                            });

//                            ih.handleHref();
                        }
                    })
                },
            };
            Main.init();
        })(Zepto)
//    })
    })


	$(".ih-box").delegate(".ih-href","click",function(){
	    location.href=$(this).attr("data-href");
	})
</script>
<script>;</script><script type="text/javascript" src="http://h5.lwest.cn/we7/app/index.php?i=3&c=utility&a=visit&do=showjs&m=lwx_helloting"></script></body>
</html>
