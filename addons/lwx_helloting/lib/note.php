<?php
function getgoodlist_bynote($id){
    global $_W;
    $uniacid=$_W['uniacid'];
    $sql="select * from ".tablename("lwxhello_note")." where id=:id";
    $param=array(":id"=>$id);
    $note=pdo_fetch($sql,$param);
    $goodStr=$note['goodid'];
    $len=strlen($goodStr);
    //如果该直播下单商品不为空，查询该直播的可下单商品列表
    if($len>0){
        $sql="select id,goodssn,marketprice,title,thumb from ".tablename("shopping_goods")." where weid=:weid and deleted=0 and id in (".$goodStr.")";
        $param=array(":weid"=>$uniacid);
        $goodlist=pdo_fetchall($sql,$param);
        //商品列表
        foreach($goodlist as &$good){
            $goodid=$good['id'];
            $sql="select  id,title from ".tablename("shopping_spec")." where goodsid=:gid";
            $param=array(":gid"=>$goodid);
            //该商品的规格列表
            $speclist=pdo_fetchall($sql,$param);
            foreach($speclist as &$spec){
                $specid=$spec['id'];
                $sql="select id,title,thumb from ".tablename("shopping_spec_item")." where specid=:specid";
                $param=array(":specid"=>$specid);
                $spec_item_list=pdo_fetchall($sql,$param);
                //该商品该规格的属性列表
                $spec['item_list']=$spec_item_list;
            }
            //重新封装字段到商品列表，以三维数组形式表现
            $good['spec']=$speclist;
        }
    }
   return $goodlist;
}
//幻灯片列表
function getadvlist(){
    global $_W;
    $sql="SELECT * FROM " . tablename('lwxhello_adv') . " WHERE weid = '{$_W['uniacid']}' ORDER BY id DESC";
    $advlist = pdo_fetchall($sql);
    return $advlist;
}

function getnotedetail($id){
    global $_W;
    $sql="select * from ".tablename("lwxhello_note")." where id=:id";
    $param=array(":id"=>$id);
    $note=pdo_fetch($sql,$param);
    foreach ($note as &$item)
    {
        $note['content']=htmlspecialchars_decode($note['content']);
    }
    return $note;
}

function noteiflike($id,$uid){
    global $_W;
    //当前用户是否点赞
    $sql="select id from ".tablename("lwxhello_notelike")." where noteid=:nid and uid=:uid";
    $param=array(":nid"=>$id,":uid"=>$uid);
    $like=pdo_fetch($sql,$param);
    if(empty($like)){
        $iflike=2;//未点赞
    }else{
        $iflike=1;//已点赞
    }
    return $iflike;
}
 function noteifread($id,$uid){
     $sql="select id from ".tablename("lwxhello_noteread")." where nid=:nid and uid=:uid";
     $param=array(":nid"=>$id,":uid"=>$uid);
     $read=pdo_fetch($sql,$param);
     if(empty($read)){
         //没有阅读，添加阅读
         $result=pdo_insert("lwxhello_noteread",array("nid"=>$id,"uid"=>$uid));
         $readno=intval($note['readno'])+1;
         $result=pdo_update("lwxhello_note",array("readno"=>$readno),array("id"=>$id));
     }
     return $result;
 }
 function noteifcollect($id,$uid){
     $sql="select id from ".tablename("lwxhello_notecollect")." where noteid=:nid and uid=:uid";
     $param=array(":nid"=>$id,":uid"=>$uid);
     $collect=pdo_fetch($sql,$param);
     if(empty($collect)){
         $ifcollect=2;//未收藏
     }else{
         $ifcollect=1;//已收藏
     }
     return $ifcollect;
 }
 function noteifsub($id,$uid){
     $sql="select * from ".tablename("lwxhello_note")." where id=:id";
     $param=array(":id"=>$id);
     $note=pdo_fetch($sql,$param);
     $beuid=intval($note['uid']);
     if($beuid==0){
         //朗文斯汀
         $sql="select id from ".tablename("lwxhello_subsribemember")." where uid=:uid and besubuid=:buid";
         $param=array(":uid"=>$uid,":buid"=>0);
         $subInfo=pdo_fetch($sql,$param);
         if($subInfo){
             $ifsub=1;
         }else{
             $ifsub=2;
         }
     
     }else{
         $sql="select id from ".tablename("lwxhello_subsribemember")." where uid=:uid and besubuid=:buid";
         $param=array(":uid"=>$uid,":buid"=>$beuid);
         $subInfo=pdo_fetch($sql,$param);
         if($subInfo){
             $ifsub=1;
         }else{
             $ifsub=2;
         }
     }
     return $ifsub;
 }
 function notecommentlist($id){
     $sql="select c.*,m.nickname,m.avatar,m.uid from ".tablename("lwxhello_notecomment")." c
	        left join ".tablename("mc_members")." m  on c.uid=m.uid where c.noteid=:nid order by c.id desc limit 5";
     $param=array(":nid"=>$id);
     $commentlist=pdo_fetchall($sql,$param);
     //循环判断是否为回复，如果为回复，内容前面追加@xxx,字体为蓝色，
     foreach($commentlist as &$comment){
         $replyuid=intval($comment['replyuid']);
         if($replyuid>0){
             $member=pdo_fetch("select nickname from ".tablename("mc_members")." where uid=:uid",array(":uid"=>$replyuid));
             $comment['replynickname']="@".$member['nickname'];
         }else{
             $comment['replynickname']="";
         }
     }
     return $commentlist;
 }
?>