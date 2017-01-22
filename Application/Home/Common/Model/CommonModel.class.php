<?php

/**
 * @author 孤傲的项链 <646469050@qq.com>
 * @link http://www.005920.com
 * @version 1.0
 * @description 公用模型
 */

namespace Home\Common\Model;

use Think\Model;

class CommonModel extends BaseModel {

    public static function addRow($data,$beanName) {
        $object = D($beanName);
        $result=$object->add($data);
        return "success";
    }
    
    public static function updateRow($data,$beanName) {
        $object = D($beanName);
        $result=$object->save($data);
        return "success";
    }
    
    public static function listPage($pageBean,$example,$beanName){
        $object = D($beanName);
        $order=$example['order'];
        $result=$object->
        order($order['sort'].' '.$order['order'])->
        page($pageBean['page'],$pageBean['rows'])->select();
        return $result;
    }
    
    public static function countTotal($example,$beanName){
        return $count = D($beanName)->count();
    }
    
    public static function delRows($data,$beanName){
        $ids=$data['ids'];
        return D($beanName)->delete($ids);
    }
    
    public static function findById($data,$beanName){
        $object = D($beanName);
        $result=$object->
        where('id='.$data['id'])->select();
        return $result;
    }
    
    public static function getObjects($data,$beanName){
        return D($beanName)->select();
    }
    
}

?>
