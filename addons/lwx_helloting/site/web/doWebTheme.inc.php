<?php  
global $_W, $_GPC;
load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $category = pdo_fetchall("SELECT id,name,parentid,displayorder FROM " . tablename('lwxhello_theme') . " WHERE weid = '{$_W['uniacid']}' ORDER BY parentid ASC, displayorder DESC");
    foreach ($category as $index => $row) {
        if (!empty($row['parentid'])) {
            $children[$row['parentid']][] = $row;
            unset($category[$index]);
        }
        
    }
    foreach($category as $cindex=>$crow){
        foreach($children as $index=>$row){
            if($row[0]['parentid']==$crow['id']){
                $child[$row[0]['parentid']]=$row;
                unset($children[$index]);
            }
        }
        
    }
} elseif ($operation == 'post') {
    $parentid = intval($_GPC['parentid']);
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $category = pdo_fetch("SELECT * FROM " . tablename('lwxhello_theme') . " WHERE id = :id  ", array(':id' => $id ));
    } else {
        $category = array(
            'displayorder' => 0,
        );
    }
    if (!empty($parentid)) {
        $parent = pdo_fetch("SELECT id, name FROM " . tablename('lwxhello_theme') . " WHERE id = '$parentid'");
        if (empty($parent)) {
            message('抱歉，上级分类不存在或是已经被删除！', $this->createWebUrl('post'), 'error');
        }
    }
    if (checksubmit('submit')) {
        if (empty($_GPC['catename'])) {
            message('抱歉，请输入分类名称！');
        }
        $data = array(
            'name' => $_GPC['catename'],
            'displayorder' => intval($_GPC['displayorder']),
            'parentid' => intval($parentid),
            'thumb' => $_GPC['thumb'],
            'weid'=>$_W['uniacid']
        );
        if (!empty($id)) {
            unset($data['parentid']);
            pdo_update('lwxhello_theme', $data, array('id' => $id));
        } else {
            pdo_insert('lwxhello_theme', $data);
            $id = pdo_insertid();
        }
        message('更新分类成功！', $this->createWebUrl('theme', array('op' => 'display')), 'success');
    }
   /*  $id = intval($_GPC['id']);
    if (checksubmit('submit')) {
        $data = array(
            'weid' => $_W['uniacid'],
            'title' => $_GPC['title'],
            'thumb'=>$_GPC['thumb'],
            'displayorder'=>$_GPC['displayorder']
        );
        if (!empty($id)) {
            pdo_update('lwxhello_theme', $data, array('id' => $id));
        } else {
            pdo_insert('lwxhello_theme', $data);
            $id = pdo_insertid();
        }
        message('更新分类成功！', $this->createWebUrl('theme', array('op' => 'display')), 'success');
    }
    $adv = pdo_fetch("select * from " . tablename('lwxhello_theme') . " where id=:id and weid=:weid limit 1", array(":id" => $id, ":weid" => $_W['uniacid'])); */
} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $adv = pdo_fetch("SELECT id FROM " . tablename('lwxhello_theme') . " WHERE id = '$id' AND weid=" . $_W['uniacid'] . "");
    if (empty($adv)) {
        message('抱歉，分类不存在或是已经被删除！', $this->createWebUrl('theme', array('op' => 'display')), 'error');
    }
    pdo_delete('lwxhello_theme', array('id' => $id));
    message('分类删除成功！', $this->createWebUrl('theme', array('op' => 'display')), 'success');
} else {
    message('请求方式不存在');
}
include $this->template('theme', TEMPLATE_INCLUDEPATH, true);
?>