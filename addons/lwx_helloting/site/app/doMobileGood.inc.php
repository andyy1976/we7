<?php 
require_once IA_ROOT . "/addons/lwx_helloting/lib/note.php";
global $_W, $_GPC;
	$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
	$uniacid=$_W['uniacid'];
	$uid=$this->getuid();
	$followstatus=$this->getfollowstatus();/*
	/* 	if($followstatus==0){
	 //跳转图文链接进行关注
	 $followurl="http://www.baidu.com";
	 echo "<script language='javascript' type='text/javascript'>"."window.location.href='{$followurl}'"."</script>";
	 exit();
	 } */
	//粉丝数据
	 $nickname=$_W['fans']['nickname'];
	$avatar=$_W['fans']['avatar'];
	if($operation=='livestyle'){
	    $id=intval($_GPC['id']);

        $sql="select * from ".tablename("lwxhello_note")." where id=:id";
        $param=array(":id"=>$id);
        $note=pdo_fetch($sql,$param);
        $goodStr=$note['goodid'];
        $len=strlen($goodStr);
        //如果该直播下单商品不为空，查询该直播的可下单商品列表
        if($len>0) {
            $sql = "select id,goodssn,costprice,title,thumb from " . tablename("lwxhello_goods") . " where id in (" . $goodStr . ")";
            $goodlist = pdo_fetchall($sql);
        }

	    //$goodlist=getgoodlist_bynote($id);
	    include $this->template('live_style');
	 //根据id获取商品产品   
	}elseif($operation=="getdetail"){
	    $id=intval($_GPC['id']);
	    if($id>0){
	        $good=pdo_fetchall("select * from ".tablename("lwxhello_goods")." where id=:id",array(":id"=>$id));
	        //获取到商品库存
            $goodstock=pdo_fetchall("select sum(stock) as stock from ".tablename("lwxhello_goodsstock")."
             where goodsid=:goodsid",array(":goodsid"=>$good[0]['id']));
            $good[0]['stock']=$goodstock[0]['stock'];
	        $size=explode(',',$good[0]['size']);
            $color=explode(',',$good[0]['color']);
            for($i=0;$i<count($size);$i++)
            {
                $spec_item_list[$i]['id']=$size[$i];
                $spec_item_list[$i]['size']=$size[$i];
            }
            $good['size']=$spec_item_list;
            for($j=0;$j<count($color);$j++)
            {
                $spec_item_list1[$j]['id']=$color[$j];
                $spec_item_list1[$j]['color']=$color[$j];
            }
            $good['color']=$spec_item_list1;


	        /*$sql="select  * from ".tablename("lwxhello_goodsstock")." where goodsid=:gid";
            $param=array(":gid"=>$good[0]['id']);
            $speclist=pdo_fetchall($sql,$param);
            foreach($speclist as &$spec){
                //=$spec['id'];
                //$sql="select id,title,thumb from ".tablename("shopping_spec_item")." where specid=:specid";
                //$param=array(":specid"=>$specid);
                //$spec_item_list=pdo_fetchall($sql,$param);
                $spec_item_list[0]['id']=$spec['id'];
            $spec_item_list[0]['size']=$spec['size'];
            $spec_item_list[0]['color']=$spec['color'];
            $spec_item_list[0]['stock']=$spec['stock'];
            //该商品该规格的属性列表
            $spec['item_list']=$spec_item_list;
        }
            //重新封装字段到商品列表，以三维数组形式表现
            $good['spec']=$speclist; */
            echo json_encode($good);exit();
	    }else{
	        $good=array();
	        echo json_encode($good);exit();
	    }
	//下一步商品列表    
	}elseif($operation=="nextgoodlist"){   
	    $goodidlist=$_GPC['id'];
	    $goodStr=implode(",", $goodidlist);
	    $len=strlen($goodStr);
	    //如果商品不为空，查询商品列表
	    if($len>0){
            $sql = "select id,goodssn,costprice,title,thumb from " . tablename("lwxhello_goods") . " where id in (" . $goodStr . ")";
            $goodlist = pdo_fetchall($sql);
	        echo json_encode($goodlist);exit();
	    }else{
	        $goodlist=array();
	        echo json_encode($goodlist);exit();
	    }    
//获取库存
	}elseif($operation=="getstock") {
	    $size=$_GPC['chicun'];
        $color=$_GPC['color'];
        $goodsid=$_GPC['id'];


        $bysise='';
        $bycolor='';
        $param=array(":goodsid"=>$goodsid);
        if($size!='')
        {
            $param1=array(":size"=>$size);
            $param=array_merge($param,$param1);
            $bysize="and"." size=:size";
        }
        if($color!='')
        {
            $param2=array(":color"=>$color);
            $param=array_merge($param,$param2);
            $bycolor="and"." color=:color";
        }
        $sql = "select sum(stock) as stock from " . tablename("lwxhello_goodsstock") . "
         where goodsid=:goodsid ".$bycolor." ".$bysize." ";
        $stock=pdo_fetchall($sql,$param);
        echo $stock[0]['stock'];
        //下订单
    } elseif($operation=="addgood"){
	    //goodlist 订单商品信息（二位数组）  goodlist[][goodid]商品表商品ID   goodlist[][itemid] 颜色,尺码goodlist[][total] 数量
        //noteid 直播间ID
        $goodlist=$_GPC["goodlist"];
        $totalprice=0;
        $j=0;
        if(count($goodlist>0)){
            $goodinfo=array();
            $alltotal=0;
            foreach ($goodlist as $row) {
                if (empty($row)) {
                    continue;
                }
                $itemid=explode(',',$row['itemid']);
                $color=$itemid[0];
                $size=$itemid[1];


                $goodsid=pdo_fetch("select id from ".tablename("lwxhello_goodsstock").
                    " where color=:color and size=:size1 and goodsid=:goodsid",array(":color"=>$color,":size1"=>$size,":goodsid"=>$row['goodid']));
                $goodinfoarr=array("id"=>$goodsid['id'],'num'=>$row['total']);
                $goodinfo[$j]=$goodinfoarr;
                $j++;
                //查询该商品的价格 * total  =price
                $good=pdo_fetch("select costprice  from ".tablename("lwxhello_goods")." where id=:id",array(":id"=>$row['goodid']));
                $costprice=$good['costprice'];
                $total=intval($row['total']);
                $price=$total*$costprice;
                $totalprice+=$price;
            }
            $data = array(
               // 'uid'=>$uid,
                'uid'=>$uid,//测试
                'ordersn' => date('md') . random(4, 1),
                'orderprice' => $totalprice,
                'status' => 0,
                'goodsinfo'=>serialize($goodinfo),
                'noteid'=>$_GPC['noteid'],
                'createtime' => TIMESTAMP
            );
            pdo_insert('lwxhello_order', $data);
            echo 1;exit();
        }
	//我的订单    
	}elseif($operation=="myorder"){
        //待完成订单信息  status=0
        $sql="select o.orderprice,o.goodsinfo,o.id,o.noteid,o.status,note.title notetitle   from ".tablename("lwxhello_order")."
	           o left join .".tablename("lwxhello_note")." note on note.id=o.noteid 
	            where o.uid=:uid  and o.status=0";
        $param=array(":uid"=>$uid);
        $dwc_orderlist=pdo_fetchall($sql,$param);
        foreach($dwc_orderlist as &$order){
            $orderid=intval($order['id']);//订单号
            $goodsinfo=unserialize($order['goodsinfo']);//库存商品表信息和数量
            $total=0;
            $k=0;
            foreach ($goodsinfo as &$goods)
            {
                $order['total']+=$goods['num'];//商品总件数
                $goods['id'];//库存商品表ID     商品图片，标题
                $sql="select g.thumb,g.title from ".tablename("lwxhello_goodsstock")
                    ." o_good  left join ".tablename("lwxhello_goods")."  g on o_good.goodsid=g.id 
	                where o_good.id=:id";
                $param=array(":id"=>$goods['id']);
                $goodlist[$k]=pdo_fetch($sql,$param);
                $k++;
                $order['type_total']=$k;
            }
            $order['price']=$order['orderprice'];
            $order['goodlist']=array_unique($goodlist);//去重图片
            /* print_r('<pre>');
            print_r($order);
            print_r('</pre>');*/
        }
        //已完成订单信息  status=1
        $sql="select o.orderprice,o.goodsinfo,o.id,o.noteid,o.status,note.title notetitle   from ".tablename("lwxhello_order")."
	           o left join .".tablename("lwxhello_note")." note on note.id=o.noteid 
	            where o.uid=:uid  and o.status=1";
        $param=array(":uid"=>$uid);
        $ywc_orderlist=pdo_fetchall($sql,$param);
        foreach($ywc_orderlist as &$order){
            $orderid=intval($order['id']);//订单号
            $goodsinfo=unserialize($order['goodsinfo']);//库存商品表信息和数量
            $total=0;
            $k=0;
            foreach ($goodsinfo as &$goods)
            {
                $order['total']+=$goods['num'];//商品总件数
                $goods['id'];//库存商品表ID     商品图片，标题
                $sql="select  g.thumb,g.title from ".tablename("lwxhello_goodsstock")
                    ." o_good  left join ".tablename("lwxhello_goods")."  g on o_good.goodsid=g.id 
	                where o_good.id=:id";
                $param=array(":id"=>$goods['id']);
                $goodlist[$k]=pdo_fetch($sql,$param);
                $k++;
                $order['type_total']=$k;
            }
            $order['price']=$order['orderprice'];
            $order['goodlist']=array_unique($goodlist);
        }
        //全部订单信息
        $sql="select o.orderprice,o.goodsinfo,o.id,o.noteid,o.status,note.title notetitle   from ".tablename("lwxhello_order")."
	           o left join .".tablename("lwxhello_note")." note on note.id=o.noteid 
	            where o.uid=:uid ";
        $param=array(":uid"=>$uid);
        $all_orderlist=pdo_fetchall($sql,$param);
        foreach($all_orderlist as &$order){
            $orderid=intval($order['id']);//订单号
            $goodsinfo=unserialize($order['goodsinfo']);//库存商品表信息和数量
            $total=0;
            $k=0;
            foreach ($goodsinfo as &$goods)
            {
                $order['total']+=$goods['num'];//商品总件数
                $goods['id'];//库存商品表ID     商品图片，标题
                $sql="select  g.thumb,g.title from ".tablename("lwxhello_goodsstock")
                    ." o_good  left join ".tablename("lwxhello_goods")."  g on o_good.goodsid=g.id 
	                where o_good.id=:id";
                $param=array(":id"=>$goods['id']);
                $goodlist[$k]=pdo_fetch($sql,$param);
                $k++;
                $order['type_total']=$k;
            }
            $order['price']=$order['orderprice'];
            $order['goodlist']=array_unique($goodlist);
        }
        /*print_r('<pre>');
        print_r($all_orderlist);
        print_r('</pre>');*/
	    include $this->template('me_order');
	//订单详情页    
	}elseif($operation=="order_detail"){
	    $id=intval($_GPC['id']);
	    $sql="select *  from ".tablename("lwxhello_order")."  where  id=:orderid";
	    $param=array(":orderid"=>$id);
	    $order=pdo_fetch($sql,$param);
	    $total_price=$order['orderprice'];//总价格
        $goodlist=unserialize($order['goodsinfo']);
        $total=0;
        $type_total=count($goodlist);
        //循环他的商品规格 以及规格内容
	    foreach($goodlist as &$item){
            $sql="select  g.thumb,g.title,g.costprice,g.goodssn,o_good.size,o_good.color from ".tablename("lwxhello_goodsstock")
                ." o_good  left join ".tablename("lwxhello_goods")."  g on o_good.goodsid=g.id 
	                where o_good.id=:id";
	        $param=array(":id"=>$item['id']);
            $goodsinfo=pdo_fetch($sql,$param);
            $goodsinfo['total']=$item['num'];
            $goodsinfo['thumb']='http://h5.lwest.cn/hellot_admin/thinkphp3/Public/uploads/'.$goodsinfo['thumb'];
            $item=array_merge($goodsinfo,$item);
            $item['price']=$item['total']*$item['costprice'];
            $total+=$goodsinfo['total'];
        }
        /*print_r('<pre>');
        print_r($goodlist);
        print_r('</pre>');*/

	    include $this->template('me_order_style');
	    //再次下单
	}elseif($operation=="againorder"){
	    //$_GPC['id']  再次下单的订单ID
        $id=intval($_GPC['id']);
        $sql="select goodsinfo from ".tablename("lwxhello_order")." where id=:id";
        $param=array(":id"=>$id);
        $goods1=pdo_fetch($sql,$param);
        $goodsinfo=unserialize($goods1['goodsinfo']);
        //先判断是否还有库存
        $i=0;
        $j=0;
        foreach ($goodsinfo as &$item)
        {
            $sql="select a.*,b.goodssn,b.thumb,b.costprice,b.title from ".tablename("lwxhello_goodsstock").
                " a join.".tablename("lwxhello_goods")." b on a.goodsid=b.id where a.id=:id";
            $param=array(":id"=>$item['id']);
            $goods=pdo_fetch($sql,$param);

            if($item['num']<=$goods['stock'])
            {//如果库存大于购买数量，可以购买
                $j++;
            }
            /*$goods['thumb']='http://h5.lwest.cn/hellot_admin/thinkphp3/Public/uploads/'.$goods['thumb'];
            $goods['num']=$item['num'];
            $goods['totle']=intval($goods['num'])*$goods['costprice'];
            $goodsinfoxq[$i]=$goods;*/
            $i++;
        }
        if($j==count($goodsinfo))
        {//如果库存足够
            $data = array(
                'uid'=>$uid,
                'ordersn' => date('md') . random(4, 1),
                'orderprice' => $goods1['orderprice'],
                'status' => 0,
                'goodsinfo'=>$goods1['goodsinfo'],
                'noteid'=>$goods1['noteid'],
                'createtime' => TIMESTAMP
            );
            pdo_insert('lwxhello_order', $data);
            echo 1;exit();
        }
        else
        {
            echo 2;exit();
        }
        //编辑商品
    }elseif($operation=="bjgetstock")
    {
        $size=$_GPC['chicun'];
        $color=$_GPC['color'];
        $goodsid=$_GPC['id'];
        $num=$_GPC['newnum'];
        $sql = "select sum(stock) as stock from " . tablename("lwxhello_goodsstock") . "
         where goodsid=:goodsid and color=:color and size=:size";
        $param=array(":goodsid"=>$goodsid,":size"=>$size,":color"=>$color);
        $stock=pdo_fetch($sql,$param);
        if($stock['stock']<$num)//如果新的库存大于数量
        {echo 2;}
        else
        {echo 1;}
    }
 ?>