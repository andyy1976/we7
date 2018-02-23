<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="">
    <style>
        body{
            background:#f5f5f5;
        }
        .box h1{
            width:80%;
            height:0.6rem;
            padding-left:0.3rem;
            margin-top:0.2rem;
            color:#000;
            font-size:0.34rem;
            font-weight:normal;
        }
        .box h2{
            width:80%;
            height:0.6rem;
            padding-left:0.3rem;
            margin-top:0.2rem;
            color:#ccc;
            font-size:0.26rem;
            font-weight:normal;
        }
        .list{
            width:100%;
            height:auto;
            overflow: hidden;
        }
        .list h2{
             width:95%;
             height:0.4rem;
             line-height:0.4rem;
             font-size:0.34rem;
             padding-left:0.3rem;
            font-weight:normal;
         }
        .list p{
            width:95%;
            height:auto;
            line-height:0.4rem;
            font-size:14px;
            padding-left:0.3rem;
            margin:0.2rem 0;
        }
        .list img{
            width:95%;
            margin:10px 2.5%;
        }
    </style>
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
    <link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/table_about.css">
    <title>HELLO★汀</title>
</head>
<body>
    <section class="box">
        <h1>HELLO★汀功能介绍</h1>
        <h2>朗文斯汀 2017-6-2</h2>
    </section>
    <section class="list">
        <div class="list_one">
            <h2>1、发布Po图</h2>
            <p>发布Po图可以分享您的服装搭配心得,销售心得,与其他分销商共同探讨,共同进步。</p>
            <img src="../addons/lwx_helloting/template/mobile/public/images/1.png" alt="">
        </div>
        <div class="list_one">
            <h2>2、我★汀反馈</h2>
            <p>我★汀的主要功能是反馈信息,希望广大的分销商为公司提供良好的建议,让公司了解到更多的客户需求。在反馈后不要忘了关注公司的回复哦~</p>
            <img src="../addons/lwx_helloting/template/mobile/public/images/2.png" alt="">
        </div>
        <div class="list_one">
            <h2>3、研究所</h2>
            <p>主打各类培训,为分销商们提供更多的有效信息。</p>
            <img src="../addons/lwx_helloting/template/mobile/public/images/3.png" alt="">
        </div>
        <div class="list_one">
            <h2>4、直播间</h2>
            <p>每季上新给类服装,可观看视频后在线下单,节约选货时间成本。</p>
            <img src="../addons/lwx_helloting/template/mobile/public/images/4.png" alt="">
        </div>
    </section>
<script>;</script><script type="text/javascript" src="http://h5.lwest.cn/we7/app/index.php?i=3&c=utility&a=visit&do=showjs&m=lwx_helloting"></script></body>
</html>
<script src="https://cdn.bootcss.com/zepto/1.2.0/zepto.min.js"></script>
<script>

</script>