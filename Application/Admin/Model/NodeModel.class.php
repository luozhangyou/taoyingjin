<?php
namespace Admin\Model;
use Think\Model;
use Admin\Common\Model\CommonRelationModel;
use Think\Model\RelationModel;
class NodeModel extends CommonRelationModel{
    
    protected $trueTableName =  'bbb_node';
    protected $_link = array(
        'parentNode'=>array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'  => 'Node',
            'parent_key' => 'pid',//是id，不是Id
            'mapping_name' => 'parentNode'
        ),
    	'Node'=>array(
    			'mapping_type'  => self::HAS_MANY,
    			'class_name'  => 'Node',
    			'parent_key' => 'pid',
    			'mapping_name' => 'children',
    			/* "mapping_fields"=>array('photoid','src'),
    			 "as_fields"=>"src,photoid:photoid" */
    			// 定义更多的关联属性
    	),
    );

    public function getComboTree($example,$beanName){
    	$condition=$example['condition'];
    	$relation=$example['relation'];
    	return D($beanName)->field('id,title as text')->where($condition)->relation($relation)->select();
    }
    
    /**
     *获取当前角色菜单列表
     */
    
    public function roleNodes($example,$beanName){
    	$object = D($beanName);
    	$order=$example['order'];
    	$condition=$example['condition'];
    	$relation=$example['relation'];
    	$result=$object->
    	distinct(true)->
    	field('n.id,n.name,n.title,n.type')->
    	alias('n')->
    	join('LEFT JOIN __ACCESS__ a ON n.id = a.node_id')->
    	join('LEFT JOIN __ROLE_USER__ ru ON ru.role_id = a.role_id')->
    	where($condition)->
    	order($order['sort'].' '.$order['order'])->
    	relation($relation)->select();
    	return $result;
    }
}

?>