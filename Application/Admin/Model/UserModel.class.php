<?php
namespace Admin\Model;
use Think\Model;
use Admin\Common\Model\CommonRelationModel;
class UserModel extends CommonRelationModel{
    
    protected $trueTableName =  'bbb_user';
    protected $_link = array(
        /* 'UserAttachment'=>array(
            'mapping_type'  => self::HAS_ONE,
            'class_name'  => 'UserAttachment',
            'foreign_key' => 'user_id',
            'mapping_name' => 'userAttachment'
        ), */
        'roleUser'=>array(
            'mapping_type'  => self::HAS_ONE,
            'class_name'  => 'RoleUser',
            'foreign_key' => 'user_id',
            'mapping_name' => 'roleUser'
        )
    );
    
    public function setPassword($data){
    	$User = M("User");
    	$User->where('id='.$data[id])->field('password')->save($data);
    }
    
    public function updateUser($data,$beanName) {
    	$object = M($beanName);
    	$result=$object->field('id,account,nickname,remark,status')->filter('strip_tags')->save($data);
    	return $result;
    }
    
    public function updateCustomerUser($data,$beanName) {
    	$object = M($beanName);
    	$result=$object->field('address,province_id,city_id,district_id,where_know_csb')->filter('strip_tags')->save($data);
    	return $result;
    }
    
    public function changemobile($data,$beanName) {
    	$object = M($beanName);
    	$result=$object->field('account,id')->filter('strip_tags')->save($data);
    	return $result;
    }
    
}

?>