<?php
namespace Admin\Model;
use Think\Model;
use Admin\Common\Model\CommonRelationModel;
use Think\Model\RelationModel;
class AccessModel extends CommonRelationModel{
    
    protected $trueTableName =  'bbb_access';
    protected $_link = array(
        
    );
    public static function delRowsByNodeAndRole($deleteMap,$beanName){
    	return D($beanName)->where($deleteMap)->delete();
    }
}

?>