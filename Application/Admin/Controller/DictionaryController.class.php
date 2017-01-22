<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;
use Org\Util\Date;
class DictionaryController extends CommonController {
	public $phpbean="Dictionary";
    
    public function pageList(){
    	$beanName=$this->phpbean;
		
    	$pageBean['rows']=$_GET['rows'];
    	$pageBean['page']=$_GET['page'];
    	$example['pageBean']=$pageBean;
    	
    	$order['sort']=$_GET['sort'];
    	$order['order']=$_GET['order'];
    	$example['order']=$order;
    	
    	$example['relation']=false;
    	
    	$condition['pid']=0;
    	$example['condition']=$condition;
    	
    	$rtr = D($beanName)->pageList($example,$beanName);
    	
    	for ($x=0; $x<count($rtr); $x++) {
    		$condition['pid']=$rtr[$x]['id'];
    		$example['condition']=$condition;
    		$rtr[$x]['children']=D($beanName)->getAllList($example,$beanName);
    	}
    	
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
    			$rtr['object'] = D($beanName)->updateRow($data,$beanName);
    			$rtr['msg']="更新成功";
    			$this->ajaxReturn($rtr);
    		}else{
    			$rtr['object']= D($beanName)->addRow($data,$beanName);
    			$rtr['msg']="添加成功";
    			$this->ajaxReturn($rtr);
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
    
    public function getCombobox(){
    	$beanName=$this->phpbean;
    	$condition['pid']=0;
    	$example['condition']=$condition;
    	$example['relation']=false;
    	$rtr=D($beanName)->getAllList($example,$beanName);
    	$this->ajaxReturn($rtr);
    }
    
    public function getRowByCode(){
    	$beanName=$this->phpbean;
    	$data=$_POST['data'];
    	$condition['code']=$data['code'];
    	$example['condition']=$condition;
    	$example['relation']=true;
    	$rtr=D($beanName)->findRow($example,$beanName);
    	$rtr=$rtr['children'];
    	$this->ajaxReturn($rtr);
    }
}