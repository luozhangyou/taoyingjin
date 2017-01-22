<?php
namespace Admin\Model;
use Think\Model;
use Admin\Common\Model\CommonRelationModel;
class DictionaryModel extends CommonRelationModel{
    
    protected $trueTableName =  'bbb_dictionary';
    protected $_link = array(
    	'children'=>array(
    			'mapping_type'  => self::HAS_MANY,
    			'class_name'  => 'Dictionary',
    			'parent_key' => 'pid',
    			'mapping_name' => 'children',
    				/* "mapping_fields"=>array('photoid','src'),
    				 "as_fields"=>"src,photoid:photoid" */
    				// 定义更多的关联属性
    	), 
    	
    );
    
}

?>