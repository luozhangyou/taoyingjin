<?php
namespace Admin\Model;
use Think\Model;
use Admin\Common\Model\CommonRelationModel;
class RoleUserModel extends CommonRelationModel{
    
    protected $trueTableName =  'bbb_role_user';
    
    public function delRoleUser($example){
    	$condition=$example['condition'];
    	$rtr=M("RoleUser")->where($condition)->delete();
    }
}

?>