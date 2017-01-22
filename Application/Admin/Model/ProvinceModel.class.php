<?php
namespace Admin\Model;
use Think\Model;
use Admin\Common\Model\CommonRelationModel;
class ProvinceModel extends CommonRelationModel{
    
    protected $trueTableName =  'bbb_province';
    protected $_link = array(
           
    );
    public function getComboTree($example,$beanName){
    	$condition=$example['condition'];
    	$relation=$example['relation'];
    	return D($beanName)->field('id,name as text')->where($condition)->relation($relation)->select();
    }
}

?>