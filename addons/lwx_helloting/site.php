<?php
/**
 * hello汀模块微站定义
 *
 * @author lhd
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
load()->func('tpl');
class lwx_hellotingModuleSite extends WeModuleSite {
    
    /**
     * 判断是否关注
     */
    public function getfollowstatus(){
        global $_GPC, $_W;
        $openid=$_W['openid'];
        $fan=pdo_fetch("select follow from ".tablename("mc_mapping_fans")." where openid=:openid",array(":openid"=>$openid));
        $iffollow=intval($fan['follow']);
        return $iffollow;
    }
	/**
	 * 帖子
	 */
	public function doMobileList(){
		include_once 'site/app/doMobileList.inc.php';
	}
	/**
	 * 下单
	 */
	public function doMobileGood(){
	    include_once 'site/app/doMobileGood.inc.php';
	}
    /**
     * 我汀
     */
   
	public function doMobileFeedback(){
		include_once 'site/app/doMobileFeedback.inc.php';
	}

	public function doMobileLogin()
    {
        include_once 'site/app/doMobileLogin.inc.php';
    }
	/**
	 * 个人中心
	 */
	public function doMobilePerson(){
	    include_once 'site/app/doMobilePerson.inc.php';
	}

	////////////////////////////////后台////////////////////////////////////
	
	public function doWeborder(){
	    include_once 'site/web/doWeborder.php';
	}
	public function doWebparam(){
	    $tag = random(32);
	    global $_GPC;
	    include $this->template('param');
	}
	
	public function doWebGoods(){
	    include_once 'site/web/doWebGoods.php';
	}
	
	public function doWebFeedback(){
	    include_once 'site/web/doWebFeedback.inc.php';
	}
	/**
	 * 帖子管理
	 */

	 public function doWebNote(){
	     include_once 'site/web/doWebNote.inc.php';
	     
	 }
	 /**
	  * 专题管理
	  */
	 public function doWebTheme(){
	     include_once 'site/web/doWebTheme.inc.php';
	 }
	 /**
	  * 幻灯片
	  */
	 public function doWebAdv(){
	     include_once 'site/web/doWebAdv.inc.php';
	 }
	 /**
	  * 新货反馈表
	  */
	 public function doWebNewgoods_feedback(){
	     include_once 'site/web/doWebNewgoods_feedback.inc.php';
	 }
	 /**
	  * 开业满意度
	  */
	 public function doWebOpening_feedback(){
	     include_once 'site/web/doWebOpening_feedback.inc.php';
	 }
	 /**
	  * 店铺设置
	  */
	 public function doWebShop_feedback(){
	     include_once 'site/web/doWebShop_feedback.inc.php';
	 }
	 /**
	  * 质量反馈
	  */
	 public function doWebQuality_feedback(){
	     include_once 'site/web/doWebQuality_feedback.inc.php';
	 }


	///////////////////////////公共函数////////////////////////////////////
	 public function doWebOption() {
	     $tag = random(32);
	     global $_GPC;
	     include $this->template('option');
	 }
	 public function doWebSpec() {
	     global $_GPC;
	     $spec = array(
	         "id" => random(32),
	         "title" => $_GPC['title']
	     );
	     include $this->template('spec');
	 }
	 public function doWebSpecItem() {
	     global $_GPC;
	     load()->func('tpl');
	     $spec = array(
	         "id" => $_GPC['specid']
	     );
	     $specitem = array(
	         "id" => random(32),
	         "title" => $_GPC['title'],
	         "show" => 1
	     );
	     include $this->template('spec_item');
	 }
 
	/**
	 * 设置默认值
	 */
	public function default_val($value = '',$val=''){
		return $value?$value:$val;
	}

	/*public function getuid(){
		global $_GPC, $_W;
		$uid=intval($_W['fans']['uid']);
		if(empty($uid)){
                    mc_oauth_userinfo();
                //    exit();
                    $uid=intval($_W['fans']['uid']);
		}
		return $uid;
	}*/
    public function getuid(){
        global $_GPC, $_W;
        $uniacid=intval($_W['uniacid']);
        $openid =$_W['fans']['openid']; //系统自动获取openid   无论关注与否
        if(empty($openid)){
            //判断微信端
            // header("location:http://10010.chipshare.cn/addons/unicom_hzlt/template/mobile/default.html");die();
        }else{
            //未关注
            $join=pdo_fetch("select openid,uid from ".tablename("mc_mapping_fans")." where openid=:openid",array(":openid"=>$openid));
            if(empty($join)){
                mc_oauth_userinfo();
            }else{
                //已关注,fan表有数据,member表没有数据
                if(empty($join['uid'])||$join['uid']==0){
                    $user['nickname']=$_W['fans']['tag']['nickname'];
                    $user['avatar']=$_W['fans']['tag']['avatar'];
                    $user['gender']=$_W['fans']['tag']['sex'];
                    $user['nationality']=$_W['fans']['tag']['country'];
                    $user['resideprovince']=$_W['fans']['tag']['province'];
                    $user['residecity']=$_W['fans']['tag']['city'];
                    $user['createtime']=time();
                    $user['uniacid']=$uniacid;
                    pdo_insert("mc_members",$user);
                    $uid=pdo_insertid();
                    pdo_update("mc_mapping_fans",array("uid"=>$uid),array("openid"=>$openid));
                }
            }
        }
        $uid =$_W['fans']['uid'];
        return $uid;
    }
	 
	 
	/**
	 * 去重二维数组
	 * @param unknown $array2D
	 * @return multitype:
	 */
	function array_unique_fb($array2D)
	{
		foreach ($array2D as $v)
		{
			$v = join(",",$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
			$temp[] = $v;
		}
		$temp = array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
		foreach ($temp as $k => $v)
		{
			$temp[$k] = explode(",",$v); //再将拆开的数组重新组装
		}
		return $temp;
	}
	
	//微信下载图片
	
	/*public function downloadWeixinFile($url){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$package = curl_exec($ch);
		$httpinfo = curl_getinfo($ch);
		curl_close($ch);
		$imageAll = array_merge(array('header' => $httpinfo), array('body' => $package));
		return $imageAll;
	}*/
    public function downloadWeixinFile($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $package = curl_exec($ch);
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);
        $imageAll = array_merge(array('header' => $httpinfo), array('body' => $package));
        return $imageAll;
    }


	//保存图片到服务器
	public function saveWeixinFile($filename, $filecontent) {
		$path = "../attachment/lwx_helloting/";
		$local_file = fopen($path.$filename, 'w');
		if (false !== $local_file){
			if (false !== fwrite($local_file, $filecontent)) {
				fclose($local_file);
			}
		}
	}


    //压缩图片
    function ResizeImage($filename,$size,$type,$newfilename){
        header("Content-type: image/".$type."");

        //原图文件
        $file = $filename;

        // 缩略图比例
        $percent =$size;

        // 缩略图尺寸
        list($width, $height) = getimagesize($file);
        $newwidth = $width * $percent;
        $newheight = $height * $percent;

        // 加载图像
        if($type=='gif') {
            $src_im = imagecreatefromgif($file);
        }else if($type=='jpeg'){
            $src_im = imagecreatefromjpeg($file);
        }else{
            $src_im = imagecreatefrompng($file);
        }

        $dst_im = imagecreatetruecolor($newwidth, $newheight);

        // 调整大小
        imagecopyresampled($dst_im, $src_im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        //输出缩小后的图像
        if($type=='gif') {
            imagegif($dst_im,$newfilename);
        }else if($type=='jpeg'){
            imagejpeg($dst_im,$newfilename);
        }else{
            imagepng($dst_im,$newfilename);
        }

        imagedestroy($dst_im);
        imagedestroy($src_im);
        return $newfilename;
    }


    function sendSMS($mobile, $msg, $needstatus = 'false', $product = '', $extno = '') {
        $chuanglan_config =array();//jiekou-clcs-15  密码 Poiuytrewq258    nmgyp88888    密码Nmgyp66666
        // 账户：nmgyp88888  密码：    Nmgyp6666      6

        $chuanglan_config['api_password']=" Nmgyp66666";
        $chuanglan_config['api_send_url']="http://222.73.117.158/msg/HttpBatchSendSM";
        $chuanglan_config['api_account']="nmgyp88888";

        //创蓝接口参数
        $postArr = array (
            'account' =>$chuanglan_config['api_account'],
            'pswd' =>$chuanglan_config['api_password'],
            'msg' => "【Hello汀】".$msg,
            'mobile' => $mobile,
            'needstatus' => $needstatus,
            'product' => $product,
            'extno' => $extno
        );
        $result = $this->curlPost($chuanglan_config['api_send_url'], $postArr);
        return $result;
        /*     $result= simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
            $result=(array)$result;  ;
            foreach($result as $k=>$v){
                if($v instanceof SimpleXMLElement ||is_array($v)){
                    $result[$k]=xmlToArray($v);
                }
            }
            return $result;  */
    }


   /* public function  sendSMS($mobile, $msg, $needstatus = 'false', $product = '', $extno = '') {
        $huaxin_config =array();
        $huaxin_config['userid']="";
        $huaxin_config['account']="jkwl187";
        $huaxin_config['password']="552896";
        $huaxin_config['api_send_url']="http://sh2.ipyy.com/sms.aspx";

        $postArr=array(
            "userid"=>$huaxin_config['userid'],
            "account"=>$huaxin_config['account'],
            "password"=>$huaxin_config['password'],
            "mobile"=>$mobile,
            "content"=>"【Hello汀】".$msg,
            "sendTime"=>"",
            "action"=>"send",
            "extno"=>""
        );
        $result = $this->curlPost($huaxin_config['api_send_url'], $postArr);
        $result= simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
        $result=(array)$result;  ;
        foreach($result as $k=>$v){
            if($v instanceof SimpleXMLElement ||is_array($v)){
                $result[$k]=xmlToArray($v);
            }
        }
        return $result["successCounts"];
  }*/


  public function curlPost($url,$postFields){
            $postFields = http_build_query($postFields);
            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_POST, 1 );
            curl_setopt ( $ch, CURLOPT_HEADER, 0 );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt ( $ch, CURLOPT_URL, $url );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postFields );
            $result = curl_exec ( $ch );
            curl_close ( $ch );
            return $result;
    }

 /**
    * 导入数据
        底层导入代码 
    * @param unknown $filePath Excel路径
    */
   public function import_data($filePath){
       global $_W, $_GPC;
       include_once 'lib/PHPExcel.php';
       
       $PHPExcel = new PHPExcel();
       
       /**默认用excel2007读取excel，若格式不对，则用之前的版本进行读取*/
       $PHPReader = new PHPExcel_Reader_Excel2007();
       if(!$PHPReader->canRead($filePath)){
           $PHPReader = new PHPExcel_Reader_Excel5();
           if(!$PHPReader->canRead($filePath)){
               echo '无法读取Excel或Excel不存在';
               return ;
           }
       }
       
       $PHPExcel = $PHPReader->load($filePath);
       /**读取excel文件中的第一个工作表*/
       $currentSheet = $PHPExcel->getSheet(0);
       /**取得最大的列号*/
       $allColumn = $currentSheet->getHighestColumn();
       /**取得一共有多少行*/
       $allRow = $currentSheet->getHighestRow();
       /**从第二行开始输出，因为excel表中第一行为列名*/
       $verifi_data = array(); 
       for($currentRow = 1;$currentRow <= $allRow;$currentRow++){
           /**从第A列开始输出*/
           for($currentColumn= 'A';$currentColumn<= $allColumn; $currentColumn++){
               $val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getValue();/**ord()将字符转为十进制数*/
               if($currentColumn == 'A')
               {
                  $verifi_data[$currentRow-1]['keytype'] = $val;
               }elseif($currentColumn=='B'){
                  $verifi_data[$currentRow-1]['phone'] = $val;
               }
                
           }
       }
       return $verifi_data;
   }
   
   /**
    * 导出功能
    * @param   $data
    * @param   $file_name
    * @param   $title
    */
 function  outputXlsHeader($data,$file_name = 'Excel',$title){
   	header('Content-Type: text/xls');
   	header ( "Content-type:application/vnd.ms-excel;charset=UTF-8" );
   	header('Content-Disposition: attachment;filename="' .$file_name . '.xls"');
   	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
   	header('Expires:0');
   	header('Pragma:public');
   	$table_data = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><table border="1">';
   	$table_data .=$title;
   	$table_data .= '<tr>';
   	foreach ($data as $line)
   	{
   		foreach ($line as $key => &$item)
   		{
   			$table_data .= '<td>' . $item . '</td>';
   		}
   		$table_data .= '</tr>';
   	}
   	$table_data .='</table>';
   	echo $table_data;
   	die();
   }



}