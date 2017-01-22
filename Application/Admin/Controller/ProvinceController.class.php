<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;
use Org\Util\Date;
use Org\Util\Pinyin;
class ProvinceController extends CommonController {
	public $phpbean="Province";
    
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
    		$data=$_POST['data'];
    		$rtr['flag']=true;
    		if ($data['id']>0){
    			
    			$rtr['object'] = D($beanName)->updateRow($data,$beanName);
    			$rtr['msg']="更新成功";
    			$this->ajaxReturn($rtr);
    		}else{
    			$py = new PinYin();
    			$data['pingyin']=$py->getAllPY($data['name']);
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
    
    public function getAllProvince(){
    	$beanName=$this->phpbean;
    	$example['relation']=false;
    	$condition=array();
    	if (null!=$_GET['is_open']){
    		$condition['is_open']=$_GET['is_open'];
    	}
    	$example['condition']=$condition;
    	$rtr=D($beanName)->getAllList($example,$beanName);
    	$this->ajaxReturn($rtr);
    }
    
    public function provinceTree(){
    	$beanName=$this->phpbean;
    	
    	$condition['is_open']=1;
    	$example['relation']=false;
    	$example['condition']=$condition;
    	$rtr = D($beanName)->getComboTree($example,$beanName);
    	
    	for ($x=0; $x<count($rtr); $x++) {
    		$condition['province_id']=$rtr[$x]['id'];
    		$example['condition']=$condition;
    		$children=D("City")->getComboTree($example,"City");
    		
    		for ($y=0;$y<count($children);$y++){
    			$condition['city_id']=$children[$y]['id'];
    			$example['condition']=$condition;
    			$children[$y]['children']=D("District")->getComboTree($example,"District");
    		}
    		$rtr[$x]['children']=$children;
    	}
    	 
    	$this->ajaxReturn($rtr);
    }
    
}