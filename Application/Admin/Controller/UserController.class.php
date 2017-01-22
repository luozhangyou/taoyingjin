<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;
use Org\Util\Date;
class UserController extends CommonController {
	public $phpbean="User";
    
    public function pageList(){
    	$beanName=$this->phpbean;
		
    	$pageBean['rows']=$_GET['rows'];
    	$pageBean['page']=$_GET['page'];
    	$example['pageBean']=$pageBean;
    	
    	$order['sort']=$_GET['sort'];
    	$order['order']=$_GET['order'];
    	$example['order']=$order;
    	
    	$example['relation']=false;
    	
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
    		$data=$_POST['data'];
    		$rtr['flag']=true;
    		if ($data['id']>0){
    			$data['update_time']=time();
    			$rtr['object'] = D($beanName)->updateUser($data,$beanName);
    			$rtr['msg']="更新成功";
    			$this->ajaxReturn($rtr);
    		}else{
    			$data['password']=self::getPasswordMD5($data['password']);
    			$data['create_time']=time();
    			$rtr['object']= D($beanName)->addRow($data,$beanName);
    			$rtr['msg']="添加成功";
    			$this->ajaxReturn($rtr);
    		}
    	} catch (\Exception $e) {
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
    	} catch (\Exception $e) {
    		$rtr['flag']=false;
    		$rtr['msg']="操作失败";
    		$this->ajaxReturn($rtr);
    	}
    }
    
    public function initPassword(){
    	$beanName=$this->phpbean;
    	$data=$_POST['data'];
    	$data['password']=self::getPasswordMD5("123456");
    	D($beanName)->setPassword($data);
    }
    
    public function setRoles(){
    	$beanName="RoleUser";
    	$data=$_POST['data'];
    	$condition['user_id']=$data['id'];
    	$example['condition']=$condition;
    	D($beanName)->delRoleUser($example);
    	
    	$roles = $data['roleIds'];
    	for($x=0;$x<count($roles);$x++){
    		$addNode['role_id']=$roles[$x];
    		$addNode['user_id']=$data['id'];
    		D($beanName)->addRow($addNode,$beanName);
    	}
    	$rtr['flag']=true;
    	$rtr['msg']="操作成功";
    	$this->ajaxReturn($rtr);
    }
    
    public function getUserRole(){
    	$beanName="RoleUser";
    	$condition['user_id']=$_POST['user_id'];
    	$example['condition']=$condition;
    	$example['relation']=false;
    	$rtr=D($beanName)->getAllList($example,$beanName);
    	$this->ajaxReturn($rtr);
    }
    
    public function changemobile(){
    	$beanName=$this->phpbean;
    	$user_id=self::getSessionUserId();
    	$user=$_POST['user'];
    	try {
    		$user['id']=$user_id;
    		$flag=D($beanName)->changemobile($user,$beanName);
    		$rtr['flag']=true;
    		$rtr['msg']="操作成功";
    		$this->ajaxReturn($rtr);
    	} catch (\Exception $e) {
    		$rtr['flag']=false;
    		$rtr['msg']="操作失败";
    		$this->ajaxReturn($rtr);
    	}
    }
    
    public function checkMobile(){
    	$beanName=$this->phpbean;
    	$user=$_POST['user'];
    	$condition['account']=$user['account'];
    	$example['condition']=$condition;
    	
    	$rtr=D($beanName)->findRow($example,$beanName);
    	if(isset($rtr)){
    		$this->ajaxReturn(false);
    	}else{
    		$this->ajaxReturn(true);
    	}
    }
    
    public function checkPassword() {
    	$beanName=$this->phpbean;
    	$user=$_POST['user'];
    	$condition['password']=$this->getPasswordMD5($user['password']);
    	$example['condition']=$condition;
    	
    	$rtr=D($beanName)->findRow($example,$beanName);
    	if(isset($rtr)){
    		$this->ajaxReturn(true);
    	}else{
    		$this->ajaxReturn(false);
    	}
    }
    
    public function changePassword(){
    	try {
    		$beanName=$this->phpbean;
    		$user=$_POST['user'];
    		$user_id=self::getSessionUserId();
    		 
    		$data['id']=$user_id;
    		$data['password']=self::getPasswordMD5($user['newpassword']);
    		D($beanName)->setPassword($data);
    		
    		$rtr['flag']=true;
    		$rtr['msg']="操作成功";
    		$this->ajaxReturn($rtr);
    	} catch (Exception $e) {
    		$rtr['flag']=false;
    		$rtr['msg']="操作失败";
    		$this->ajaxReturn($rtr);
    	}
    }
    
    public function getAll(){
    	$beanName=$this->phpbean;
    	$example['relation']=false;
    	
    	$example['condition']=$condition;
    	$rtr=D($beanName)->getAllList($example,$beanName);
    	$this->ajaxReturn($rtr);
    }
    
    public function getAllBusiness(){
    	$beanName=$this->phpbean;
    	$example['relation']=false;
    	$condition['type']=2;
    	$example['condition']=$condition;
    	$rtr=D($beanName)->getAllList($example,$beanName);
    	$this->ajaxReturn($rtr);
    }
    
    public function getAllNotBusiness(){
    	$beanName=$this->phpbean;
    	$example['relation']=false;
    	$condition['type']=array('neq',2);
    	$example['condition']=$condition;
    	$rtr=D($beanName)->getAllList($example,$beanName);
    	$this->ajaxReturn($rtr);
    }
    
    public function updatePassword() {
    	try {
    		$beanName=$this->phpbean;
    		$user=$_POST['user'];
    		$password=$user['password'];
    		$user_id=self::getSessionUserId();
    		$condition['id']=$user_id;
    		$condition['password']=self::getPasswordMD5($password);
    		$example['condition']=$condition;
    		$oldUser=D($beanName)->findRow($example,$beanName);
    		//     		$this->ajaxReturn($condition);
    		if (isset($oldUser)){
    			$newUser['password']=self::getPasswordMD5($user['newpassword']);
    			$newUser['id']=$user_id;
    			D($beanName)->setPassword($newUser,$beanName);
    			$rtr['flag']=true;
    			$rtr['msg']="操作成功";
    			$this->ajaxReturn($rtr);
    		}else {
    			$rtr['flag']=true;
    			$rtr['msg']="原始密码错误！";
    			$this->ajaxReturn($rtr);
    		}
    
    	} catch (\Exception $e) {
    		$rtr['flag']=false;
    		$rtr['msg']="操作失败";
    		$this->ajaxReturn($rtr);
    	}
    }
}