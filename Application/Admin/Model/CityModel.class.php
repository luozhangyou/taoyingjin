<?php
namespace Admin\Model;
use Think\Model;
use Admin\Common\Model\CommonRelationModel;
class CityModel extends CommonRelationModel{
    
    protected $trueTableName =  'bbb_city';
    protected $_link = array(
           
    );
    public function getComboTree($example,$beanName){
    	$condition=$example['condition'];
    	$relation=$example['relation'];
    	return D($beanName)->field('id,name as text')->where($condition)->relation($relation)->select();
    }
}

?>