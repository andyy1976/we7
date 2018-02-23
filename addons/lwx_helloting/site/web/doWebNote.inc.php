<?php 
	global $_W, $_GPC;
	$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
	$uniacid=$_W['uniacid'];
	if($operation=='display'){
	    //查询所有帖子
	    $params=array();
	    $condition=" where weid=:weid ";
	    $params[':weid']=$uniacid;
	    
	    //关键字 
	    if (!empty($_GPC['keyword'])) {
	        $condition .= " and   `title` like  '%{$_GPC['keyword']}%'";
	    }
	    
	    //分页
	    $pindex = max(1, intval($_GPC['page']));
	    $psize = 15;
	    $sql = 'SELECT COUNT(id) FROM ' . tablename('lwxhello_note') . $condition;
	    $total = pdo_fetchcolumn($sql, $params);
	    if (!empty($total)) {
	        $sql = 'SELECT  *  FROM ims_lwxhello_note
				  ' .$condition . '
				ORDER BY   id DESC  LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
	        $list = pdo_fetchall($sql, $params);
	        $pager = pagination($total, $pindex, $psize);
	    }
	    
	}elseif($operation=='post'){
	    
	    $id = intval($_GPC['id']);
	    $adv = pdo_fetch("select * from " . tablename('lwxhello_note') . " where id=:id  limit 1", array(":id" => $id));
	    //商品列表 货号 图片 名称
	    $sql="select id,goodssn,title,thumb from ".tablename("shopping_goods")." where weid=:weid and deleted=0";
	    $param=array(":weid"=>$uniacid);
	    $goodlist=pdo_fetchall($sql,$param);
	    //查询他已经被选择的商品
	    $goodStr=$adv['goodid'];
	    $len=strlen($goodStr);
	    if($len>0){
	        $sql="select id,goodssn,title,thumb from ".tablename("shopping_goods")." where weid=:weid and deleted=0 and id in (".$goodStr.")";
	        $param=array(":weid"=>$uniacid);
	        $chooselist=pdo_fetchall($sql,$param); 
	    }
	    foreach($chooselist as $good){
	        foreach($goodlist as &$g){
	            if($good['id']==$g['id']){
	                $g['ifcheck']="checked";
	            }
	        }
	    }
	    //专题列表
	    load()->func('tpl');
	    $sql = 'SELECT * FROM ' . tablename('lwxhello_theme') . ' WHERE `weid` = :weid ORDER BY `parentid`, `displayorder` DESC';
	   $category = pdo_fetchall($sql, array(':weid' => $_W['uniacid']), 'id');
		if (!empty($category)) {
			$parent = $children = array();
			foreach ($category as $cid => $cate) {
				if (!empty($cate['parentid'])) {
					$children[$cate['parentid']][] = $cate;
				} else {
					$parent[$cate['id']] = $cate;
				}
			}
		}
		
	    if (checksubmit('submit')) {
	        if(intval($_GPC['ishot'])==0){
	            $ishot=2;
	        }else{
	            $ishot=$_GPC['ishot'];
	        }
	        if(intval($_GPC['isnew'])==0){
	            $isnew=2;
	        }else{
	            $isnew=$_GPC['isnew'];
	        }
	        if(intval($_GPC['jstj'])==0){
	            $jstj=2;
	        }else{
	            $jstj=$_GPC['jstj'];
	        }
	         $data = array(
	            'weid' => $_W['uniacid'],
	            'thumb'=>$_GPC['thumb'],
	            'title'	=>$_GPC['title'],
	            'content'=>htmlspecialchars_decode($_GPC['content']),
	            'ishot'=>$ishot,
	             'pcate' => intval($_GPC['category']['parentid']),
	             'ccate' => intval($_GPC['category']['childid']),
	            'isnew'=>$isnew,
	            'jstj'=>$jstj,
	             'video_url'=>$_GPC['video_url'],
	             'pdf_name'=>$_GPC['pdf_name'],
	            'cateid'=>$_GPC['cateid'],
	             'goodid'=>implode(",", $_GPC['goodid'])
	        );
	         //pdf  
	        //上传文件
	        $file = $_FILES['file'];//得到传输的数据
	        $name = $file['name'];//得到文件名称
	        $type = strtolower(substr($name,strrpos($name,'.')+1)); //得到文件类型，并且都转化成小写
	        /*   $allow_type = array('jpg','jpeg','gif','png'); //定义允许上传的类型
	         //判断文件类型是否被允许上传
	         if(!in_array($type, $allow_type)){
	         //如果不被允许，则直接停止程序运行
	         message("请选择图片类型!") ;
	        } */
	        //判断是否是通过HTTP POST上传的
	        if($name!=""){
	            if(!is_uploaded_file($file['tmp_name'])){
	                //如果不是通过HTTP POST上传的
	                message("传输类型有误，请重新上传!")  ;
	            }
	            $upload_path = "../attachment/lwx_helloting/"; //上传文件的存放路径
	            //开始移动文件到相应的文件夹
	            $filename=iconv("UTF-8","gbk",$_FILES["file"]["name"]);
	            $imgname=date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999);
	            $filename ="".$imgname.".pdf";
	            //move_uploaded_file($_FILES["file"]["tmp_name"],"upload/" . iconv("UTF-8","gbk",$_FILES["file"]["name"]));
	            if(move_uploaded_file($file['tmp_name'],$upload_path.$filename)){
	                $data['pdf_url']="../attachment/lwx_helloting/".$filename;
	            }else{
	                message("上传文件失败!");exit();
	            }
	        }
	        
	        //pdf
	       
	        if ($id>0) {
	            pdo_update('lwxhello_note', $data, array('id' => $id));
	        } else {
	            $data['createtime']=time();
	            pdo_insert('lwxhello_note', $data);
	            $id = pdo_insertid();
	        }
	        message('更新帖子成功！', $this->createWebUrl('note', array('op' => 'display')), 'success');
	    }
	   
	}elseif($operation=='delete'){
	    $id = intval($_GPC['id']);
	    $adv = pdo_fetch("SELECT id FROM " . tablename('lwxhello_note') . " WHERE id = '$id' ");
	    if (empty($adv)) {
	        message('抱歉，帖子不存在或是已经被删除！', $this->createWebUrl('note', array('op' => 'display')), 'error');
	    }
	    pdo_delete('lwxhello_note', array('id' => $id));
	    message('帖子删除成功！', $this->createWebUrl('note', array('op' => 'display')), 'success');
	}elseif($operation=="pingbi"){
	    $id = intval($_GPC['id']);
	    $adv = pdo_fetch("SELECT id FROM " . tablename('lwxhello_note') . " WHERE id = '$id' ");
	    if (empty($adv)) {
	        echo -1;exit();
	    }else{
	        $result=pdo_update("lwxhello_note",array("ifpb"=>2),array("id"=>$id));
	        echo $result;exit();
	    }
	}elseif($operation=="chalepingbi"){
	    $id = intval($_GPC['id']);
	    $adv = pdo_fetch("SELECT id FROM " . tablename('lwxhello_note') . " WHERE id = '$id' ");
	    if (empty($adv)) {
	        echo -1;exit();
	    }else{
	        $result=pdo_update("lwxhello_note",array("ifpb"=>1),array("id"=>$id));
	        echo $result;exit();
	    }
	}
	include $this->template('note');
 ?>