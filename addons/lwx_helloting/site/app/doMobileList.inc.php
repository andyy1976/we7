<?php 
require_once IA_ROOT . "/addons/lwx_helloting/lib/note.php";
	global $_W, $_GPC;
	$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
	$uniacid=$_W['uniacid'];
	$uid=$this->getuid();
	//粉丝数据
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
	//默认显示研究所
	if($operation=='display'){
	    $advlist=getadvlist();
	    include $this->template('index');

	//直播间    
	}elseif($operation=='radiolist'){
		include $this->template('radiolist');
	//帖子详情页	
	}elseif($operation=="noteDetail"){
	    $id=intval($_GPC['id']);
	    $note=getnotedetail($id);
	    $iflike=noteiflike($id,$uid); //当前用户是否点赞
	    $result=noteifread($id,$uid); //当前用户是否已经阅读 未阅读 添加阅读量
	    $ifcollect=noteifcollect($id,$uid); //当前用户是否收藏
	    $ifsub=noteifsub($id,$uid);//1已经关注 2没有关注
	    $commentlist=notecommentlist($id); //该帖子的评论列表
	    //该帖子的点赞头像  4个 
	    $sql="select m.avatar from ".tablename("lwxhello_notelike")." l 
	        left join ".tablename("mc_members")." m on l.uid=m.uid where l.noteid=:id order by l.id desc limit 4";
	    $param=array(":id"=>$id);
	    $likeList=pdo_fetchall($sql,$param);
	    //该帖子的发布人
	    $authid=intval($note['uid']);
	    if($authid>1){
	        $sql="select m1.nickname,m1.avatar,m2.description from ".tablename("mc_members")." m1
	             left join ".tablename("lwxhello_member")." m2  on m1.uid=m2.uid where m1.uid=:uid";
	        $param=array(":uid"=>$authid);
	        $member=pdo_fetch($sql,$param);
	    }else{
	        $member=array("nickname"=>"朗文斯汀","description"=>"另类混搭-英式浪漫","avatar"=>"http://h5.lwest.cn/we7/addons/lwx_helloting/template/mobile/public/images/logo.png");
	    }
	    //查询该分类的相关文章
	    $sql="select note.id,note.title,note.createtime,note.thumb_url,m.nickname from ".tablename("lwxhello_note")." note left join ".tablename("mc_members")."
	         m on note.uid=m.uid where note.cateid=:cateid and note.id!=:noteid order by note.commentno desc limit 5";
	    $param=array(":cateid"=>$note['cateid'],":noteid"=>$id);
	    $aboutnote=pdo_fetchall($sql,$param);
	    foreach($aboutnote as &$n){
	        if($n['nickname']==""){
	            $n['nickname']="朗文斯汀";
	        }
	        $n['thumb_url']=unserialize($n['thumb_url']);

	    }

	  //判断是否是直播间  cateid=6为直播间
	  $cateid=intval($note['cateid']);
	  if($cateid==6){
	     include $this->template('live');
	  //非直播帖子，进入detail.html    
	  }else if($cateid==4||$cateid==5)
      {
          include $this->template('detail1');
      }
	  else{
	      include $this->template('detail');
	  }
	 //某帖子的评论列表  分页   
	}elseif($operation=="notecommentbypage"){
	    $id=intval($_GPC['id']);
	    $pindex = max(1, intval($_GPC['page']));//当前页数
	    $psize =5;
	    //该帖子的评论列表
	    $sql="select c.*,m.nickname,m.avatar from ".tablename("lwxhello_notecomment")." c
	        left join ".tablename("mc_members")." m  on c.uid=m.uid 
	            where c.noteid=:nid order by c.id desc limit  ". ($pindex - 1) * $psize . ',' . $psize;
	    $param=array(":nid"=>$id);
	    $commentlist=pdo_fetchall($sql,$param);
	    echo json_encode($commentlist);exit();
	  //点赞帖子  
	}elseif($operation=="addnotelike"){
	     $id=intval($_GPC['id']);
	     //查询是否点赞过
	     $sql="select id from ".tablename("lwxhello_notelike")." where noteid=:nid and uid=:uid";
	     $param=array(":nid"=>$id,":uid"=>$uid);
	     $like=pdo_fetch($sql,$param);
	     if($like){
	         //已经点赞
	         echo 2;exit();//已经点赞，不可重复点赞
	     }else{
	         //添加点赞
	         $likeData=array("noteid"=>$id,"uid"=>$uid,"createtime"=>time());
	         $result=pdo_insert("lwxhello_notelike",$likeData);
	         //添加该帖子点赞数
	         $note=pdo_fetch("select likeno from ".tablename("lwxhello_note")." where id=:id",array(":id"=>$id));
	         $likeno=intval($note['likeno'])+1;
	         $result=pdo_update("lwxhello_note",array("likeno"=>$likeno),array("id"=>$id));
	         //判断帖子类型为po图，点赞数加评论超过50，自动设置为最热
	         $sql="select id,likeno,cateid from".tablename("lwxhello_note")." where id=:id";
	         $param=array(":id"=>$id);
	         $note=pdo_fetch($sql,$param);
	           $likeno=intval($note['likeno']);
             $commentno=intval($note['commentno']);
	         $cateid=intval($note['cateid']);
	         if($cateid==2||$cateid==3){
                 $sum=$likeno+$commentno;
	             if($sum==50)
	             {
                     $result=pdo_update("lwxhello_note",array("ishot"=>1),array("id"=>$id));
                 }
	         }  
	         //如果帖子发布人为粉丝，需添加到消息表进行记录
	         $note=pdo_fetch("select uid from ".tablename("lwxhello_note")." where id=:id",array(":id"=>$id));
	         $note_uid=intval($note['uid']);
	         if($note_uid>0){
	             //添加到消息表 lwxhello_message type:1关注  2点赞 3打赏 4收藏 5评论
	             $mes=array("uid"=>$uid,"beuid"=>$note_uid,"type"=>2,"createtime"=>time(),"noteid"=>$id);
	             $result=pdo_insert("lwxhello_message",$mes); 
	             //通知发帖人 被点赞了
	             //查询当前用户的openid
	             $sql="SELECT openid FROM ims_mc_mapping_fans WHERE uid=:uid";
	             $fans=pdo_fetch($sql,array(":uid"=>$note_uid));
	             $keyword1=$nickname;
	             $keyword2=$nickname;
	             $keyword3=date("Y-m-d H:i:s",time());
	             $postdata=array("first"=>array("value"=>"您好，您已被好友点赞，请前往【消息】查看。","color"=>"#743A3A"),
	                 "keyword1"=>array("value"=>'点赞',"color"=>"#743A3A"),
	                 "keyword2"=>array("value"=>$keyword3,"color"=>"#743A3A"),
	                 "remark"=>array("value"=>"","color"=>"#743A3A"));
	             $touser=$fans['openid'];
	             $tpl_id_short="lbFt_5C253ZoaZhi8jMEqKHrPTB3dhNSRaZDRXUkiiI";
	             $account_api = WeAccount::create();
	             $url="";
	             $sendresult=$account_api->sendTplNotice($touser, $tpl_id_short, $postdata, $url =$url, $topcolor = '#FF683F');
	             
	             echo $result;exit();
	         }
	        
	         
	         
	         echo 1;exit();
	     }
	//取消点赞帖子     
	}elseif($operation=="chalenotelike"){   
	    $id=intval($_GPC['id']);
	    //查询是否点赞过
	    $sql="select id from ".tablename("lwxhello_notelike")." where noteid=:nid and uid=:uid";
	    $param=array(":nid"=>$id,":uid"=>$uid);
	    $like=pdo_fetch($sql,$param);
	    if($like){
	        //取消点赞
	        $likeid=$like['id'];
	        $result=pdo_delete("lwxhello_notelike",array("id"=>$likeid));
	        
	        //减少该帖子点赞数
	        $note=pdo_fetch("select likeno from ".tablename("lwxhello_note")." where id=:id",array(":id"=>$id));
	        $likeno=intval($note['likeno'])-1;
	        $result=pdo_update("lwxhello_note",array("likeno"=>$likeno),array("id"=>$id));

            //判断帖子类型为po图，点赞数低于50，自动取消最热
            $sql="select id,likeno,cateid from".tablename("lwxhello_note")." where id=:id";
            $param=array(":id"=>$id);
            $note=pdo_fetch($sql,$param);

            $likeno=intval($note['likeno']);
            $cateid=intval($note['cateid']);
            if($cateid==2&&$likeno==49){
                $result=pdo_update("lwxhello_note",array("ishot"=>2),array("id"=>$id));
            }


            echo $result;exit();
	    }else{
	        echo 2;exit();//还未点赞，不可取消
	    }
	//收藏帖子    
	}elseif($operation=="addnotecollect"){
	    $id=intval($_GPC['id']);
	    //查询是否收藏过 
	    $sql="select id from ".tablename("lwxhello_notecollect")." where noteid=:nid and uid=:uid";
	    $param=array(":nid"=>$id,":uid"=>$uid);
	    $collect=pdo_fetch($sql,$param);
	    if($collect){
	        //已经收藏
	        echo 2;exit();//已经收藏，不可重复收藏
	    }else{
	        //添加收藏
	        $collectData=array("noteid"=>$id,"uid"=>$uid,"createtime"=>time());
	        $result=pdo_insert("lwxhello_notecollect",$collectData);
	        
	        //添加该帖子收藏数
	        $note=pdo_fetch("select collectno from ".tablename("lwxhello_note")." where id=:id",array(":id"=>$id));
	        $collectno=intval($note['collectno'])+1;
	        $result=pdo_update("lwxhello_note",array("collectno"=>$collectno),array("id"=>$id));
	        
	        
	        //如果帖子发布人为粉丝，需添加到消息表进行记录
	        $note=pdo_fetch("select uid from ".tablename("lwxhello_note")." where id=:id",array(":id"=>$id));
	        $note_uid=intval($note['uid']);
	        if($note_uid>0){
	            //添加到消息表 lwxhello_message type:1关注  2点赞 3打赏 4收藏   5评论
	            $mes=array("uid"=>$uid,"beuid"=>$note_uid,"type"=>4,"createtime"=>time(),"noteid"=>$id);
	            $result=pdo_insert("lwxhello_message",$mes);
	            //通知发帖人 被点赞了
	            //查询当前用户的openid
	            $sql="SELECT openid FROM ims_mc_mapping_fans WHERE uid=:uid";
	            $fans=pdo_fetch($sql,array(":uid"=>$note_uid));
	            $keyword1=$nickname;
	            $keyword2=$nickname;
	            $keyword3=date("Y-m-d H:i:s",time());
	            $postdata=array("first"=>array("value"=>"您好，您已被好友收藏，请前往【消息】查看。","color"=>"#743A3A"),
	                "keyword1"=>array("value"=>'收藏',"color"=>"#743A3A"),
	                "keyword2"=>array("value"=>$keyword3,"color"=>"#743A3A"),
	                "remark"=>array("value"=>"","color"=>"#743A3A"));
	            $touser=$fans['openid'];
	            $tpl_id_short="lbFt_5C253ZoaZhi8jMEqKHrPTB3dhNSRaZDRXUkiiI";
	            $account_api = WeAccount::create();
	            $url="";
	            $sendresult=$account_api->sendTplNotice($touser, $tpl_id_short, $postdata, $url =$url, $topcolor = '#FF683F');
	            
	            echo $result;exit();
	        }
	        echo 1;exit();
	    }
	    //查询是否收藏过
	}elseif($operation=="chalenotecollect"){   
	    $id=intval($_GPC['id']);
	    //查询是否收藏过
	    $sql="select id from ".tablename("lwxhello_notecollect")." where noteid=:nid and uid=:uid";
	    $param=array(":nid"=>$id,":uid"=>$uid);
	    $collect=pdo_fetch($sql,$param);
	    if($collect){
	        //取消收藏
	        $collectid=$collect['id'];
	        $result=pdo_delete("lwxhello_notecollect",array("id"=>$collectid));
	        
	        //添加该帖子收藏数
	        $note=pdo_fetch("select collectno from ".tablename("lwxhello_note")." where id=:id",array(":id"=>$id));
	        $collectno=intval($note['collectno'])-1;
	        $result=pdo_update("lwxhello_note",array("collectno"=>$collectno),array("id"=>$id));
	        
	        echo $result;exit();
	    }else{
	        echo 2;exit();//还未收藏，不可取消
	    }
    //添加评论帖子
	}elseif($operation=="addnotecomment"){
	    $id=intval($_GPC['id']);
	    $content=$_GPC['content'];
	    $replyuid=intval($_GPC['uid']);//如果是回复，有回复人的uid
	    $comment=array("noteid"=>$id,"uid"=>$uid,"replyuid"=>$replyuid,"content"=>$content,"createtime"=>time());
	    $result=pdo_insert("lwxhello_notecomment",$comment);
	    $commentid=pdo_insertid();

	    //添加该帖子评论数
	    $note=pdo_fetch("select likeno,cateid,commentno from ".tablename("lwxhello_note")." where id=:id",array(":id"=>$id));
	    $commentno=intval($note['commentno'])+1;
	    $result=pdo_update("lwxhello_note",array("commentno"=>$commentno),array("id"=>$id));
        $likeno=intval($note['likeno']);
        $cateid=intval($note['cateid']);
        if($cateid==2||$cateid==3){
            $sum=$likeno+$commentno;
            if($sum==50)
            {
                $result1=pdo_update("lwxhello_note",array("ishot"=>1),array("id"=>$id));
            }
        }


        //如果帖子发布人为粉丝，需添加到消息表进行记录
	    $note=pdo_fetch("select uid from ".tablename("lwxhello_note")." where id=:id",array(":id"=>$id));
	    $note_uid=intval($note['uid']);
	    if($note_uid>0){
	        //添加到消息表 lwxhello_message type:1关注  2点赞 3打赏 4收藏 5评论
	        $mes=array("uid"=>$uid,"beuid"=>$note_uid,"type"=>5,"createtime"=>time(),"noteid"=>$id,"commentid"=>$commentid);
	        $result=pdo_insert("lwxhello_message",$mes);
	        //通知发帖人 被评论了
	        //查询当前用户的openid
	        $sql="SELECT openid FROM ims_mc_mapping_fans WHERE uid=:uid";
	        $fans=pdo_fetch($sql,array(":uid"=>$note_uid));
	        $keyword1=$nickname;
	        $keyword2=$nickname;
	        $keyword3=date("Y-m-d H:i:s",time());
	        $postdata=array("first"=>array("value"=>"您好，您已被好友评论，请前往【消息】查看。","color"=>"#743A3A"),
	            "keyword1"=>array("value"=>'评论',"color"=>"#743A3A"),
	            "keyword2"=>array("value"=>$keyword3,"color"=>"#743A3A"),
	            "remark"=>array("value"=>"","color"=>"#743A3A"));
	        $touser=$fans['openid'];
	        $tpl_id_short="lbFt_5C253ZoaZhi8jMEqKHrPTB3dhNSRaZDRXUkiiI";
	        $account_api = WeAccount::create();
	        $url="";
	        $sendresult=$account_api->sendTplNotice($touser, $tpl_id_short, $postdata, $url =$url, $topcolor = '#FF683F');
	         
	        echo $result;exit();
	    }
	    echo $result;exit();
	//回复帖子
	}elseif($operation=="replynote"){    
	    
	    //lwxhello_notereply noteid  replyuid  content createtime uid 
	    $id=intval($_GPC['id']);
	    $replyuid=intval($_GPC['uid']);
	    $content=$_GPC['content'];
	    $result=pdo_insert("lwxhello_notereply",array("noteid"=>$id,"replyuid"=>$replyuid,"content"=>$content,"uid"=>$uid,"createtime"=>time()));
	    echo $result;exit();
	    
	//关注某个粉丝    
	}elseif($operation=="subsribemember"){
	    $id=intval($_GPC['id']);
	    //查询是否被关注
	    if($id==0){
	        echo 2;exit();
	    }
	    $sql="select id from ".tablename("lwxhello_subsribemember")." where besubuid=:bid and uid=:uid";
	    $param=array(":bid"=>$id,":uid"=>$uid);
	    $subsribe=pdo_fetch($sql,$param);
	    if($id==$uid){
	        echo 2;exit();
	    }
	    if($subsribe){
	        echo 2;exit();//已经关注，不可重复关注
	    }else{
	        $subsrcibeInfo=array("besubuid"=>$id,"uid"=>$uid,"createtime"=>time());
	        $result=pdo_insert("lwxhello_subsribemember",$subsrcibeInfo);
	        //添加到消息表 lwxhello_message type:1关注  2点赞 3打赏 4收藏 5评论
	        $mes=array("uid"=>$uid,"beuid"=>$id,"type"=>1,"createtime"=>time());
	        $result=pdo_insert("lwxhello_message",$mes);
	        //通知发帖人 被评论了
	        //查询当前用户的openid
	        $sql="SELECT openid FROM ims_mc_mapping_fans WHERE uid=:uid";
	        $fans=pdo_fetch($sql,array(":uid"=>$id));
	        $keyword1=$nickname;
	        $keyword2=$nickname;
	        $keyword3=date("Y-m-d H:i:s",time());
	        $postdata=array("first"=>array("value"=>"您好，您已被好友关注，请前往【消息】查看。","color"=>"#743A3A"),
	            "keyword1"=>array("value"=>'关注',"color"=>"#743A3A"),
	            "keyword2"=>array("value"=>$keyword3,"color"=>"#743A3A"),
	            "remark"=>array("value"=>"","color"=>"#743A3A"));
	        $touser=$fans['openid'];
	        $tpl_id_short="lbFt_5C253ZoaZhi8jMEqKHrPTB3dhNSRaZDRXUkiiI";
	        $account_api = WeAccount::create();
	        $url="";
	        $sendresult=$account_api->sendTplNotice($touser, $tpl_id_short, $postdata, $url =$url, $topcolor = '#FF683F');
	        
	        echo $result;exit();
	    }
	 //取消关注某个粉丝   
	}elseif($operation=="chalesubsribemember"){
	    $id=intval($_GPC['id']);
	    //查询是否被关注
	    $sql="select id from ".tablename("lwxhello_subsribemember")." where besubuid=:bid and uid=:uid";
	    $param=array(":bid"=>$id,":uid"=>$uid);
	    $subsribe=pdo_fetch($sql,$param);
	    if($subsribe){
	        $sid=$subsribe['id'];
	        $result=pdo_delete("lwxhello_subsribemember",array("id"=>$sid));
	        echo $result;exit();
	    }else{
	        echo 2;exit();//还未被关注，不可取消
	    }
	}elseif($operation=="test"){
	}

?>


