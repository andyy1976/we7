<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>开业满意度评分表</title>
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
            recalc();
            win.addEventListener(resizeEvt, recalc, false);
            doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);
    </script>
    <link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/LCalendar.css">
    <link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/opening1.css">
</head>
<body>
    <h1>基础信息1/4</h1>
    <label>
        <span>店铺名称</span>
        <input id="shopname" type="text" placeholder="请输入店铺名称">
    </label>
    <label>
        <span>负责人</span>
        <input id="fuzename" type="text" placeholder="请输入负责人名字">
    </label>
    <label>
        <span>店长</span>
        <input id="dzname" type="text" placeholder="请输入区店长名字">
    </label>
    <label>
        <span>店铺电话</span>
        <input id="shopphone" type="text" placeholder="请输入店铺电话">
    </label>
    <label>
        <span>开业时间</span>
        <input id="opentime" readonly="" name="input_date" type="text" placeholder="请输入日期" data-lcalendar="2000-01-01,2018-01-29">

    </label>
    <button class="button">下一步</button>
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="../addons/lwx_helloting/template/mobile/public/js/LCalendar.js"></script>
    <script>
        var calendar = new LCalendar();
        calendar.init({
            'trigger': '#opentime', //标签id
            'type': 'date', //date 调出日期选择 datetime 调出日期时间选择 time 调出时间选择 ym 调出年月选择,
            'minDate': '1900-1-1', //最小日期
            'maxDate': new Date().getFullYear() + '-' + (new Date().getMonth() + 1) + '-' + new Date().getDate() //最大日期
        });

        $(".button").on("touchend",function(){
            var shopname=$("#shopname").val();
            var fuzename=$("#fuzename").val();
            var dzname=$("#dzname").val();
            var shopphone=$("#shopphone").val();
            var opentime=$("#opentime").val();
            if(shopname==""||fuzename==""||dzname==""||shopphone==""||opentime==""){
           $(this).attr("disabled",true);
           alert("请完善信息");
           return;
            }
            var a=[];
            a=[shopname,fuzename,dzname,shopphone,opentime];
            sessionStorage.a=a;
            window.location.href="http://h5.lwest.cn/we7/app/index.php?i=3&c=entry&op=opening2&do=feedback&m=lwx_helloting";
        })
    </script>
<script>;</script><script type="text/javascript" src="http://h5.lwest.cn/we7/app/index.php?i=3&c=utility&a=visit&do=showjs&m=lwx_helloting"></script></body>
</html>
