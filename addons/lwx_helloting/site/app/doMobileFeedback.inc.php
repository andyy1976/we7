<?php 

	global $_W, $_GPC;
	$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
	$uniacid=$_W['uniacid'];
	$uid=$this->getuid();
   /* $sqluid="select id from ".tablename("lwxhello_member")." where uid=:uid and contact!=''";
    $paramuid=array(":uid"=>$uid);
    $likeuid=pdo_fetch($sqluid,$paramuid);
    if(empty($likeuid)){
        include $this->template('login');
    }*/

	//粉丝数据
	$followstatus=$this->getfollowstatus();
	$nickname=$_W['fans']['nickname'];
	$avatar=$_W['fans']['avatar'];
	if($operation=='display'){
			//微信接口
		$value=$_W['account']['jssdkconfig'];
		$appId= $value['appId'];
		$nonceStr= $value['nonceStr'];
		$timestamp =$value['timestamp'];
		$signature= $value['signature'];
		 //echo $_W['uniacid'];
        //if($_SESSION['auid']!='') {
        $sqluid="select id from ".tablename("lwxhello_member")." where uid=:uid and contact!=''";
        $paramuid=array(":uid"=>$uid);
        $likeuid=pdo_fetch($sqluid,$paramuid);
        if(empty($likeuid)){
            include $this->template('login');
        }else
        {
            //幻灯片列表
            $sql = "SELECT * FROM " . tablename('lwxhello_adv') . " WHERE weid = '{$_W['uniacid']}' and state = 1 ORDER BY id DESC";
            //$sql="SELECT * FROM " . tablename('lwxhello_adv') . " WHERE state = 1 ORDER BY id DESC";
            $advlist = pdo_fetchall($sql);
            //研究所  一级分类
            $sql = "select * from " . tablename("lwxhello_theme") . " where parentid=0 and isshow=0 ORDER BY parentid ASC, displayorder DESC";
            $themelist = pdo_fetchall($sql);
            //查询分类是否有下级
            foreach ($themelist as &$the) {
                $sql = "select id from " . tablename("lwxhello_theme") . " where parentid=:pid";
                $param = array(":pid" => $the['id']);
                $themeInfo = pdo_fetch($sql, $param);
                if ($themeInfo) {
                    $the['havachid'] = 1;
                } else {
                    $the['havachid'] = 0;
                }

            }
            //研究所列表 catename
            /* $sql="select * from ".tablename("lwxhello_note")."
                 where cateid=4 or cateid=5 order by id desc ";
            $yjs_list=pdo_fetchall($sql);
            foreach($yjs_list as &$y){
                   $y['thumb_url']=array();
                    $y['thumb_url'][0]=$y['thumb'];
                    //是否点赞
                    //当前用户是否点赞
                    $sql="select id from ".tablename("lwxhello_notelike")." where noteid=:nid and uid=:uid";
                    $param=array(":nid"=>$y['id'],":uid"=>$uid);
                    $like=pdo_fetch($sql,$param);
                    if(empty($like)){
                        $iflike=2;//未点赞
                    }else{
                        $iflike=1;//已点赞
                    }
                    $y['iflike']=$iflike;
            } */

            //推荐--jstj=1
            //$sql="select * from ".tablename("lwxhello_note")." where (isnew=1 or ishot=1 or jstj=1) and ifpb=1 and (cateid=2 or cateid=3) order by createtime desc limit 10 ";
            $sql = "select n.title,n.id,n.thumb_url,n.createtime,n.likeno,n.commentno,n.ishot,n.isnew,n.cateid,n.type,n.uid,n.collectno,n.thumb,n.readno,n.jstj,n.ifpb,m.nickname from " . tablename("lwxhello_note") . " n 
		     left join " . tablename("mc_members") . " m on n.uid=m.uid
		          where (n.isnew=1 or n.ishot=1 or n.jstj=1) and (n.ifpb<2 or n.ifpb>2) and (n.cateid=2 or n.cateid=3)
		    order by n.createtime desc limit 0,5 ";
            $tj_list = pdo_fetchall($sql);
            foreach ($tj_list as &$yjs) {
                if ($yjs['cateid'] == 2)//如果是po图，图片是在we7
                {
                    //获取用户名
                    $userid = $yjs['uid'];
                    $sql = "select description from " . tablename("lwxhello_member") . " where uid=:uid";
                    $param = array(":uid" => $userid);
                    $member = pdo_fetch($sql, $param);
                    $yjs['username'] = $member['description'];

                    $yjs['thumb_url'] = unserialize($yjs['thumb_url']);
                    if ($yjs['thumb_url'][0] != "") {
                        $yjs['thumb_url'][0] = "../attachment/lwx_helloting/" . $yjs['thumb_url'][0];
                        $yjs['thumb'] = $yjs['thumb_url'][0];
                    } else {
                        $yjs['thumb'] = "../addons/lwx_helloting/template/mobile/public/images/common_icon_picture.png";
                    }
                } else //后台发布
                {
                    if ($yjs['thumb'] != '') {
                        $yjs['thumb'] = "http://h5.lwest.cn/hellot_admin/thinkphp3/Public/uploads/" . $yjs['thumb'];
                    } else {
                        $yjs['thumb'] = "../addons/lwx_helloting/template/mobile/public/images/common_icon_picture.png";
                    }
                }


                //当前用户是否点赞
                $sql = "select id from " . tablename("lwxhello_notelike") . " where noteid=:nid and uid=:uid";
                $param = array(":nid" => $yjs['id'], ":uid" => $uid);
                $like = pdo_fetch($sql, $param);
                if (empty($like)) {
                    $iflike = 2;//未点赞
                } else {
                    $iflike = 1;//已点赞
                }
                $yjs['iflike'] = $iflike;

            }
            //PO图
            $sql = "select n.title,n.id,n.thumb_url,n.createtime,n.likeno,n.commentno,n.ishot,n.isnew,n.cateid,n.type,n.uid,n.collectno,n.thumb,n.readno,n.jstj,n.ifpb,m.nickname from " . tablename("lwxhello_note") . " n 
		     left join " . tablename("mc_members") . " m on n.uid=m.uid
		          where n.cateid=2 and n.ifpb=1
		    order by n.id desc limit 0,5";
            $po_list = pdo_fetchall($sql);
            foreach ($po_list as &$yjs) {
                if (intval($yjs['uid']) == 0) {//后台添加显示封面图
                    $yjs['thumb_url'][0] = $yjs['thumb'];
                } else {//用户发布显示列表吐
                    $yjs['thumb_url'] = unserialize($yjs['thumb_url']);
                    if ($yjs['thumb_url'][0] != "") {
                        $yjs['thumb_url'][0] = "lwx_helloting/" . $yjs['thumb_url'][0];
                    }

                }

                //当前用户是否点赞
                $sql = "select id from " . tablename("lwxhello_notelike") . " where noteid=:nid and uid=:uid";
                $param = array(":nid" => $yjs['id'], ":uid" => $uid);
                $like = pdo_fetch($sql, $param);
                if (empty($like)) {
                    $iflike = 2;//未点赞
                } else {
                    $iflike = 1;//已点赞
                }
                $yjs['iflike'] = $iflike;

//                // echo $yjs['iflike'];
//                print_r('<pre>');
//                print_r($param);
//                print_r('</pre>');
            }
            //时髦开箱
            $sql = "select title,id,thumb_url,createtime,likeno,commentno,ishot,isnew,cateid,type,uid,collectno,thumb,readno,jstj,ifpb from " . tablename("lwxhello_note") . " where cateid=3 order by id desc limit 0,5";
            $box_list = pdo_fetchall($sql);
            foreach ($box_list as &$yjs) {
                // $yjs['thumb_url']=unserialize($yjs['thumb_url']);
                $yjs['thumb_url'][0] = $yjs['thumb'];
                //当前用户是否点赞
                $sql = "select id from " . tablename("lwxhello_notelike") . " where noteid=:nid and uid=:uid";
                $param = array(":nid" => $yjs['id'], ":uid" => $uid);
                $like = pdo_fetch($sql, $param);
                if (empty($like)) {
                    $iflike = 2;//未点赞
                } else {
                    $iflike = 1;//已点赞
                }
                $yjs['iflike'] = $iflike;


            }
            //直播间
            $sql = "select title,id,thumb_url,createtime,likeno,commentno,ishot,isnew,cateid,type,uid,collectno,thumb,readno,jstj,ifpb from " . tablename("lwxhello_note") . " where cateid=6 order by id desc limit 0,5";
            $play_list = pdo_fetchall($sql);
            foreach ($play_list as &$yjs) {
                $yjs['thumb_url'] = unserialize($yjs['thumb_url']);

                //当前用户是否点赞
                $sql = "select id from " . tablename("lwxhello_notelike") . " where noteid=:nid and uid=:uid";
                $param = array(":nid" => $yjs['id'], ":uid" => $uid);
                $like = pdo_fetch($sql, $param);
                if (empty($like)) {
                    $iflike = 2;//未点赞
                } else {
                    $iflike = 1;//已点赞
                }
                $yjs['iflike'] = $iflike;
            }
       /* print_r('<pre>');
            print_r($tj_list);
        print_r('</pre>');*/
            include $this->template('index');
        }
       /* }
        else
        {
            include $this->template('login');
        }*/
    /*下拉刷新读取五条数据
     * $type :刷新的类型（1.推荐 2.po图 3.开箱 4.直播间）
     * $page :从第几行开始读取数据
     * */
    }elseif($operation=="nextf5"){
	    $type=$_GPC['type'];
        $page=$_GPC['page']*5;

        if($type==1)
        {
            //推荐--jstj=1
            //$sql="select * from ".tablename("lwxhello_note")." where (isnew=1 or ishot=1 or jstj=1) and ifpb=1 and (cateid=2 or cateid=3) order by createtime desc limit 10 ";
            $sql = "select n.title,n.id,n.thumb_url,n.createtime,n.likeno,n.commentno,n.ishot,n.isnew,n.cateid,n.type,n.uid,n.collectno,n.thumb,n.readno,n.jstj,n.ifpb,m.nickname from " . tablename("lwxhello_note") . " n 
		     left join " . tablename("mc_members") . " m on n.uid=m.uid
		          where (n.isnew=1 or n.ishot=1 or n.jstj=1) and (n.ifpb<2 or n.ifpb>2) and (n.cateid=2 or n.cateid=3)
		    order by n.createtime desc limit $page,5 ";
            $tj_list = pdo_fetchall($sql);
            foreach ($tj_list as &$yjs) {
                if ($yjs['cateid'] == 2)//如果是po图，图片是在we7
                {
                    //获取用户名
                    $userid = $yjs['uid'];
                    $sql = "select description from " . tablename("lwxhello_member") . " where uid=:uid";
                    $param = array(":uid" => $userid);
                    $member = pdo_fetch($sql, $param);
                    $yjs['username'] = $member['description'];

                    $yjs['thumb_url'] = unserialize($yjs['thumb_url']);
                    if ($yjs['thumb_url'][0] != "") {
                        $yjs['thumb_url'][0] = "../attachment/lwx_helloting/" . $yjs['thumb_url'][0];
                        $yjs['thumb'] = $yjs['thumb_url'][0];
                    } else {
                        $yjs['thumb'] = "../addons/lwx_helloting/template/mobile/public/images/common_icon_picture.png";
                    }
                } else //后台发布
                {
                    if ($yjs['thumb'] != '') {
                        $yjs['thumb'] = "http://h5.lwest.cn/hellot_admin/thinkphp3/Public/uploads/" . $yjs['thumb'];
                    } else {
                        $yjs['thumb'] = "../addons/lwx_helloting/template/mobile/public/images/common_icon_picture.png";
                    }
                }


                //当前用户是否点赞
                $sql = "select id from " . tablename("lwxhello_notelike") . " where noteid=:nid and uid=:uid";
                $param = array(":nid" => $yjs['id'], ":uid" => $uid);
                $like = pdo_fetch($sql, $param);
                if (empty($like)) {
                    $iflike = 2;//未点赞
                } else {
                    $iflike = 1;//已点赞
                }
                $yjs['iflike'] = $iflike;

            }
            /*print_r('<pre>');
            print_r($tj_list);
            print_r('</pre>');*/
            echo json_encode($tj_list);
        }
        elseif ($type==2)
        {//PO图

            $sql = "select n.title,n.id,n.thumb_url,n.createtime,n.likeno,n.commentno,n.ishot,n.isnew,n.cateid,n.type,n.uid,n.collectno,n.thumb,n.readno,n.jstj,n.ifpb,m.nickname from " . tablename("lwxhello_note") . " n 
		     left join " . tablename("mc_members") . " m on n.uid=m.uid
		          where n.cateid=2 and n.ifpb=1
		    order by n.id desc limit $page,5";
            $po_list = pdo_fetchall($sql);
            foreach ($po_list as &$yjs) {
                if (intval($yjs['uid']) == 0) {//后台添加显示封面图
                    $yjs['thumb_url'][0] = $yjs['thumb'];
                } else {//用户发布显示列表吐
                    $yjs['thumb_url'] = unserialize($yjs['thumb_url']);
                    if ($yjs['thumb_url'][0] != "") {
                        $yjs['thumb_url'][0] = "lwx_helloting/" . $yjs['thumb_url'][0];
                    }

                }

                //当前用户是否点赞
                $sql = "select id from " . tablename("lwxhello_notelike") . " where noteid=:nid and uid=:uid";
                $param = array(":nid" => $yjs['id'], ":uid" => $uid);
                $like = pdo_fetch($sql, $param);
                if (empty($like)) {
                    $iflike = 2;//未点赞
                } else {
                    $iflike = 1;//已点赞
                }
                $yjs['iflike'] = $iflike;

                // echo $yjs['iflike'];
            }
            //print_r($po_list);
            echo json_encode($po_list);
        }
        elseif ($type==3)
        {
            //时髦开箱
            $sql = "select title,id,thumb_url,createtime,likeno,commentno,ishot,isnew,cateid,type,uid,collectno,thumb,readno,jstj,ifpb from " . tablename("lwxhello_note") . " where cateid=3 order by id desc limit $page,5";
            $box_list = pdo_fetchall($sql);
            foreach ($box_list as &$yjs) {
                // $yjs['thumb_url']=unserialize($yjs['thumb_url']);
                $yjs['thumb_url'][0] = $yjs['thumb'];
                //当前用户是否点赞
                $sql = "select id from " . tablename("lwxhello_notelike") . " where noteid=:nid and uid=:uid";
                $param = array(":nid" => $yjs['id'], ":uid" => $uid);
                $like = pdo_fetch($sql, $param);
                if (empty($like)) {
                    $iflike = 2;//未点赞
                } else {
                    $iflike = 1;//已点赞
                }
                $yjs['iflike'] = $iflike;
            }
           // print_r($box_list);
            echo json_encode($box_list);
        }
        elseif ($type==4)
        {
            //直播间
            $sql = "select title,id,thumb_url,createtime,likeno,commentno,ishot,isnew,cateid,type,uid,collectno,thumb,readno,jstj,ifpb from " . tablename("lwxhello_note") . " where cateid=6 order by id desc limit $page,5";
            $play_list = pdo_fetchall($sql);
            foreach ($play_list as &$yjs) {
                $yjs['thumb_url'] = unserialize($yjs['thumb_url']);

                //当前用户是否点赞
                $sql = "select id from " . tablename("lwxhello_notelike") . " where noteid=:nid and uid=:uid";
                $param = array(":nid" => $yjs['id'], ":uid" => $uid);
                $like = pdo_fetch($sql, $param);
                if (empty($like)) {
                    $iflike = 2;//未点赞
                } else {
                    $iflike = 1;//已点赞
                }
                $yjs['iflike'] = $iflike;
            }
            //print_r($play_list);
            echo json_encode($play_list);
        }

	 //研究所列表。。。 train	
	}elseif($operation=="train"){
	    $id=intval($_GPC['id']);
	    $type="ccate";
	    //查询所有二级分类
	    $sql="select * from ".tablename("lwxhello_theme")." where parentid=:pid and isshow=0 order by displayorder desc ,id desc";
	    $param=array(":pid"=>$id);
	    $themelist=pdo_fetchall($sql,$param);
	    include $this->template('train');
	}elseif($operation=="train_detail"){  
	    $id=intval($_GPC['id']);
	    $note=pdo_fetch("select * from ".tablename("lwxhello_note")." where id=:id",array(":id"=>$id));
	    //当前用户是否点赞
	    $sql="select id from ".tablename("lwxhello_notelike")." where noteid=:nid and uid=:uid";
	    $param=array(":nid"=>$id,":uid"=>$uid);
	    $like=pdo_fetch($sql,$param);
	    if(empty($like)){
	        $iflike=2;//未点赞
	    }else{
	        $iflike=1;//已点赞
	    }
	    //当前用户是否已经阅读 未阅读 添加阅读量
	    $sql="select id from ".tablename("lwxhello_noteread")." where nid=:nid and uid=:uid";
	    $param=array(":nid"=>$id,":uid"=>$uid);
	    $read=pdo_fetch($sql,$param);
	    if(empty($read)){
	        //没有阅读，添加阅读
	        $result=pdo_insert("lwxhello_noteread",array("nid"=>$id,"uid"=>$uid));
	        $readno=intval($note['readno'])+1;
	        $result=pdo_update("lwxhello_note",array("readno"=>$readno),array("id"=>$id));
	    }
	    
	    //当前用户是否收藏
	    $sql="select id from ".tablename("lwxhello_notecollect")." where noteid=:nid and uid=:uid";
	    $param=array(":nid"=>$id,":uid"=>$uid);
	    $collect=pdo_fetch($sql,$param);
	    if(empty($collect)){
	        $ifcollect=2;//未收藏
	    }else{
	        $ifcollect=1;//已收藏
	    }
	     
	    //该帖子的评论列表
	    $sql="select c.*,m.nickname,m.avatar from ".tablename("lwxhello_notecomment")." c
	        left join ".tablename("mc_members")." m  on c.uid=m.uid where c.noteid=:nid order by c.id desc limit 5";
	    $param=array(":nid"=>$id);
	    $commentlist=pdo_fetchall($sql,$param);
	    
	    include $this->template('train_detail');
	 //培训手册专题列表   
	}elseif($operation=="train_list"){
	    $title="培训列表";
	    //专题id
	    $id=intval($_GPC['id']);
	    $type=$_GPC['type'];
	    $sql="select note.id,note.cateid,note.readno,note.title,note.thumb from ".tablename("lwxhello_note")." note
	           where  note.$type=:id and (note.cateid=4  or note.cateid=5)";
	    $param=array(":id"=>$id);
	    $notelist=pdo_fetchall($sql,$param);
	    include $this->template('train_list');
	}elseif($operation=='editfeedback'){
		$value=$_W['account']['jssdkconfig'];
		$appId= $value['appId'];
		$nonceStr= $value['nonceStr'];
		$timestamp =$value['timestamp'];
		$signature= $value['signature'];
		$type=$_GPC['type'];
    	include $this->template('editfeedback');
	}elseif($operation=='myTing'){
		include $this->template('myTing');
	}elseif($operation=='myTing_newgoods'){
		include $this->template('myTing_newgoods');
	//我	
	}elseif($operation=='me'){
	    $sql="select description from ".tablename("lwxhello_member")." where uid=:uid";
	    $param=array(":uid"=>$uid);
	    $member=pdo_fetch($sql,$param);
		include $this->template('me');
	//我的消息	
	}elseif($operation=='message'){
	    //查询我的消息
	    $sql="select member.nickname,member.uid,member.avatar,message.type from ".tablename("lwxhello_message")." message 
	        left join ".tablename("mc_members")." member on message.uid=member.uid where message.beuid=:uid order by message.createtime desc";
	    $param=array(":uid"=>$uid);
	    $messageList=pdo_fetchall($sql,$param);
	    //评论了我
	    $sql="select message.createtime,member.nickname,member.avatar,comment.content,comment.noteid from ".tablename("lwxhello_message")." message
	        left join ".tablename("mc_members")." member on message.uid=member.uid 
            left join ".tablename("lwxhello_notecomment")." comment on message.commentid=comment.id 
	        where message.beuid=:uid and message.type=5 order by message.createtime desc";
	    $param=array(":uid"=>$uid);
	    $commentlist=pdo_fetchall($sql,$param);
	    //发现--我关注的好友发的帖子  今天的前三条
	    $sql="SELECT besubuid FROM ims_lwxhello_subsribemember WHERE uid=:uid order by createtime desc";
	    $param=array(":uid"=>$uid);
	    $memberlist=pdo_fetchall($sql,$param);
	    //发现列表
	    $sql="SELECT besubuid FROM ims_lwxhello_subsribemember WHERE uid=:uid order by createtime desc";
	    $param=array(":uid"=>$uid);
	    $memberlist=pdo_fetchall($sql,$param);
	    $notelist=array();
  	    foreach($memberlist as $m){
	        $mid=$m['besubuid'];
	        $sql="select note.createtime,note.id,note.title,member.avatar from ".tablename("lwxhello_note")."
	            note left join ".tablename("mc_members")." member on note.uid=member.uid 
	                 where note.uid=:uid order by note.createtime desc";
	        $param=array(":uid"=>$mid);
	        $note=pdo_fetchall($sql,$param);
	        foreach($note as $n){
	            $notelist[]=$n;
	        }
	       
	    } 
	    
		include $this->template('message');
	}elseif($operation=='myTing_feedback'){
		$value=$_W['account']['jssdkconfig'];
		$appId= $value['appId'];
		$nonceStr= $value['nonceStr'];
		$timestamp =$value['timestamp'];
		$signature= $value['signature'];
		include $this->template('myTing_feedback');
	}elseif($operation=='myTing_opening'){
		include $this->template('myTing_opening');
	}elseif($operation=='myTing_shop'){
		include $this->template('myTing_shop');
	//发布	
	}elseif($operation=='publish'){
	    //微信接口
	    $value=$_W['account']['jssdkconfig'];
	    $appId= $value['appId'];
	    $timestamp =$value['timestamp'];
        $nonceStr= $value['nonceStr'];
	    $signature= $value['signature'];
        include $this->template('publish');

	//新货反馈表	
	}elseif($operation=='feedbackpost'){
		$data['year']=$_GPC['year'];
		$data['season']=$_GPC['season'];
		$data['quality']=$_GPC['quality'];
		$data['style']=$_GPC['style'];
		$data['status']=$_GPC['status'];
		$problem=$_GPC['problem'];
		$data['problem']=serialize($problem);
		$data['uid']=$uid;
		$data['createtime']=time();
		$data['weid']=$_W['uniacid'];
		pdo_insert("lwxhello_newgoods_feedback",$data);
		echo 1;exit();
	}
    elseif($operation=='opening1'){
        include $this->template('opening1');
    }
    elseif($operation=='opening2'){
        include $this->template('opening2');
    }
    elseif($operation=='opening3'){
        include $this->template('opening3');
    }
    elseif($operation=='opening4'){
        include $this->template('opening4');
    }
    elseif($operation=='opening5'){
        include $this->template('opening5');
    }
    elseif($operation=='opening6'){
        include $this->template('opening6');
    }
	//开业满意度评分表
    elseif($operation=='opening_feedback'){
        function decodeUnicode($str){
            return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', create_function('$matches', 'return iconv("UCS-2BE","UTF-8",pack("H*", $matches[1]));'), $str);
        }
        $e=$_GPC['e'];
        $a=explode(',',json_encode($e));
        $data['shopname']=substr(decodeUnicode($a[0]),1);//店铺名字
        $data['opentime']=$a[4];//开业时间
        $data['fuzename']=decodeUnicode($a[1]);//负责人姓名
        $data['dzname']=decodeUnicode($a[2]);//店长姓名
        $data['shopphone']=$a[3];//店铺电话
        $data['finishtime']=$a[5];//完成时间 1充分 2仓促 3未完成
        $data['finishtimescore']=$a[6];//完成时间打分 1-10分
        $data['peixun']=$a[7];//培训状态（0全部参加培训 50以上参加培训 50以下参加培训）
        $data['peixunscore']=$a[8];//人员培训打分（1-10分）
        $data['cuxiaohd']=decodeUnicode($a[9]);//采纳的促销活动（填写）
        $data['cuxiaolp']=decodeUnicode($a[10]);//促销礼品（填写）
        $data['cuxiao']=$a[11];//促销活动状态（0开业前一周到 1前三天到 2前一天到 3当日或以后到）
        $data['cuxiaoscore']=$a[12];//促销活动打分（1-10分）
        $data['huopin']=$a[13];//货品状态（0公司配发 1选货与公司推荐结合 2自主选货）
        $data['sdhp']=$a[14];//收到货品状态（0与订货吻合 1款式缺少 2断色断码）
        $data['hpwzx']=$a[15];//货品完整性（0上下内外多种搭配 1上下内外搭配单 2上下内外无法搭配）
        $data['hpclxg']=$a[16];//货品陈列效果（0色系丰满视觉效果好 1效果一般 2效果差）
        $data['hpqkscore']=$a[17];//货品情况打分（1-10分）
        $data['jlbx']=$a[18];//经理表现状态（0主动带领店铺员工布场 1一旁观看 2未参加）
        $data['jlbxscore']=$a[19];//经理表现打分 （1-10分）
        $data['jlcljj']=$a[20];//经理陈列讲解（0多次讲解 1简单讲解 2口头讲解）
        $data['jlfwzd']=$a[21];//经理服务指导（0示范售卖 1示范不售卖 2口头指导）
        $data['dpbhzd']=$a[22];//店铺补货指导（0制定补货 1简单说明 2简单口头 3未指导）
        $data['dpglzd']=$a[23];//店铺管理指导(0适度制度 1距离说明 2简单口头 3未指导 )


        /*$a=$_GPC['a'];
        $b=$_GPC['b'];
        $c=$_GPC['c'];
        $d=$_GPC['d'];*/
        /*$a=array();
        $stu=$_GPC['student'];
        $a=json_encode($stu);*/

        //$e=$_GPC['e'];

        //echo json_encode($e);
		$data['uid']=$uid;
		$data['createtime']=time();
		$data['weid']=$_W['uniacid'];
		pdo_insert("lwxhello_opening_feedback",$data);
		echo 1;exit();
	//质量反馈	
	}elseif($operation=='quality_feedback'){
		$problem=$_GPC['problem'];
		$data['problem']=serialize($problem);
		$data['uid']=$uid;
		$data['createtime']=time();
		$data['weid']=$_W['uniacid'];
		pdo_insert("lwxhello_quality_feedback",$data);
		echo 1;exit();
	}elseif($operation=='uploadimg'){
		$account_api = WeAccount::create();
        $value=$_W['account']['jssdkconfig'];
        $token = $account_api->getAccessToken();
        $media_id = $_GPC['media_id'];
		//$url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token={$token}&type=image&media_id={$media_id}";
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$token."&type=image&media_id=".$media_id."";
        $fileInfo = $this->downloadWeixinFile($url);
        date_default_timezone_set('PRC');  //设置默认时区
        $imgname=date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999);
        $filename = $imgname.".jpg";
		$this->saveWeixinFile($filename, $fileInfo["body"]);
        //压缩图片
        $img_info = filesize("../attachment/lwx_helloting/".$imgname.".jpg");
        if($img_info>1048576)
        {
            $size=0.4;
        }
        else
        {$size=0.6;
        }
        $filename1 = "../attachment/lwx_helloting/".$imgname.".jpg";
        $newfilename1="../attachment/lwx_helloting/".$imgname."s.jpg";
        $this->ResizeImage($filename1,$size,'jpeg',$newfilename1);
        $newfilename=$imgname."s.jpg";
        //echo $token;
        echo $newfilename;exit();
	//店铺设置道具满意度评分表	
	}elseif($operation=='shop_feedback'){
		/*$data['shopname']=$_GPC['shopname'];
		$data['opentime']=$_GPC['opening'];
		$data['quality']=$_GPC['quality'];
		$data['style']=$_GPC['style'];
		$data['status']=$_GPC['status'];
		$problem=$_GPC['problem'];
		$data['problem']=serialize($problem);*/
        function decodeUnicode($str){
            return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', create_function('$matches', 'return iconv("UCS-2BE","UTF-8",pack("H*", $matches[1]));'), $str);
        }
        $e=$_GPC['e'];
        $a=explode(',',json_encode($e));
        $data['shopname']=substr(decodeUnicode($a[0]),1);//店铺名字
        $data['area']=decodeUnicode($a[1]);//面积
        $data['manager']=decodeUnicode($a[2]);//区域经理
        $data['designer']=decodeUnicode($a[3]);//设计师
        $data['dxbj']=$a[4];//动线布局合理（1-10分）
        $data['ghl']=$a[5];//挂货量是否合理（1-10分）
        $data['xgt']=$a[6];//效果图是否完整（1-10分）
        $data['sgt']=$a[7];//施工图是否完整（1-10分）
        $data['djqd']=$a[8];//道具清单是否完整（1-10分）
        $data['tzsj']=$a[9];//图纸设计是否及时  （0否 1是）
        $data['djfh']=$a[10];//道具发货是否及时  （0否 1是）
        $data['sjsfw']=$a[11];//设计师服务满意度（1-10分）
        $data['gcjlfw']=$a[12];//工程监理服务满意度（1-10分）
        $data['jysm']=decodeUnicode($a[13]);//建议说明

		$data['uid']=$uid;
		$data['createtime']=time();
		$data['weid']=$_W['uniacid'];
		$res=pdo_insert("lwxhello_shop_feedback",$data);
		if($res)
        {
            echo 1;exit();
        }else{
            echo 2;exit();
        }
		//echo json_encode($a[0]);
	}elseif($operation=="test"){
	    $sql="SELECT besubuid FROM ims_lwxhello_subsribemember WHERE uid=:uid";
	    $param=array(":uid"=>$uid);
	    $memberlist=pdo_fetchall($sql,$param);
	    $notelist=array();
	    foreach($memberlist as $m){
	        $mid=$m['besubuid'];
	        $sql="select id,title from ".tablename("lwxhello_note")." where uid=:uid";
	        $param=array(":uid"=>$mid);
	        $note=pdo_fetchall($sql,$param);
	        $notelist[]=$note;
	    }
	}
