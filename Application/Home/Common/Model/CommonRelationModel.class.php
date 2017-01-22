<?php

/**
 * @author 孤傲的项链 <646469050@qq.com>
 * @link http://www.005920.com
 * @version 1.0
 * @description 公用模型
 */

namespace Home\Common\Model;
use Think\Model\RelationModel;
class CommonRelationModel extends RelationModel {

    public static function addRow($data,$beanName) {
        $object = D($beanName);
        $resultId=$object->add($data);
        return $resultId;
    }
    
    public static function delRows($data,$beanName){
    	$ids=$data['ids'];
    	return D($beanName)->relation(true)->delete($ids);
    }
    

    public static function delRowsByCondition($condition,$beanName){
    	return D($beanName)->where($condition)->delete();
    }
    
    public static function updateRow($data,$beanName) {
        $object = D($beanName);
        $result=$object->relation(true)->save($data);
        return $result;
    }
    
	public static function pageList($example,$beanName){
        $object = D($beanName);
        $order=$example['order'];
        $condition=$example['condition'];
        $pageBean=$example['pageBean'];
        $relation=$example['relation'];
        $result=$object->
		        where($condition)->
		        order($order['sort'].' '.$order['order'])->
		        page($pageBean['page'],$pageBean['rows'])->relation($relation)->select();
        return $result;
    }
    
    public static function countTotal($example,$beanName){
        return $count = D($beanName)->where($condition)->count();
    }
    
    public static function findRow($example,$beanName){
        $object = D($beanName);
        $condition=$example['condition'];
        $relation=$example['relation'];
        $result=$object->where($condition)->
        		relation($relation)->find();
        return $result;
    }
    
    public static function findRows($example,$beanName){
    	$object = D($beanName);
    	$condition=$example['condition'];
    	$relation=$example['relation'];
    	$result=$object->where($condition)->
    	relation($relation)->select();
    	return $result;
    }
    
    public function getAllList($example,$beanName){
    	$condition=$example['condition'];
    	$relation=$example['relation'];
        return D($beanName)->where($condition)->relation($relation)->select();
    }
    
    public function getAllCount($data,$beanName){
    	return D($beanName)->count();
    }
    
    public static function findByColumn($value,$columnName,$beanName){
        $object = D($beanName);
        $result=$object->relation(true)->
        where($columnName.'="'.$value.'"')->select();
        return $result;
    }
    
    
}

?>
