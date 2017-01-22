<?php
namespace Admin\Model;
use Think\Model;
use Admin\Common\Model\CommonRelationModel;
class RoleModel extends CommonRelationModel{
    
    protected $trueTableName =  'bbb_role';
    protected $_link = array(
        'access'=>array(
            'mapping_type'  => self::HAS_MANY,
            'class_name'  => 'Access',
            'foreign_key' => 'role_id',
            'mapping_name' => 'access'
        ),
        'parentRole'=>array(
            'mapping_type'  => self::BELONGS_TO,
            'class_name'  => 'Role',
            'parent_key' => 'pid',//是id，不是Id
            'mapping_name' => 'parentRole'
        ),
    );
    public function getRoleTree($example,$beanName){
    	$condition=$example['condition'];
    	$relation=$example['relation'];
    	return D($beanName)->field('id,name as text')->where($condition)->relation($relation)->select();
    }
    
}

?>