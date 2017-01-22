<?php
namespace Admin\Model;
use Think\Model;
use Admin\Common\Model\CommonRelationModel;
class MessageUserModel extends CommonRelationModel{
    
    protected $trueTableName =  'bbb_message_user';
    protected $_link = array(
    		
    );
    
    //获取分页用户消息
    public function messageUserPageList($example,$beanName){
    	$object = D($beanName);
    	
    	$order=$example['order'];
        $condition=$example['condition'];
        $pageBean=$example['pageBean'];
        
    	$result=$object->
	    	field('mu.id,mu.status,m.name,m.url,m.content,m.type,m.create_time')->
	    	alias('mu')->
	    	join('LEFT JOIN __MESSAGE__ m ON m.id = mu.message_id')->
	    	where($condition)->
    		order($order['sort'].' '.$order['order'])->
		    page($pageBean['page'],$pageBean['rows'])->select();
    	return $result;
    }
    
    public function messageUserCount($example,$beanName){
    	$object = D($beanName);
    	$condition=$example['condition'];
    	$result=$object->
    	field('mu.id')->
    	alias('mu')->
    	join('LEFT JOIN __MESSAGE__ m ON m.id = mu.message_id')->
    	where($condition)->count();
    	return $result;
    }
    
    public function updateStatus($data,$example,$beanName){
    	$object = M($beanName);
    	if($data['id']>0){
    		$data['status']=2;
    		$object = D($beanName);
    		$result=$object->field('status')->save($data);
    		return $result;
    	}else{
    		$condition=$example['condition'];
    		$messageUser['status']=2;
    		$object = D($beanName);
    		$result=$object->field('status')->where($condition)->save($messageUser);
    		return $result;
    	}
    	
    	return $result;
    }
    
}

?>