elseif($operation=='login'){
    if($_SESSION['auid']!='')
    {
        $sql="select description from ".tablename("lwxhello_member")." where uid=:uid";
        $param=array(":uid"=>$uid);
        $member=pdo_fetch($sql,$param);
        include $this->template('me');
    }
    else{
        include $this->template('login');
    }
    //include $this->template('login');
}
//获取手机验证码
elseif($operation=="logingetcode"){
    $tel = $_GPC['tel'];
    $userInfo=pdo_fetch("select id from ".tablename("lwxhello_member")." where contact=:tel",array(":tel"=>$tel));
    if($userInfo){
       $code=rand(pow(10,3), pow(10,4)-1);
        //发送验证码到用户
        $content="您好，您的验证码是：".$code."。有效时间3分钟";
        $result1=$this->sendSMS($tel, $content,'true');
        //生成随机验证码 ，插入数据库
        $data['code']=$code;
        $data['phone']=$tel;
        $data['createtime']=time();
        $data['endtime']=strtotime ("+3  minutes");
        $result=pdo_insert("lwxhello_code",$data);
        //echo $result1;
    }else{
        $result=3;//手机号码不存在，不可登陆
    }

    //echo json_encode(array('status'=>$result1));exit();
    echo json_encode(array('status'=>$result));exit();
}
else if($operation=='loginload')
{
    $tel=$_GPC['tel'];
    $code=$_GPC['code'];
    if($tel==""||empty($tel)||$code==""||empty($code)){
        $result=2; //数据为空，不可注册
    }else{
        $restime=time();
        //查询当前用户最新的消息记录 判断手机号码与验证码是否一致  时间是否在有效期内
        $sql="SELECT * FROM ims_lwxhello_code WHERE  phone=:tel AND `code`=:code ";
        $message=pdo_fetch($sql,array(":tel"=>$tel,":code"=>$code));
        if($message){
            $endtime=intval($message['endtime']);
            if($restime>$endtime){
                $result=4;//验证码过期
            }else{
                $userInfo=pdo_fetch("select id,uid from ".tablename("lwxhello_member")." where contact=:tel",array(":tel"=>$tel));
                if($uid!=0){
                    //$_SESSION['uid']=$uid;
                    //if($uid==$userInfo['uid'])
                    if($userInfo['uid']!='0')
                    {
                        if($userInfo['uid']==$uid)
                        {
                            $_SESSION['auid']=$uid;
                            $result=1;//登陆成功
                        }
                        else
                        {
                            $result=6;//手机号已经有绑定的微信号不对应
                        }

                    }
                    else//如果账号第一次登陆微信，
                    {
                        //$userInfo2=pdo_fetch("select id,uid from ".tablename("lwxhello_member")." where uid=:uid",array(":uid"=>$userInfo['uid']));
                        if($userInfo['uid']==0)
                        {
                            $result = pdo_query("UPDATE ".tablename('lwxhello_member')." SET uid = :uid WHERE contact = :tel", array( ':uid' => $uid,":tel"=>$tel));
                            $_SESSION['auid']=$uid;
                            $result=1;//登陆成功
                        }
                        else
                        {
                            $result=7;//该微信号已经有账号了
                        }

                    }
                }else{
                    $result=5;
                }
            }
        }else{
            $result=3; //验证码错误
        }
    }
    // echo json_encode(array('tel'=>$tel,'code'=>$code));exit();
    echo json_encode(array('status'=>$result));exit();
}
elseif($operation='gettoken')
{
    $account_api = WeAccount::create();
    $token = $account_api->getAccessToken();
    $returnArray=array("data"=>$token);
    echo json_encode($returnArray);exit();
}
 ?>