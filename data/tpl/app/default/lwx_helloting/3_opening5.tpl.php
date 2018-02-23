<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>店铺设计与道具满意度</title>
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
            win.addEventListener(resizeEvt, recalc, false);recalc();
            doc.addEventListener('DOMContentLoaded', recalc, false);
        })(document, window);
    </script>
    <link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/LCalendar.css">
    <link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/opening1.css">
</head>
<body>
    <h1>基础信息</h1>
    <label>
        <span>店铺名称</span>
        <input id="shopname" type="text" placeholder="请输入店铺名称">
    </label>
    <label>
        <span>店铺面积</span>
        <input id="area" type="text" placeholder="请输入店铺面积">
    </label>
    <label>
        <span>区域经理</span>
        <input id="manager" type="text" placeholder="请输入区域经理名字">
    </label>
    <label>
        <span>空间设计师</span>
        <input id="designer" type="text" placeholder="请输入空间设计师名字">
    </label>
    <button class="button">下一步</button>
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script>
        $(".button").on("touchend",function(){
            var shopname=$("#shopname").val();
            var area=$("#area").val();
            var manager=$("#manager").val();
            var designer=$("#designer").val();
            if(shopname==""||area==""||manager==""||designer==""){
                $(this).attr("disabled",true);
                alert("请完善信息");
                return;
            }

            var a1=[];
            a1=[shopname,area,manager,designer];
            sessionStorage.a1=a1;
            window.location.href="http://h5.lwest.cn/we7/app/index.php?i=3&c=entry&op=opening6&do=feedback&m=lwx_helloting";
        })
    </script>
<script>;</script><script type="text/javascript" src="http://h5.lwest.cn/we7/app/index.php?i=3&c=utility&a=visit&do=showjs&m=lwx_helloting"></script></body>
</html>
