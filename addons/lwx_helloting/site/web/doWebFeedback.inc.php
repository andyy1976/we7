 <?php  
global $_W, $_GPC;
load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    //分页
    $pindex = max(1, intval($_GPC['page']));
    $psize = 15;
    $sql = 'SELECT COUNT(id) FROM ' . tablename('lwxhello_feedback') ;
    $total = pdo_fetchcolumn($sql, $params);
    if (!empty($total)) {
        $list = pdo_fetchall("SELECT * FROM " . tablename('lwxhello_feedback') . " WHERE weid = '{$_W['uniacid']}' ORDER BY id DESC  LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
        $pager = pagination($total, $pindex, $psize);
    }
}elseif($operation=="export"){
    $list = pdo_fetchall("SELECT id,content,contact,createtime  FROM " . tablename('lwxhello_feedback') . " WHERE weid = '{$_W['uniacid']}' ORDER BY id DESC   " );
    foreach($list as &$item){
        $item['createtime']=date("Y-m-d H:i:s",$item['createtime']);
    }
    
    $title="<tr><td>编号</td><td>内容</td><td>联系方式</td><td>时间</td></tr>";
    $this->outputXlsHeader($list,"意见反馈表",$title);
}elseif($operation=="post") {
    $id = intval($_GPC['id']);
    $adv = pdo_fetch("select * from " . tablename('lwxhello_feedback') . " where id=:id and weid=:weid limit 1", array(":id" => $id, ":weid" => $_W['uniacid']));
    //图片是数组 反序列化显示一下
    
    $adv['bgimg']=unserialize($adv['bgimg']);
    if(is_array($adv['bgimg'])){
       $count=count($adv['bgimg']);
    }else{
       $count=0;
    }
}elseif($operation=="delete"){ 
    $id = intval($_GPC['id']);
    $adv = pdo_fetch("SELECT id FROM " . tablename('lwxhello_feedback') . " WHERE id = '$id' AND weid=" . $_W['uniacid'] . "");
    if (empty($adv)) {
        message('抱歉，不存在或是已经被删除！', $this->createWebUrl('feedback', array('op' => 'display')), 'error');
    }
    pdo_delete('lwxhello_feedback', array('id' => $id));
    message('删除成功！', $this->createWebUrl('feedback', array('op' => 'display')), 'success');
}else{ 
    message('请求方式不存在');
}
include $this->template('feedback', TEMPLATE_INCLUDEPATH, true);
?>