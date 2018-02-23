<?php 
global $_W, $_GPC;
load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 15;
    $status = $_GPC['status'];
    $sendtype = !isset($_GPC['sendtype']) ? 0 : $_GPC['sendtype'];
    $condition = " o.weid = :weid";
    $paras = array(':weid' => $_W['uniacid']);

    if (empty($starttime) || empty($endtime)) {
        $starttime = strtotime('-1 month');
        $endtime = TIMESTAMP;
    }
    if (!empty($_GPC['time'])) {
        $starttime = strtotime($_GPC['time']['start']);
        $endtime = strtotime($_GPC['time']['end']) + 86399;
        $condition .= " AND o.createtime >= :starttime AND o.createtime <= :endtime ";
        $paras[':starttime'] = $starttime;
        $paras[':endtime'] = $endtime;
    }
   
    if (!empty($_GPC['keyword'])) {
        $condition .= " AND o.ordersn LIKE '%{$_GPC['keyword']}%'";
    }
     
    if ($status != '') {
        $condition .= " AND o.status = '" . intval($status) . "'";
    }
  

    $sql = 'SELECT COUNT(*) FROM ' . tablename('shopping_order') . ' AS `o` WHERE ' . $condition;
    $total = pdo_fetchcolumn($sql, $paras);
    if ($total > 0) {

        if ($_GPC['export'] != 'export') {
            $limit = ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
        }

        $sql = 'SELECT * FROM ' . tablename('shopping_order') . ' AS `o` WHERE ' . $condition . ' ORDER BY
						`o`.`status` DESC, `o`.`createtime` DESC ' . $limit;
        $list = pdo_fetchall($sql,$paras);
        $pager = pagination($total, $pindex, $psize);

     
        $orderstatus = array (
            '-1' => array('css' => 'default', 'name' => '已取消'),
            '0' => array('css' => 'danger', 'name' => '待付款'),
            '1' => array('css' => 'info', 'name' => '待发货'),
            '2' => array('css' => 'warning', 'name' => '待收货'),
            '3' => array('css' => 'success', 'name' => '已完成')
        );
        foreach ($list as &$value) {
            $s = $value['status'];
            $value['statuscss'] = $orderstatus[$value['status']]['css'];
            $value['status'] = $orderstatus[$value['status']]['name'];

           
        }

      /*   if ($_GPC['export'] != '') {
            $html = "\xEF\xBB\xBF";

            $filter = array(
                'ordersn' => '订单号',
                'goods_title' => '商品',
                'username' => '姓名',
                'mobile' => '电话',
                'paytype' => '支付方式',
                'dispatch' => '配送方式',
                'dispatchprice' => '运费',
                'price' => '总价',
                'status' => '状态',
                'createtime' => '下单时间',
                'zipcode' => '邮政编码',
                'address' => '收货地址信息'
            );

            foreach ($filter as $key => $title) {
                $html .= $title . "\t,";
            }
            $html .= "\n";
            foreach ($list as $k => $v) {
                foreach ($filter as $key => $title) {
                    $good = pdo_get('shopping_order_goods', array('orderid' => $v['id']));
                    $good = pdo_get('shopping_goods', array('id' => $good['goodsid']));
                    $v['goods_title'] = $good['title'];
                    if ($key == 'createtime') {
                        $html .= date('Y-m-d H:i:s', $v[$key]) . "\t, ";
                    } else {
                        $html .= $v[$key] . "\t, ";
                    }
                }
                $html .= "\n";
            }
            header("Content-type:text/csv");
            header("Content-Disposition:attachment; filename=全部数据.csv");
            echo $html;
            exit();

        } */

    }
} elseif ($operation == 'detail') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT * FROM " . tablename('shopping_order') . " WHERE id = :id AND weid = :weid", array(':id' => $id, ':weid' => $_W['uniacid']));
    if (empty($item)) {
        message("抱歉，订单不存在!", referer(), "error");
    }
    if (checksubmit('finish')) {
        pdo_update('shopping_order', array('status' => 3, 'remark' => $_GPC['remark']), array('id' => $id, 'weid' => $_W['uniacid']));
        message('订单操作成功！', referer(), 'success');
    }
    if (checksubmit('cancel')) {
        pdo_update('shopping_order', array('status' => 1, 'remark' => $_GPC['remark']), array('id' => $id, 'weid' => $_W['uniacid']));
        message('取消完成订单操作成功！', referer(), 'success');
    }
    // 订单取消
    if (checksubmit('cancelorder')) {
        if ($item['status'] == 1) {
            load()->model('mc');
            $memberId = mc_openid2uid($item['from_user']);
            mc_credit_update($memberId, 'credit2', $item['price'], array($_W['uid'], '微商城取消订单退款说明'));
        }
        pdo_update('shopping_order', array('status' => '-1'), array('id' => $item['id']));
        message('订单取消操作成功！', referer(), 'success');
    }


    $goods = pdo_fetchall("SELECT g.*, o.total,g.type,o.optionname,o.optionid,o.price as orderprice FROM " . tablename('shopping_order_goods') .
        " o left join " . tablename('shopping_goods') . " g on o.goodsid=g.id " . " WHERE o.orderid='{$id}'");
    $item['goods'] = $goods;
} elseif ($operation == 'delete') {
    /*订单删除*/
    $orderid = intval($_GPC['id']);
    if (pdo_delete('shopping_order', array('id' => $orderid, 'weid' => $_W['uniacid']))) {
        message('订单删除成功', $this->createWebUrl('order', array('op' => 'display')), 'success');
    } else {
        message('订单不存在或已被删除', $this->createWebUrl('order', array('op' => 'display')), 'error');
    }
}
include $this->template('order');
?>