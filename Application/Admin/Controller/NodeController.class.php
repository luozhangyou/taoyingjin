<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;
class NodeController extends CommonController {
	public $phpbean="Node";
    public function getSessionNodeList(){
    	$beanName=$this->phpbean;
    	$example['relation']=true;
    	$condition['type']=1;
    	$condition['level']=2;
    	$example['condition']=$condition;
    	$rtr = D($beanName)->getAllList($example,$beanName);
    	$this->ajaxReturn($rtr);
    }
    public function pageList(){
    	$beanName=$this->phpbean;

    	$pageBean['rows']=$_GET['rows'];
    	$pageBean['page']=$_GET['page'];
    	$example['pageBean']=$pageBean;
    	
    	$order['sort']=$_GET['sort'];
    	$order['order']=$_GET['order'];
    	$example['order']=$order;
    	
    	$condition['level']=2;
    	$example['relation']=true;
    	
    	$example['condition']=$condition;
    	
    	$rtr = D($beanName)->pageList($example,$beanName);
    	$total= D($beanName)->countTotal($example,$beanName);
    	
    	$data=array(
    			'rows' => $rtr,
    			'total' => $total
    	);
    	$this->ajaxReturn($data);
    	
    }
    
    public function getCombotree(){
    	$beanName=$this->phpbean;
    
    	$order['sort']=$_GET['sort'];
    	$order['order']=$_GET['order'];
    	$example['order']=$order;
    	 
    	$condition['level']=1;
    	$example['relation']=false;
    	$example['condition']=$condition;
    	 
    	$rtr = D($beanName)->getComboTree($example,$beanName);

    	$condition['level']=2;
    	for ($x=0; $x<count($rtr); $x++) {
    		$condition['pid']=$rtr[$x]['id'];
    		$example['condition']=$condition;
    		
    		$children=D($beanName)->getComboTree($example,$beanName);
    		$condition['level']=3;
    		for ($y=0;$y<count($children);$y++){
    			$condition['pid']=$children[$y]['id'];
    			$example['condition']=$condition;
    			$children[$y]['children']=D($beanName)->getComboTree($example,$beanName);
    		}
    		$rtr[$x]['children']=$children;
    	}
    	
    	$this->ajaxReturn($rtr);
    }
    
    public function getParent(){
    	$beanName=$this->phpbean;
    
    	$order['sort']=$_GET['sort'];
    	$order['order']=$_GET['order'];
    	$example['order']=$order;
    
    	$condition['level']=1;
    	$example['relation']=false;
    	$example['condition']=$condition;
    
    	$rtr = D($beanName)->getComboTree($example,$beanName);
    
    	$condition['level']=2;
    	for ($x=0; $x<count($rtr); $x++) {
    		$condition['pid']=$rtr[$x]['id'];
    		$example['condition']=$condition;
    
    		$children=D($beanName)->getComboTree($example,$beanName);
    		/* $condition['level']=3;
    		 for ($y=0;$y<count($children);$y++){
    		 $condition['pid']=$children[$y]['id'];
    		 $example['condition']=$condition;
    		 $children[$y]['children']=D($beanName)->getComboTree($example,$beanName);
    		} */
    		$rtr[$x]['children']=$children;
    	}
    
    	$this->ajaxReturn($rtr);
    }
    
    public function addOrUpdate(){
    	try {
    		$beanName=$this->phpbean;
    		$data=$_POST['data'];
    		$data['sort']='50';
    		$rtr['flag']=true;
    		if ($data['id']>0){
    			$rtr['object'] = D($beanName)->updateRow($data,$beanName);
    			$rtr['msg']="更新成功";
    			$this->ajaxReturn($rtr);
    		}else{
    			$rtr['object']= D($beanName)->addRow($data,$beanName);
    			$rtr['msg']="添加成功";
    			$this->ajaxReturn($rtr);
    		}
    	} catch (\Exception $e) {
    		$rtr['flag']=false;
    		$rtr['msg']="系统错误，请联系管理员！";
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
    		$rtr['msg']="操作失败，存在角色已使用此权限！";
    		$this->ajaxReturn($rtr);
    	}
    }
    
    
}