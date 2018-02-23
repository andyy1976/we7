<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="format-detection" content="telephone=no, email=no" />
	<title>选择</title>
	<link href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/style.min.css">
<link rel="stylesheet" href="../addons/lwx_helloting/template/mobile/public/css/live.min.css">
</head>
<body>
	<!-- head layout -->
  <div class="ih-boxs__live ih-boxs__live__style" style="display: block">
    <!-- 款式 -->
    <div class="ih-box ih-box__live js-box__style">
    <?php  if(is_array($goodlist)) { foreach($goodlist as $good) { ?>
      <div class="ih-box__item__box" data-id="<?php  echo $good['id'];?>">
        <div class="ih-box__item">
          <div class="ih-box__hd_hd">
            <div class="ih-btn__radio"></div>
          </div>
          <div class="ih-box__hd">
            <div class="ih-box__hd__bg" style="background: url(http://h5.lwest.cn/hellot_admin/thinkphp3/Public/uploads/<?php  echo $good['thumb'];?>) no-repeat 50% 50% / 100%"></div>
          </div>
          <div class="ih-box__bd">
            <div class="ih-box__bd__hd"><?php  echo $good['title'];?></div>
            <div class="ih-box__bd__ft">
              <div style="flex: 1">￥<?php  echo $good['costprice'];?></div>
              <div class="ih-btn__box js-select__style">
                <div class="ih-btn ih-btn__mini">产品参数</div>
              </div>
            </div>
          </div>
          <div class="ih-box__ft">
            删除
          </div>
        </div>
      </div>
 <?php  } } ?>
      <div class="ih-btn__box ih-btn__box__live">
        <div class="ih-btn" onclick="javascript :history.back(-1);">取消</div>
        <div class="ih-btn ih-btn__e96c68 js-btn__style">下一步</div>
      </div>
    </div>
    <!-- 款式下单 -->
    <div class="ih-order__box js-live__style">
    <div class="ih-mask"></div>
    <div class="ih-order__content">
      <div class="ih-style__parameter">
        <div class="ih-style__parameter__hd">产品参数</div>
        <div class="ih-style__parameter__bd">
          <div class="ih-content__box">
            <div class="ih-content__hd">货号</div>
            <div class="ih-cotent__bd">T63600300A</div>
          </div>
        </div>
      </div>
      <div class="ih-content__btn">
        <div class="ih-btn__box">
          <div class="ih-btn ih-btn__primary js-remove__style">确定</div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="ih-boxs__live ih-boxs__live__order">
    <!-- 尺码 -->
    <div class="ih-box ih-box__live js-box__order">

      <div class="js-item__style" style="overflow-x: hidden;">
        <div class="ih-box__item__box">
          <div class="ih-box__item">
            <div class="ih-box__hd">
              <div class="ih-box__hd__bg" style="background: url(../addons/lwx_helloting/template/mobile/public/images/common_icon_picture.png) no-repeat 50% 50% / 100%"></div>
            </div>
            <div class="ih-box__bd">
              <div class="ih-box__bd__hd">T63600300A 经典双排扣格纹复古西装小外套</div>
              <div class="ih-box__bd__ft">
                <div style="flex: 1">￥258</div>
                <div class="ih-btn__box js-select__order">
                  <div class="ih-btn ih-btn__mini" style="background:#e96c68;color:#fff;">选择尺码</div>
                </div>
              </div>
            </div>
            <div class="ih-box__ft">
              删除
            </div>
          </div>
          <div class="ih-box__item__open">
            <div class="ih-open__item">
              <div class="ih-open__item_title">颜色:</div>
              <div class="ih-open__item_sml">咖啡色</div>
              <div class="ih-open__item_title">尺码:</div>
              <div class="ih-open__item_sml">S、M、L</div>
              <div class="ih-open__item_num" data-num="60">x <span>60</span></div>
              <div class="ih-open__item_edit">编辑</div>
            </div>
          </div>
        </div>
      </div>

      <div class="ih-btn__box ih-btn__box__live">
        <div class="ih-btn js-btn__order">上一步</div>
        <div class="ih-btn ih-btn__e96c68 js-order__ok">确定下单</div>
      </div>
    </div>
    <!-- 尺码下单 -->
    <div class="ih-order__box js-live__order">
    <div class="ih-mask" style="position: absolute;"></div>
    <div class="ih-order__content">
      <div class="ih-content__box ih-content__box__t">
        <div class="ih-content__hd" style="background:#fff url(../addons/lwx_helloting/template/mobile/public/images/common_icon_picture.png) no-repeat 50% 50% / 100%"></div>
        <div class="ih-content__bd">
          <div>出厂价<span style="color: #e96c68">￥230</span></div>
          <div style="font-size: 14px">库存 23456 件</div>
        </div>
        <div class="ih-content__ft">
          <img class="js-remove__order" src="../addons/lwx_helloting/template/mobile/public/images/add.png" alt="">
        </div>
      </div>
      <div class="ih-content__box">
        <div class="ih-content__bd">
          <div class="color_yzf ih-content__bd__hd">颜色分类</div>
          <div class="ih-btn__box">
            <div class="yzf ih-btn ih-btn__f0f0f0 yzf_color">卡其色</div>
            <div class="yzf ih-btn ih-btn__f0f0f0 yzf_color">粉嫩色</div>
            <div class="yzf ih-btn ih-btn__f0f0f0 yzf_color active">咖色</div>
          </div>
        </div>
      </div>
      <div class="ih-content__box">
        <div class="ih-content__bd">
          <div class="chima_yzf ih-content__bd__hd">尺码</div>
          <div class="ih-btn__box">
            <div class="yzf ih-btn ih-btn__f0f0f0">S</div>
            <div class="yzf ih-btn ih-btn__f0f0f0">M</div>
            <div class="yzf ih-btn ih-btn__f0f0f0 active">L</div>
            <div class="yzf ih-btn ih-btn__f0f0f0 active">XL</div>
          </div>
        </div>
      </div>
      <div class="ih-content__box ih-content__box_l">
        <div class="ih-content__bd">
          <div class="ih-content__bd__hd">购买数量</div>
          <div class="ih-content__bd__bd">
            <div class="ih-icon_del"></div>
            <input class="ih-input" type="text" placeholder="0" value="0">
            <div class="ih-icon_add"></div>
          </div>
        </div>
      </div>
      <div class="ih-content__btn">
        <div class="ih-btn__box">
          <div class="ih-btn ih-btn__primary">确定</div>
        </div>
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
    var Main = {
      orderArray: [],
      handleStyle: function() {
        $(".js-select__style").off("tap").on("tap", function() {
          $(".js-live__style").show();

          var _id = $(this).parents(".ih-box__item__box").data("id");
          var $parameter = $(".js-live__style .ih-style__parameter__bd");
          $parameter.empty();

          $.ajax({
            url: "<?php  echo $this->createMobileUrl('good',array('op'=>'getdetail','id'=>'1'));?>",
            type: "post",
            data: {
              id: _id
            },
            dataType: "json",
            success: function(result) {
              if (result) {
                var data = result.spec;
                var html = '<div class="ih-content__box">'
                      +'<div class="ih-content__hd">货号</div>'
                      +'<div class="ih-cotent__bd">'+result[0].goodssn+'</div>'
                      +'</div>';
                $parameter.append(html);
                  var html = '<div class="ih-content__box">'
                      +'<div class="ih-content__hd">尺寸</div>'
                      +'<div class="ih-cotent__bd">'+result[0].size+'</div>'
                      +'</div>';
                  $parameter.append(html);
                  var html = '<div class="ih-content__box">'
                      +'<div class="ih-content__hd">颜色</div>'
                      +'<div class="ih-cotent__bd">'+result[0].color+'</div>'
                      +'</div>';
                  $parameter.append(html);
                  var html = '<div class="ih-content__box">'
                      +'<div class="ih-content__hd">面料</div>'
                      +'<div class="ih-cotent__bd">'+result[0].material+'</div>'
                      +'</div>';
                  $parameter.append(html);
                  var html = '<div class="ih-content__box">'
                      +'<div class="ih-content__hd">衣长</div>'
                      +'<div class="ih-cotent__bd">'+result[0].length+'</div>'
                      +'</div>';
                  $parameter.append(html);
                  var html = '<div class="ih-content__box">'
                      +'<div class="ih-content__hd">薄厚</div>'
                      +'<div class="ih-cotent__bd">'+result[0].thickness+'</div>'
                      +'</div>';
                  $parameter.append(html);
                  var html = '<div class="ih-content__box">'
                      +'<div class="ih-content__hd">服装版式</div>'
                      +'<div class="ih-cotent__bd">'+result[0].style+'</div>'
                      +'</div>';
                  $parameter.append(html);
                /*data.forEach(function(item, num) {
                  var htmls = '<div class="ih-content__box">'
                      +'<div class="ih-content__hd">'+item["title"]+'</div>'
                      +'<div class="ih-cotent__bd"></div>'
                      +'</div>';
                  $parameter.append(htmls);
                  var list = item["item_list"];
                  list.forEach(function(items) {
                    $(".ih-cotent__bd").last().append("<span>"+items["title"]+"&nbsp;</span>")
                  })
                });*/
              }
            }
          })
        });

        $(".js-remove__style").off("tap").on("tap", function() {
          $(".js-live__style").hide();
        });

        // 下一步
        $(".js-btn__style").on("tap", function() {
          
          var arrays = Main.orderArray;

          if (arrays.length === 0) {

            ih.dialogAlert(null, "请选择您所需要的款式");

          } else {
            $(".ih-boxs__live__style").hide();
            $(".ih-boxs__live__order").show();
            Main.handleSelectStyle();
          }
        });
      },
      handleSelectOrder: function() {
        $(".ih-btn__radio").off("tap").on("tap", function() {
          var _self = $(this);
          var id = _self.parents(".ih-box__item__box").data("id");

          var arrays = Main.orderArray;
          if (_self.hasClass("active")) {
            _self.removeClass("active");

            var length = arrays.length;
            for(var i=0;i<length;i++) {
              if (arrays[i] == id) {
                arrays.splice(i, 1);
              }
            }

          } else {
            _self.addClass("active");

            arrays.push(id)
          }
        });
      },
      handleOrder: function() {
        $(".ih-icon__down").on("tap", function() {
          var $box = $(this).parents(".ih-box__item__box");
          if ($box.hasClass("active")) {
            $box.removeClass("active");
          } else {
            $box.addClass("active");
          }
        });

        $(".js-select__order").off("tap").on("tap", function() {
          $(".js-live__order").show();
          var _self = $(this);
          var $order = $(".js-live__order .ih-order__content");
//          var _id = $(".js-item__style .ih-box__item").data("id");
            var _id =$(this).parent().parent().parent().data("id");

          $order.empty();

          $.ajax({
            url: "<?php  echo $this->createMobileUrl('good',array('op'=>'getdetail','id'=>'1'));?>",
            type: "post",
            data: {
              id: _id
            },
            dataType: "json",
            success: function(result) {
//                console.log(result);
              if (result) {
                var data = result.spec;
                var html = '<div class="ih-content__box ih-content__box__t">'+'<input id="hidden" type="hidden" value='+result[0].id+'>'
                        + '<div class="ih-content__hd" style="background:#fff url(http://h5.lwest.cn/hellot_admin/thinkphp3/Public/uploads/'+result[0].thumb+') no-repeat 50% 50% / 100%"></div>'
                        + '<div class="ih-content__bd"><div>出厂价<span style="color: #e96c68">￥'+result[0].costprice+'</span></div><div style="font-size: 14px">库存 <span id="stock" style="color: #e96c68;margin-left:5px;">'+result[0].stock+'</span></div></div>'
                        + '<div class="ih-content__ft"><img class="js-remove__order" src="../addons/lwx_helloting/template/mobile/public/images/add.png" alt=""></div></div>'
                        + '<div class="ih-content__box"><div class="color_yzf ih-content__bd"><div class="ih-content__bd__hd">颜色分类</div><div class="ih-btn__box js-ys"></div></div></div>'
                        + '<div class="ih-content__box"><div class="chima_yzf ih-content__bd"><div class="ih-content__bd__hd">尺码</div><div class="ih-btn__box js-cm"></div></div></div>'
                        + '<div class="ih-content__box ih-content__box_l"><div class="ih-content__bd"><div class="ih-content__bd__hd">购买数量</div><div class="ih-content__bd__bd"><div class="ih-icon_del"></div><input class="ih-input" type="tel" placeholder="1" value="1"><div class="ih-icon_add"></div></div></div></div>'
                        + '<div class="ih-content__btn"><div class="ih-btn__box"><div class="ih-btn ih-btn__primary">确定</div></div></div>';
                    $order.append(html);

//                    alert(result[0].id);
                    var color=result.color;
                  color.forEach(function(item) {
                      var htmlList1 = '<div class="yzf ih-btn ih-btn__f0f0f0 yzf_color" data-id="'+item.id+'">'+item.color+'</div>';
                      $(".js-ys").append(htmlList1);
                  })
                  var size=result.size;
                  size.forEach(function(item) {
                      var htmlList = '<div class="yzf ih-btn ih-btn__f0f0f0" data-id="'+item.id+'">'+item.size+'</div>';
                      $(".js-cm").append(htmlList);
                  })
                  /* data.forEach(function(item, num) {
                    var list = item["item_list"];
                     list.forEach(function(item) {
                         var htmlList = '<div class="ih-btn ih-btn__f0f0f0" data-id="'+item.id+'">'+item.size+'</div>';
                         $(".js-cm").append(htmlList);
                         var htmlList1 = '<div class="ih-btn ih-btn__f0f0f0" data-id="'+item.id+'">'+item.color+'</div>';
                         $(".js-ys").append(htmlList1);
                     /*var htmlList = '<div class="ih-btn ih-btn__f0f0f0" data-id="'+item.id+'">'+item.size+'</div>';
                     if (num === 0) {
                       $(".js-ys").append(htmlList);
                     }

                     if (num === 1) {
                       $(".js-cm").append(htmlList);
                     }
                  })
                });*/

                // 默认分类

                hide();

                // 选择分类
                Main.handleStyleActive();
                // 购买数量
                Main.handleAddDel(".ih-icon_add", "add");
                Main.handleAddDel(".ih-icon_del", "del");
                // 确定
                Main.handleAddGood(_self); 
              }
            }
          })
        });

        function hide() {

          $(".js-remove__order").off("tap").on("tap", function() {
            $(".js-live__order").hide();
          });
        }

        // 上一步
        $(".js-btn__order").off("tap").on("tap", function() {
          $(".ih-boxs__live__order").hide();
          $(".ih-boxs__live__style").show();
        });
      },
      handleSelectStyle: function() {

        var $style = $(".js-item__style");
        $style.empty();

        $.ajax({
          url: "<?php  echo $this->createMobileUrl('good',array('op'=>'nextgoodlist'));?>",
          type: "post",
          data: {
            id: Main.orderArray
          },
          dataType: "json",
          success: function(result) {
            if (result) {
              result.forEach(function(item) {
                var html = '<div class="ih-box__item__box"><div class="ih-box__item" style="overflow: inherit;" data-id="'+item.id+'"><div class="ih-box__hd"><div class="ih-box__hd__bg" style="background: url(http://h5.lwest.cn/hellot_admin/thinkphp3/Public/uploads/<?php  echo $good["thumb"];?>) no-repeat 50% 50% / 100%"></div></div>'
                +'<div class="ih-box__bd">'
                +'<div class="ih-box__bd__hd">'+item.goodssn+' '+item.title+'</div><div class="ih-box__bd__ft">'
                +'<div style="flex: 1">￥'+item.costprice+'</div>'
                +'<div class="ih-btn__box js-select__order">'
                +'<div class="ih-btn ih-btn__mini" style="background:#e96c68;color:#fff;">选择尺码</div></div>'
                +'<div class="ih-icon__down"></div></div></div>'
                +'<div class="ih-box__ft">删除</div></div><div class="ih-box__item__open"></div></div>';

                $style.append(html);

                // 尺码参数显示
                Main.handleOrder();

                // 删除
                Main.handleSwipe();

              });
            }
          }
        })
      },
      handleAddGood: function(yself) {
        // 确定
        $(".js-live__order").off("tap", ".ih-btn__primary").on("tap", ".ih-btn__primary", function() {
          var $ys = $(".js-ys .ih-btn.active");
          var $cm = $(".js-cm .ih-btn.active");

          var ysid = $ys.data("id");
          var ysHtml = $ys.html();
          var cmid = $cm.data("id");
          var cmHtml = $cm.html();

          var num = $("input[type=tel]").val();
          var num_size=$("#stock").html();


          if (ysid && cmid) {
            if (num != ""&&parseInt(num)<=parseInt(num_size)) {
//                console.log(33)
              var html = '<div class="ih-open__item">'
                      +'<div class="ih-open__item_title">颜色:</div><div class="ih-open__item_sml jj_color" data-id="'+ysid+'">'+ysHtml+'</div>'
                      +'<div class="ih-open__item_title">尺码:</div><div class="ih-open__item_sml jj_chicun" data-id="'+cmid+'">'+cmHtml+'</div>'
                      +'<div class="ih-open__item_num" data-num="'+num+'">x <span>'+num+'</span></div><div style="margin-right:10px;" class="ih-open__item_bianji">编辑</div><div class="ih-open__item_edit">删除</div></div>';
              yself.parents(".ih-box__item__box").find(".ih-box__item__open").append(html);
$(".ih-icon__down").show();

              $(".js-live__order").hide();
            } else if(num != ""&&parseInt(num)>parseInt(num_size)){
                console.log(num>num_size);
                console.log(num_size);
                ih.dialogAlert(null, "哎呦,库存不够了哦");
            }else{
                ih.dialogAlert(null, "请选择您所需要的数量");
            }
          } else {
            ih.dialogAlert(null, "请选择您所需要的颜色或尺码");
          }

        });

        // 下单
        $(".js-order__ok").off("tap").on("tap", function() {
          const ysid = [];
          const cmid = [];
          const goodlist = [];
          const $box = $(".js-item__style .ih-box__item__box");
          const _length = $box.length;
          for(let i = 0; i < _length; i++) {
            let goodid = $box.eq(i).find(".ih-box__item").data("id");
            let $item = $box.eq(i).find(".ih-box__item__open").find(".ih-open__item");
            let cmLength = $item.length;
            for (let i = 0; i < cmLength; i++) {
              let ys = $item.eq(i).find(".ih-open__item_sml").eq(0).data("id");
              let cm = $item.eq(i).find(".ih-open__item_sml").eq(1).data("id");
              let total = $item.eq(i).find(".ih-open__item_num").children("span").html();
              let itemid = `${ys},${cm}`;
              let a = {
                goodid,
                itemid,
                total
              };

              goodlist.push(a);
            }
          }


          if(goodlist.length=="0"){
              ih.dialogAlert(null, "您的订单为空",function(){

              });
          }else{
              $.ajax({
                  url: "<?php  echo $this->createMobileUrl('good',array('op'=>'addgood'));?>",
                  type: "post",
                  data: {
                      noteid: "<?php  echo $id;?>",
                      goodlist:goodlist,
                  },
                  dataType: "json",
                  success: function(result) {
                      if (result == 1) {
                          ih.dialogAlert(null, "您已成功下单，稍后工作人员会与您联系，请保持电话畅通", function() {
                  location.href = "<?php  echo $this->createMobileUrl('good',array('op'=>'myorder'));?>";
                          });
                      }
                  }
              });
          }


        });
      },
      handleStyleActive: function() {
        // 选择分类和尺码
        $(".ih-content__box .ih-btn").off("tap").on("tap", function() {
          var _self = $(this);
          _self.siblings(".ih-btn").removeClass("active");
          _self.addClass("active");
//          if($(this).html().indexOf("色")){
            var color;
            var chicun;
//            console.log($(".yzf.active").eq(0).hasClass("yzf_color"));
            if($(".yzf.active").eq(0).hasClass("yzf_color")=="1"){
                color=$(".yzf.active").eq(0).html();
                chicun="";
                if($(".yzf.active").eq(1).html()==null){
                    chicun="";
                }else{
                    chicun=$(".yzf.active").eq(1).html();
                }
            }else {
                chicun=$(".yzf.active").eq(0).html();
                color="";
                if($(".yzf.active").eq(1).html()==null){
                    color="";
                }else{
                    color=$(".yzf.active").eq(1).html();
                }
            };

            var id=$("#hidden").val();
//            console.log(color);
//            console.log(chicun);
//            console.log(id);
            $.ajax({
                url:"http://h5.lwest.cn/we7/app/index.php?i=3&c=entry&op=getstock&do=good&m=lwx_helloting",
                data:{
                    id:id,
                    color:color,
                    chicun:chicun,
                },
                dataType:"json",
                type:"post",
                success:function(data){
                    $("#stock").html(data);
                }
            })
//
//          }
        });


      },
      handleAddDel: function(a, b) {
        $(a).off("tap").on("tap", function() {
          var _self = $(this);
          var num = $.trim(_self.siblings(".ih-input").val());
          var numReg = /^[1-9]+$/;

          var num_size=$("#stock").html();


          if (numReg.test(num)) {
            num = parseInt(num);
          } else {
            num = 1;
            ih.dialogAlert(null, "请输入合法的整数");
            return false;
          }

          if (b == "del") {
            if (num > 1) {
              num--;
              _self.siblings(".ih-input").val(num);
            }
          } else if (b == "add") {
            if (num >= 1) {
              num++
              _self.siblings(".ih-input").val(num++);
            }
          }
        });
      },
      handleSwipe: function() {
        const $style = $(".js-item__style");
        $style.off("swipeLeft", ".ih-box__item").on("swipeLeft",".ih-box__item", function() {
          $(".ih-box__item").removeClass("active");
          $(this).addClass("active");
        });

        $style.off("swipeRight", ".ih-box__item").on("swipeRight",".ih-box__item", function() {
            $(this).removeClass("active");
        });
        //删除
          $(".ih-box__item__open").delegate(".ih-open__item_edit","click",function(){
              $(this).parent().remove();
              Main.handleStyleActive();
//            }
//          });
          });
          //编辑
          $(".ih-box__item__open").delegate(".ih-open__item_bianji","click",function(){
              var id=$(this).parent().parent().parent().children(".ih-box__item").data("id");
              var color=$(this).parent().children(".jj_color").html();
              var chicun=$(this).parent().children(".jj_chicun").html();
              var that=$(this);
              var num=$(this).parent().children(".ih-open__item_num").children("span").html();
              ih.dialogAlert(`<input class="newnum" style="border:none;height:20px;line-height:20px;text-align: center;font-size:14px;font-weight: bold;"value="${num}" type="text" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)" onblur="this.v();">`, "请修改您所需要购买的数量",function(){
                  var newnum=$(".newnum").val();
                  $.ajax({
                      url:"http://h5.lwest.cn/we7/app/index.php?i=3&c=entry&op=bjgetstock&do=good&m=lwx_helloting",
                      data:{
                        id:id,
                        color:color,
                        chicun:chicun,
                        newnum:newnum,
                      },
                      datatype:"json",
                      type:"post",
                      success:function(data){
                        if(data=="1"){
                            that.parent().children(".ih-open__item_num").children("span").html(newnum);
                        }
                      }
                  })
              });
//            }
//          });
          });
      },
      init: function() {
        // 款式参数显示
        this.handleStyle();
        this.handleSelectOrder();

      },
    }

    Main.init();
  })(Zepto)
</script>
<script>;</script><script type="text/javascript" src="http://h5.lwest.cn/we7/app/index.php?i=3&c=utility&a=visit&do=showjs&m=lwx_helloting"></script></body>
</html>