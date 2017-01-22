<?php

/**
 * @author 小红有一种病<646469050@qq.com>
 * @link http://www.java321.com
 * @copyright Copyright (C) 2014 EWSD
 * @datetime 2014-10-15 12:40
 * @version 1.0
 * @description
 */

namespace Home\Common\Controller;

use Think\Controller;

class CommonController extends Controller {
    public function _initialize() {
    	
        /* $menuItemList=$this->getMenuItemOfTopList($data);//获取菜单
        $this->assign('menuItemList',$menuItemList);
        
        $categoryList=$this->getCategoryOfTopList($data);//获取所有顶级分类
        $this->assign('categoryList',$categoryList);
        
        $singleList=$this->getSingleList($data);//获取所有单页
        $this->assign('singleList',$singleList);
        
        $linkList=$this->getLinkList($data);//获取所有友情链接
        $this->assign('linkList',$linkList); */
        
    }
	public function getSessionUserId(){
    	if(null!=$_SESSION[C('USER_AUTH_KEY')]){
    		return $_SESSION[C('USER_AUTH_KEY')];
    	}
    }
    
    public function isLogin(){
    	if(null!=$_SESSION[C('USER_AUTH_KEY')]){
    		return true;
    	}else {
    		return false;
    	}
    }
}