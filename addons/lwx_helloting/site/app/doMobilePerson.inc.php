<?php 

global $_W, $_GPC;
	$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
	$uniacid=$_W['uniacid'];
	$uid=$this->getuid();
	$followstatus=$this->getfollowstatus();
	/* 	if($followstatus==0){
	 //跳转图文链接进行关注
	 $followurl="http://www.baidu.com";
	 echo "<script language='javascript' type='text/javascript'>"."window.location.href='{$followurl}'"."</script>";
	 exit();
	 } */
	//粉丝数据
	$nickname=$_W['fans']['nickname'];
	$avatar=$_W['fans']['avatar'];
	if($operation=='display'){
	 	include $this->template('me');
	 //我的原创	
	}elseif($operation=='me_original'){
	    $sql="select * from ".tablename("lwxhello_note")." where uid=:uid order by id desc ";
	    $param=array(":uid"=>$uid);
	    $originalList=pdo_fetchall($sql,$param);
	    foreach($originalList as &$originals){
	        $originals['thumb_url']=unserialize($originals['thumb_url']);
	    }
	 	include $this->template('me_original');
	 //删除我的原创
	}elseif($operation=="del_original"){	
	    $id=intval($_GPC['id']);
	    if($id==0){
	        echo 2;exit();
	    }else{
	        $result=pdo_delete("lwxhello_note",array("id"=>$id));
	        echo $result;exit();
	    }
	//我的收藏	
	}elseif($operation=='me_collect'){
	    $sql="select c.createtime,n.title,n.id nid,m2.description,m.avatar,m.nickname from ".tablename("lwxhello_note")." n 
	        left join ".tablename("lwxhello_notecollect")
	        ." c  on n.id=c.noteid  left join ".tablename("mc_members")." m 
	         on m.uid=n.uid  left join ".tablename("lwxhello_member")." m2 on m.uid=m2.uid 
	         where c.uid=:uid";
	    $param=array(":uid"=>$uid);
	    $collectList=pdo_fetchall($sql,$param);
	 	include $this->template('me_collect');
	 //我的关注
	}elseif($operation=='me_follow'){
	    //查询我关注的粉丝
	/*     $sql="select c.createtime,n.title,n.id nid,m2.description,m.avatar,m.nickname from ".tablename("lwxhello_note")." n
	        left join ".tablename("lwxhello_notelike")
	      ." c  on n.id=c.noteid  left join ".tablename("mc_members")." m
	        on m.uid=n.uid  left join ".tablename("lwxhello_member")." m2 on m.uid=m2.uid
	        where c.uid=:uid";
	    $param=array(":uid"=>$uid);
	    $likeList=pdo_fetchall($sql,$param); */
	    $sql="select  m.id mid,m.uid muid,member.uid,member.nickname,member.avatar,m.description from ".tablename("lwxhello_subsribemember")."
	         sub left join  ".tablename("mc_members")." member on sub.besubuid=member.uid
	             left join  ".tablename("lwxhello_member")." m on  sub.besubuid=m.uid where  sub.uid=:uid group by sub.besubuid order by sub.createtime desc";
	    $param=array(":uid"=>$uid);
	    $likeList=pdo_fetchall($sql,$param);
	    //朗文斯汀头像
	    foreach($likeList as &$l){
	        if($l['muid']==1

            ){
	            $l['avatar']="../addons/lwx_helloting/template/mobile/public/images/logo.png";
	            $l['nickname']="朗文斯汀";
	            $l['description']="不同的城市，相同的朗文斯汀";
	        }
	    }
	    include $this->template('me_follow');
	//我的反馈
	}elseif($operation=='me_feedback'){
		include $this->template('me_feedback');
	//反馈详情页	
	}elseif($operation=="feedbackDetail"){
	    $id=intval($_GPC['id']);
	    $type=intval($_GPC['type']);	//1.新货反馈表  2.开业满意度评分表  3.店铺设计 4.质量反馈 
	    if($type==1){
	        $sql="select * from ".tablename("lwxhello_newgoods_feedback");
	        $title="新货反馈表";
	        $sql.=" where id=:id";
	        $param=array(":id"=>$id);
	        $feedback=pdo_fetch($sql,$param);
	        //是否有最新回复 如果是 设置为否
	        $ifnewreply=intval($feedback['ifnewreply']);
	        if($ifnewreply==1){
	            $result=pdo_update("lwxhello_newgoods_feedback",array("ifnewreply"=>2),array("id"=>$id));
	        }
	    }elseif($type==2){
	        $sql="select * from ".tablename("lwxhello_opening_feedback");
	        $title="开业满意度评分表";
	        $sql.=" where id=:id";
	        $param=array(":id"=>$id);
	        $feedback=pdo_fetch($sql,$param);
	        //是否有最新回复 如果是 设置为否
	        $ifnewreply=intval($feedback['ifnewreply']);
	        if(ifnewreply==1){
	            $result=pdo_update("lwxhello_opening_feedback",array("ifnewreply"=>2),array("id"=>$id));
	        }
	    }elseif($type==3){
	        $sql="select * from ".tablename("lwxhello_shop_feedback");
	        $title="店铺设计及道具满意度评分表";
	        $sql.=" where id=:id";
	        $param=array(":id"=>$id);
	        $feedback=pdo_fetch($sql,$param);
	        //是否有最新回复 如果是 设置为否
	        $ifnewreply=intval($feedback['ifnewreply']);
	        if(ifnewreply==1){
	            $result=pdo_update("lwxhello_shop_feedback",array("ifnewreply"=>2),array("id"=>$id));
	        }
	    }elseif($type==4){
	        $sql="select * from ".tablename("lwxhello_quality_feedback");
	        $title="质量反馈表";
	        $sql.=" where id=:id";
	        $param=array(":id"=>$id);
	        $feedback=pdo_fetch($sql,$param);
	        //是否有最新回复 如果是 设置为否
	        $ifnewreply=intval($feedback['ifnewreply']);
	        if(ifnewreply==1){
	            $result=pdo_update("lwxhello_quality_feedback",array("ifnewreply"=>2),array("id"=>$id));
	        }
	    }
	    $feedback['problem']=unserialize($feedback['problem']);
	    //查询回复列表 lwxhello_feedbackreply
	    $sql="select * from ".tablename("lwxhello_feedbackreply")." where fid=:fid and type=:type1";
	    $param=array(":fid"=>$id,":type1"=>$type);
	    $replylist=pdo_fetchall($sql,$param);
	    //查询后台是否回复
	    $sql="select id from ".tablename("lwxhello_feedbackreply")." where fid=:fid and status=1 and type1=:type1";
	    $param=array(":fid"=>$id,":type1"=>$type);
	    $replyInfo=pdo_fetch($sql,$param);
	    if(empty($replyInfo)){
	        $ifreply=2;//客服没有回复
	    }else{
	        $ifreply=1;//客服已经回复
	    }
	    //print_r($param);
	    include $this->template('me_feedback_info');exit();
	//用户添加反馈回复    
	}elseif($operation=="addreplyfeedback"){    
	    $id=intval($_GPC['id']);
	    $type=intval($_GPC['type']);
	    $content=htmlspecialchars($_GPC['content']);
	    $reply=array("type"=>$type,"content"=>$content,"fid"=>$id,"status"=>2,"createtime"=>time());
	    $result=pdo_insert("lwxhello_feedbackreply",$reply);
	    echo $result;exit();
	//设置	
	}elseif($operation=="my_setup"){
	    include $this->template('setup');
	 //编辑我的个性签名  
	}elseif($operation=="editmystyle"){
	    $description=htmlspecialchars_decode($_GPC['content']);
	    $sql="select id from ".tablename("lwxhello_member")." where uid=:uid";
	    $param=array(":uid"=>$uid);
	    $member=pdo_fetch($sql,$param);
	    if($member){
	        //进行修改
	        $result=pdo_update("lwxhello_member",array("description"=>$description),array("id"=>$member['id']));
	    }else{
	        //进行添加
	        $result=pdo_insert("lwxhello_member",array("uid"=>$uid,"description"=>$description));
	    }
	    echo $result;exit();
	 //发布Po图   
	}
    elseif($operation=="addPonote"){
	    $note=array(
	        "title"=>$_GPC['title'],
	        "thumb_url"=>serialize($_GPC['thumb_url']),
	        "content"=>htmlspecialchars_decode($_GPC['content']),
	        "createtime"=>time(),
	        "weid"=>$uniacid,
	        "cateid"=>2,
	        "type"=>2,
	        "uid"=>$uid,
	        "weid"=>$uniacid,
            "isnew"=>1
	    );
	    $result=pdo_insert("lwxhello_note",$note);

	    //第6个创建的帖子不再最新
        $sql="select id from ".tablename("lwxhello_note")." where isnew=1 and cateid=2  order by createtime desc limit 6 ";
        $po_list1=pdo_fetchall($sql);
        $id1=$po_list1[5]['id'];
        pdo_update("lwxhello_note",array("isnew"=>2),array("id"=>$id1));

	    $sql="select uid from ".tablename("lwxhello_subsribemember")."  where besubuid=:uid";
	    $param=array(":uid"=>$uid);
	     $memberlist=pdo_fetchall($sql,$param);
	     foreach($memberlist as $m){
	         $id=$m['uid'];
	         //查询当前用户的openid 
	         $sql="SELECT openid FROM ims_mc_mapping_fans WHERE uid=:uid";
	         $fans=pdo_fetch($sql,array(":uid"=>$id));
	         $keyword1=$nickname;
	         $keyword2=$nickname;
	         $keyword3=date("Y-m-d H:i:s",time());
	         $postdata=array("first"=>array("value"=>"您好，您的好友发布了一条新的PO图，前往【消息】查看会不会好一点。","color"=>"#743A3A"),
	             "keyword1"=>array("value"=>'Po图',"color"=>"#743A3A"),
	             "keyword2"=>array("value"=>$keyword3,"color"=>"#743A3A"),
	             "remark"=>array("value"=>"","color"=>"#743A3A"));
	         $touser=$fans['openid'];
	         $tpl_id_short="lbFt_5C253ZoaZhi8jMEqKHrPTB3dhNSRaZDRXUkiiI";
	         $account_api = WeAccount::create();
	         $url="";
	         $result=$account_api->sendTplNotice($touser, $tpl_id_short, $postdata, $url =$url, $topcolor = '#FF683F');
	     }
	    echo $result;exit();
	//设置密码    
	}elseif($operation=="set_password"){
	    include $this->template('set_password');
	//帮助反馈    
	}elseif($operation=="set_help"){
	    include $this->template('set_help');
	//意见反馈    
	}elseif($operation=="set_feedback"){
	    //微信接口
	    $value=$_W['account']['jssdkconfig'];
	    $appId= $value['appId'];
	    $nonceStr= $value['nonceStr'];
	    $timestamp =$value['timestamp'];
	    $signature= $value['signature'];
	    include $this->template('set_feedback');
	//添加意见反馈    
	}elseif($operation=="addfeedback"){
	    $content=$_GPC['content'];
	    $contact=$_GPC['contact'];
	 //   $thumb_url=explode(",",$_GPC['thumb_url']);
	    $thumb_url=$_GPC['thumb_url'];
	    $feedback=array("uid"=>$uid,"weid"=>$_W['uniacid'],"content"=>$content,"thumb_url"=>serialize($thumb_url),"contact"=>$contact,"createtime"=>time());
	    $result=pdo_insert("lwxhello_feedback",$feedback);
	    echo $result;exit();
	//我的反馈  数据列表
	}elseif($operation=="myfeedback"){
	    $pindex = max(1, intval($_GPC['page']));//当前页数
	    $psize =5;
	    $type=intval($_GPC['type']);//1.新货反馈表  2.开业满意度评分表  3.店铺设计 4.质量反馈 
	    $condition=' where uid=:uid';
	    $param=array(":uid"=>$uid);
	    $time=intval($_GPC['time']);//1.最近回复 2.最近一月 3.最近三月 4.最近半年
	    if($time>0){
	        switch ($time){
	            case 1:
	                $starttime=strtotime("-15 days");
	                $condition.=" and createtime>=:stime";
	                $param[':stime']=$starttime;
	                break;
	            case 2:
	                $starttime=strtotime("-30 days");
	                $condition.=" and createtime>=:stime";
	                $param[':stime']=$starttime;
	                break;                              
	            case 3:
	                $starttime=strtotime("-90 days");
	                $condition.=" and createtime>=:stime";
	                $param[':stime']=$starttime;
	                break;
	            case 4:
	                $starttime=strtotime("-180 days");
	                $condition.=" and createtime>=:stime";
	                $param[':stime']=$starttime;
	                break;
	        }
	         $condition.=" order by createtime desc ";
	    }else{
	        //默认排序 order by ifreply desc 
	        $condition.=" order by ifreply desc,createtime desc  ";
	    }
	   //默认显示前五条  
	  // $condition.=" limit ". ($pindex - 1) * $psize . ',' . $psize;
	    if($type==1){
	        $sql="select * from ".tablename("lwxhello_newgoods_feedback").$condition;
	        $newgoods_list=pdo_fetchall($sql,$param);
	        foreach($newgoods_list as &$item){
	            $item['createtime']=date("Y-m-d",$item['createtime']);
	            $item['problem']=unserialize($item['problem']);
	            $item['type']=1;
	        }
	        
	        $list=array("type"=>1,"page"=>$pindex,"list"=>$newgoods_list);
	        echo json_encode($list);exit();
	    }elseif($type==2){
	        $sql="select * from ".tablename("lwxhello_opening_feedback").$condition;
	        $opening_list=pdo_fetchall($sql,$param);
	        foreach($opening_list as &$item){
	            $item['createtime']=date("Y-m-d",$item['createtime']);
	            $item['problem']="";
	            $item['type']=2;
	            
	        }
	       /*  if(count($opening_list)==0){
	            $opening_list=array("id"=>"");
	        } */
	      
	        $list=array("type"=>2,"page"=>$pindex,"list"=>$opening_list);
	        echo json_encode($list);exit();
	    }elseif($type==3){

            $sql="select * from ".tablename("lwxhello_shop_feedback").$condition;
            $shop_list=pdo_fetchall($sql,$param);
            foreach($shop_list as &$g){
                $g['type']=3;
                $g['createtime']=date("Y-m-d ",$g['createtime']);
                $g['problem']=unserialize($g['problem']);
            }

	        /*$sql="select * from ".tablename("lwxhello_shop_feedback").$condition;
	        $shop_list=pdo_fetchall($sql,$param);
	        foreach($shop_list as &$item){
	            $item['createtime']=date("Y-m-d ",$item['createtime']);
	            $item['problem']=unserialize($item['problem']);
	            $item['type']=3;
	        }*/
            $list=array("type"=>3,"page"=>$pindex,"list"=>$shop_list);
            echo json_encode($list);exit();
	    }elseif($type==4){
	        $sql="select * from ".tablename("lwxhello_quality_feedback").$condition;
	        $quality_list=pdo_fetchall($sql,$param);
	        foreach($quality_list as &$item){
	            $item['createtime']=date("Y-m-d ",$item['createtime']);
	            $item['problem']=unserialize($item['problem']);
	            $item['type']=4;
	        }
	        $list=array("type"=>4,"page"=>$pindex,"list"=>$quality_list);
	        echo json_encode($list);exit();
	    }else{
	        $sql="select * from ".tablename("lwxhello_newgoods_feedback").$condition;
	        $newgoods_list=pdo_fetchall($sql,$param);
	        foreach($newgoods_list as &$g){
	            $g['type']=1;
	            $g['createtime']=date("Y-m-d ",$g['createtime']);
	            $g['problem']=unserialize($g['problem']);
	        }
	        $sql="select * from ".tablename("lwxhello_opening_feedback").$condition;
	        $opening_list=pdo_fetchall($sql,$param);
	        foreach($opening_list as &$g){
	            $g['type']=2;
	            $g['createtime']=date("Y-m-d ",$g['createtime']);
	            $g['problem']=unserialize($g['problem']);
	        }
	        $sql="select * from ".tablename("lwxhello_shop_feedback").$condition;
	        $shop_list=pdo_fetchall($sql,$param);
	        foreach($shop_list as &$g){
	            $g['type']=3;
	            $g['createtime']=date("Y-m-d ",$g['createtime']);
	            $g['problem']=unserialize($g['problem']);
	        }
	        $sql="select * from ".tablename("lwxhello_quality_feedback").$condition;
	        $quality_list=pdo_fetchall($sql,$param);
	        foreach($quality_list as &$g){
	            $g['type']=4;
	            $g['createtime']=date("Y-m-d",$g['createtime']);
	            $g['problem']=unserialize($g['problem']);
	        }
	       // $list=array("type"=>0,"newgoods"=>$newgoods_list,"opening"=>$opening_list,"shop"=>$shop_list,"quality"=>$quality_list);
	        $alllist=array_merge($newgoods_list,$opening_list,$shop_list,$quality_list);

            $sort = 'SORT_DESC';
            $arrSort = array();
            $field='createtime';
            foreach ($alllist as $uniqid => $row) {
                foreach ($row as $key => $value) {
                    $arrSort[$key][$uniqid] = $value;
                }
            }
            array_multisort($arrSort[$field], constant($sort), $alllist);
            $field1='ifnewreply';
            $sort1 = 'SORT_ASC';
            $arrSort1 = array();
            foreach ($alllist as $uniqid => $row) {
                foreach ($row as $key => $value) {
                    $arrSort1[$key][$uniqid] = $value;
                }
            }
            array_multisort($arrSort1[$field1], constant($sort1), $alllist);

            $list=array("type"=>0,"page"=>$pindex,"list"=>$alllist);
            echo json_encode($list);exit();
	    }
	  //反馈详情页面
	}elseif($operation=="myfeedbackxq")
    {
        $type=intval($_GPC['type']);
        $id=intval($_GPC['id']);
        if($type==1){//新品发布
            $sql="select * from ".tablename("lwxhello_newgoods_feedback")."where id=:id";
            $param=array(":id"=>$id);
            $List=pdo_fetchall($sql,$param);
            if($List[0]['season']==1){$List[0]['season']=='春';}
            elseif($List[0]['season']==2){$List[0]['season']=='夏';}
            elseif($List[0]['season']==3){$List[0]['season']=='秋';}
            elseif($List[0]['season']==4){$List[0]['season']=='冬';}
            $List[0]['problem']=unserialize($List[0]['problem']);
        }
        else if($type==2){//开业满意度
            $sql="select * from ".tablename("lwxhello_opening_feedback")."where id=:id";
            $param=array(":id"=>$id);
            $List=pdo_fetchall($sql,$param);
            if($List[0]['finishtime']==1)
            {$List[0]['finishtime']='装修开业充分';}
            elseif ($List[0]['finishtime']==2)
            {$List[0]['finishtime']='装修开业仓促';}
            elseif ($List[0]['finishtime']==3)
            {$List[0]['finishtime']='开业尚有道具未完成';}

            if($List[0]['peixun']==1)
            {$List[0]['peixun']='全部参加培训';}
            elseif ($List[0]['peixun']==2)
            {$List[0]['peixun']='50%以上参加培训';}
            elseif ($List[0]['peixun']==3)
            {$List[0]['peixun']='50%以下参加培训';}

            if($List[0]['cuxiao']==0)
            {$List[0]['cuxiao']='开业前一周到';}
            elseif ($List[0]['cuxiao']==1)
            {$List[0]['cuxiao']='开业前3天到';}
            elseif ($List[0]['cuxiao']==2)
            {$List[0]['cuxiao']='开业前1天到';}
            elseif ($List[0]['cuxiao']==3)
            {$List[0]['cuxiao']='开业当日或以后到';}

            if($List[0]['huopin']==0)
            {$List[0]['huopin']='公司配发';}
            elseif ($List[0]['huopin']==1)
            {$List[0]['huopin']='选货与公司推荐结合';}
            elseif ($List[0]['huopin']==2)
            {$List[0]['huopin']='自主选货';}

            if($List[0]['sdhp']==0)
            {$List[0]['sdhp']='与订货吻合';}
            elseif ($List[0]['sdhp']==1)
            {$List[0]['sdhp']='款式缺少';}
            elseif ($List[0]['sdhp']==2)
            {$List[0]['sdhp']='断色断码';}

            if($List[0]['hpwzx']==0)
            {$List[0]['hpwzx']='上下内外多种搭配';}
            elseif ($List[0]['hpwzx']==1)
            {$List[0]['hpwzx']='上下内外搭配单';}
            elseif ($List[0]['hpwzx']==2)
            {$List[0]['hpwzx']='上下内外无法搭配';}

            if($List[0]['hpclxg']==0)
            {$List[0]['hpclxg']='色系丰满视觉效果好';}
            elseif ($List[0]['hpclxg']==1)
            {$List[0]['hpclxg']='色系丰满视觉效果一般';}
            elseif ($List[0]['hpclxg']==2)
            {$List[0]['hpclxg']='色系丰满视觉效果差';}

            if($List[0]['jlbx']==0)
            {$List[0]['jlbx']='主动带领店铺员工布场';}
            elseif ($List[0]['jlbx']==1)
            {$List[0]['jlbx']='在一旁观看店铺员工布场';}
            elseif ($List[0]['jlbx']==2)
            {$List[0]['jlbx']='未参加布场';}

            if($List[0]['jlclzd']==0)
            {$List[0]['jlclzd']='多次讲解并与店员共同模拟实验';}
            elseif ($List[0]['jlclzd']==1)
            {$List[0]['jlclzd']='简单讲解和示范';}
            elseif ($List[0]['jlclzd']==2)
            {$List[0]['jlclzd']='口头讲解未现场示范';}

            if($List[0]['jlfwzd']==0)
            {$List[0]['jlfwzd']='示范并参与售卖';}
            elseif ($List[0]['jlfwzd']==1)
            {$List[0]['jlfwzd']='示范未参与售卖';}
            elseif ($List[0]['jlfwzd']==2)
            {$List[0]['jlfwzd']='口头指导';}

            if($List[0]['dpbhzd']==0)
            {$List[0]['dpbhzd']='根据销售与店长讨论制定出货补货规范';}
            elseif ($List[0]['dpbhzd']==1)
            {$List[0]['dpbhzd']='简单说明';}
            elseif ($List[0]['dpbhzd']==2)
            {$List[0]['dpbhzd']='简单口头指导';}
            elseif ($List[0]['dpbhzd']==3)
            {$List[0]['dpbhzd']='未进行指导';}

            if($List[0]['dpglzd']==0)
            {$List[0]['dpglzd']='为店铺制定适度的管理制度';}
            elseif ($List[0]['dpglzd']==1)
            {$List[0]['dpglzd']='举例说明';}
            elseif ($List[0]['dpglzd']==2)
            {$List[0]['dpglzd']='简单口头指导';}
            elseif ($List[0]['dpglzd']==3)
            {$List[0]['dpglzd']='未进行指导';}

        }
        else if($type==3){
            $sql="select * from ".tablename("lwxhello_shop_feedback")."where id=:id";
            $param=array(":id"=>$id);
            $List=pdo_fetchall($sql,$param);

        }
        else if($type==4){
            $sql="select * from ".tablename("lwxhello_quality_feedback")."where id=:id";
            $param=array(":id"=>$id);
            $List=pdo_fetchall($sql,$param);
            $List[0]['problem']=unserialize($List[0]['problem']);
        }

        $List[0]['createtime']=date('Y-m-d', $List[0]['createtime']);
        include $this->template('table_about');
        //关于hello汀
    }elseif($operation=="about_hello")
    {
        include $this->template('about_hello');
    }
    //他人页面
	elseif($operation=="other"){
	    $id=intval($_GPC['id']); 
	    //头像 昵称 个性签名     
	    $sql="select m1.nickname,m1.avatar,m2.description from ".tablename("mc_members")
	    ." m1 left join ".tablename("lwxhello_member")." m2 on m1.uid=m2.uid
	        where m2.uid=:uid";
	    $member=pdo_fetch($sql,array(":uid"=>$id));
	    if($id==1)
        {
            $member['avatar']="../addons/lwx_helloting/template/mobile/public/images/logo.png";
            $member['nickname']="朗文斯汀";
            $member['description']="不同的城市，相同的朗文斯汀";
        }
	    //是否关注
	    $sql="select id from ".tablename("lwxhello_subsribemember")." where uid=:uid and besubuid=:buid";
	    $param=array(":uid"=>$uid,":buid"=>$id);
	    $subInfo=pdo_fetch($sql,$param);
	    if($subInfo){
	        $ifsub=1;
	    }else{
	        $ifsub=2;
	    }
	    //原创 收藏 关注
	    $sql="select * from ".tablename("lwxhello_note")." where uid=:uid order by id desc ";
	    $param=array(":uid"=>$id);
	    $originalList=pdo_fetchall($sql,$param);
	    foreach($originalList as &$originals){
	        $originals['thumb_url']=unserialize($originals['thumb_url']);
	    }
	    
	    $sql="select c.createtime,n.title,n.id nid,m2.description,m.avatar,m.nickname from ".tablename("lwxhello_note")." n
	        left join ".tablename("lwxhello_notecollect")
	        ." c  on n.id=c.noteid  left join ".tablename("mc_members")." m
	    	            on m.uid=n.uid  left join ".tablename("lwxhello_member")." m2 on m.uid=m2.uid
	         where c.uid=:uid";
	    $param=array(":uid"=>$id);
	    $collectList=pdo_fetchall($sql,$param);
	    $sql="select  m.id mid,m.uid muid,member.uid,member.nickname,member.avatar,m.description from ".tablename("lwxhello_subsribemember")."
	         sub left join  ".tablename("mc_members")." member on sub.besubuid=member.uid
	             left join  ".tablename("lwxhello_member")." m on  sub.besubuid=m.uid where  sub.uid=:uid group by sub.besubuid order by sub.createtime desc";
	    $param=array(":uid"=>$id);
	    $likeList=pdo_fetchall($sql,$param);
	    //朗文斯汀头像
	    foreach($likeList as &$l){
	        if($l['uid']==1){
	            $l['avatar']="../addons/lwx_helloting/template/mobile/public/images/logo.png";
	            $l['nickname']="朗文斯汀";
	            $l['description']="不同的城市，相同的朗文斯汀";
	        }
	    }
	    include $this->template('others');
	}elseif($operation=="test"){
	    $time=time();
	    echo date("m-d",$time);
	    
	}
 ?>