<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;
use Org\Util\Date;
use Org\Util\Pinyin;
use Think\Upload;
class AttachmentController extends CommonController {
	public $phpbean="Attachment";
    
    public function pageList(){
    	$beanName=$this->phpbean;
		
    	$pageBean['rows']=$_GET['rows'];
    	$pageBean['page']=$_GET['page'];
    	$example['pageBean']=$pageBean;
    	
    	$order['sort']=$_GET['sort'];
    	$order['order']=$_GET['order'];
    	$example['order']=$order;
    	
    	$example['relation']=true;
    	
    	$condition['level']=1;
    	$example['condition']=$condition;
    	
    	$rtr = D($beanName)->pageList($example,$beanName);
    	$total= D($beanName)->countTotal($example,$beanName);
    	
    	$data=array(
    			'rows' => $rtr,
    			'total' => $total
    	);
    	$this->ajaxReturn($data);
    	
    }
    
    public function addOrUpdate(){
    	try {
    		$beanName=$this->phpbean;
    		$rtr['flag']=true;
    		$data=$_POST['data'];
    		if ($data['id']>0){
    			$rtr['object'] = D($beanName)->updateRow($data,$beanName);
    			$rtr['msg']="更新成功";
    			$this->ajaxReturn($rtr);
    		}else{
    			if(empty($_FILES)){
    				$this->error('必须选择上传文件');
    			}else{
    				$childFile=null;
    				$formName=null;
    				if(1==$data['cat']){
    					$childFile="/header/";
    					$formName='header';
    				}else if(2==$data['cat']){
    					$childFile="/license/";
    					$formName='license';
    				}else if (3==$data['cat']){
    					$childFile="/servicecat/";
    					$formName='servicecat';
    				}
    				$config = array(
    						'maxSize'    =>    3145728,
    						'rootPath'   =>    './Uploads/',
    						'savePath'   =>    $childFile,
    						'saveName'   =>    array('uniqid',''),
    						'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
    						'autoSub'    =>    true,
    						'subName'    =>    array('date','Ymd'),
    				);
    				$upload = new \Think\Upload($config);// 实例化上传类
    				$info = $upload->uploadOne($_FILES[$formName]);
    				if(!$info) {// 上传错误提示错误信息
    					$rtr['flag']=false;
    					$rtr['msg']="操作失败";
    					$this->ajaxReturn($rtr);
    				}else{// 上传成功
    					$data['path']=$info['savepath'].$info['savename'];
    					$data['name']=$info['name'];
    					$data['filename']=$info['savename'];
    					$data['type']=1;
    					$data['status']=2;
    					$data['id']= D($beanName)->addRow($data,$beanName);
    					$data['path']=__ROOT__."/Uploads".$info['savepath'].$info['savename'];
    					$rtr['object']=$data;
    					$rtr['msg']="添加成功";
    					$this->ajaxReturn($rtr);
    				}
    			}
    		}
    	} catch (Exception $e) {
    		$rtr['flag']=false;
    		$rtr['msg']="操作失败";
    		$this->ajaxReturn($rtr);
    	}
    }
    
    public function delRows(){
    	try {
    		$beanName=$this->phpbean;
    		$data=$_POST['data'];
    		$rtr['flag']=true;
    		$rtr['object']= D($beanName)->delRows($data,$beanName);
    		$rtr['msg']="操作成功";
    		$this->ajaxReturn($rtr);
    	} catch (Exception $e) {
    		$rtr['flag']=false;
    		$rtr['msg']="操作失败";
    		$this->ajaxReturn($rtr);
    	}
    }
    
    public function getAllAttachment(){
    	$beanName=$this->phpbean;
    	$example['relation']=false;
    	$rtr=D($beanName)->getAllList($example,$beanName);
    	$this->ajaxReturn($rtr);
    }
    
}