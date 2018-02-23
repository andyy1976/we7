<?php  
global $_W, $_GPC;
load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    //分页
    $pindex = max(1, intval($_GPC['page']));
    $psize = 15;
    $sql = 'SELECT COUNT(id) FROM ' . tablename('lwxhello_quality_feedback') ;
    $total = pdo_fetchcolumn($sql, $params);
    if (!empty($total)) {
        $list = pdo_fetchall("SELECT * FROM " . tablename('lwxhello_quality_feedback') . " WHERE weid = '{$_W['uniacid']}' ORDER BY id DESC  LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
        $pager = pagination($total, $pindex, $psize);
    }
    foreach($list as &$item){
        $item['problem']=unserialize($item['problem']);
    }
}elseif($operation=="export"){
    $list = pdo_fetchall("SELECT id,shopname,opentime,quality,style,status,createtime FROM " . tablename('lwxhello_quality_feedback') . " WHERE weid = '{$_W['uniacid']}' ORDER BY id DESC   " );
    foreach($list as &$item){
        $item['createtime']=date("Y-m-d H:i:s",$item['createtime']);
    }
    
    $title="<tr><td>编号</td><td>店铺名称</td><td>开业时间</td><td>质量评分</td><td>款式评分</td><td>销售评分</td><td>时间</td></tr>";
    $this->outputXlsHeader($list,"质量反馈表",$title);
    
} elseif($operation=="post"){
    $id = intval($_GPC['id']);
    $adv = pdo_fetch("select * from " . tablename('lwxhello_quality_feedback') . " where id=:id and weid=:weid limit 1", array(":id" => $id, ":weid" => $_W['uniacid']));
    $adv['problem']=unserialize($adv['problem']);
}elseif($operation=="replylist"){
        $id=intval($_GPC['id']);
        //_lwxhello_feedbackreply
        $sql="select * from ".tablename("lwxhello_feedbackreply")." where fid=:id and type=4  order by id desc ";
        $param=array(":id"=>$id);
        $replylist=pdo_fetchall($sql,$param);
    
}elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $adv = pdo_fetch("SELECT id FROM " . tablename('lwxhello_quality_feedback') . " WHERE id = '$id' AND weid=" . $_W['uniacid'] . "");
    if (empty($adv)) {
        message('抱歉，不存在或是已经被删除！', $this->createWebUrl('quality_feedback', array('op' => 'display')), 'error');
    }
    pdo_delete('lwxhello_quality_feedback', array('id' => $id));
    message('删除成功！', $this->createWebUrl('quality_feedback', array('op' => 'display')), 'success');
    //回复用户
}elseif($operation=="reply"){
        $id=intval($_GPC['id']);
        $content=$_GPC['content'];
        $reply=array("type"=>4,"content"=>$content,"fid"=>$id,"status"=>1,"createtime"=>time());
        $result=pdo_insert("lwxhello_feedbackreply",$reply);
        
        //设置该反馈为已经回复
        $result=pdo_update("lwxhello_quality_feedback",array("ifreply"=>2,"ifnewreply"=>1),array("id"=>$id));
        //发送模板消息给用户
        $feedback = pdo_fetch("SELECT uid FROM " . tablename('lwxhello_quality_feedback') . " WHERE id = '$id' AND weid=" . $_W['uniacid'] . "");
        $uid=intval($feedback['uid']);
        if($uid>0){
            $sql="SELECT openid FROM ims_mc_mapping_fans WHERE uid=:uid";
            $fans=pdo_fetch($sql,array(":uid"=>$uid));
            $keyword1="客服回复";
            $keyword2="客服回复";
            $keyword3=date('Y-m-d H:i:s',time());
            $postdata=array("first"=>array("value"=>"您好，您的反馈已被回复，请前往【我】查看。","color"=>"#743A3A"),
                "keyword1"=>array("value"=>$keyword1,"color"=>"#743A3A"),
                "keyword2"=>array("value"=>$keyword2,"color"=>"#743A3A"),
                "remark"=>array("value"=>"谢谢您的反馈","color"=>"#743A3A"));
            $touser=$fans['openid'];
            $tpl_id_short="lbFt_5C253ZoaZhi8jMEqKHrPTB3dhNSRaZDRXUkiiI";
            $account_api = WeAccount::create();
            $url="";
            $result=$account_api->sendTplNotice($touser, $tpl_id_short, $postdata, $url =$url, $topcolor = '#FF683F');
        }
        message('添加成功！', $this->createWebUrl('quality_feedback', array('op' => 'display')), 'success');
    
} else {
    message('请求方式不存在');
}
include $this->template('qualityfeedback', TEMPLATE_INCLUDEPATH, true);
?>