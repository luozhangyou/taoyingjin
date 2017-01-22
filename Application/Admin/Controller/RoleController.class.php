<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;
use Org\Util\Date;
class RoleController extends CommonController {
	public $phpbean="Role";
    
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
    		$data['pid']=0;
    		$rtr['flag']=true;
    		if ($data['id']>0){
    			$data['update_time']=time();
    			$rtr['object'] = D($beanName)->updateRow($data,$beanName);
    			$rtr['msg']="更新成功";
    			$this->ajaxReturn($rtr);
    		}else{
    			$data['create_time']=time();
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
    		$rtr['msg']="操作失败，此角色下面存在用户！";
    		$this->ajaxReturn($rtr);
    	}
    }
    
    public function authorization(){
    	$beanName="Access";
    	$data=$_POST['data'];
    	$condition['role_id']=$data['id'];
    	$example['condition']=$condition;
    	$example['relation']=true;
    	$oldSelectedNodes = D($beanName)->findRows($example,$beanName);
    	$newSelectedNodes = $data['nodeIds'];
    	$deleteNodes=array();
    	$addNodes=array();
    	if(null==$oldSelectedNodes){
    		$addNodes=$newSelectedNodes;
    	}else{
    		for($x=0;$x<count($newSelectedNodes);$x++){
    			for($y=0;$y<count($oldSelectedNodes);$y++){
    				if ($oldSelectedNodes[$y]['node_id']==$newSelectedNodes[$x]){
    					break;
    				}else if(count($oldSelectedNodes)==($y+1)){
    					array_push($addNodes,$newSelectedNodes[$x]);
    				}else {
    					 
    				}
    			}
    		}
    	}
    	
    	for($x=0;$x<count($addNodes);$x++){
    		$addNode['node_id']=$addNodes[$x];
    		$addNode['role_id']=$data['id'];
    		$addNode['level']=0;
    		$addNode['pid']=0;
    		$addNode['module']=0;
    		D($beanName)->addRow($addNode,$beanName);
    	}
    	for($x=0;$x<count($oldSelectedNodes);$x++){
    		if(null==$newSelectedNodes){
    			array_push($deleteNodes,$oldSelectedNodes[$x]['node_id']);
    		}else{
    			for($y=0;$y<count($newSelectedNodes);$y++){
    				if ($newSelectedNodes[$y]==$oldSelectedNodes[$x]['node_id']){
    					break;
    				}else if(count($newSelectedNodes)==($y+1)){
    					array_push($deleteNodes,$oldSelectedNodes[$x]['node_id']);
    				}else{
    					 
    				}
    			}
    		}
    		
    	}    		
    	if(count($deleteNodes)>0){
    		$deleteMap['node_id']  = array('in',"".implode(',',$deleteNodes));
    		$deleteMap['role_id']  = array('in',"".$data['id']);
    		$rtr['count'] = D($beanName)->delRowsByNodeAndRole($deleteMap,$beanName);
    	}
    	
    	$rtr['flag']=true;
    	$rtr['msg']="操作成功";
    	$this->ajaxReturn($rtr);
    }
    
    public function getRoleAccess(){
    	$beanName="Access";
    	$condition['role_id']=$_POST['role_id'];
    	$example['condition']=$condition;
    	$example['relation']=false;
    	$rtr=D($beanName)->getAllList($example,$beanName);
    	$this->ajaxReturn($rtr);
    }
    
    public function getTree(){
    	$beanName=$this->phpbean;
    	$example['relation']=false;
    	$rtr=D($beanName)->getRoleTree($example,$beanName);
    	$this->ajaxReturn($rtr);
    }
}