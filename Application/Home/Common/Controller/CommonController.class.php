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