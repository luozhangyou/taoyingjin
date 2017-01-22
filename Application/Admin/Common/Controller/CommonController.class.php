<?php

/**
 * @author 小红有一种病<646469050@qq.com>
 * @link http://www.java321.com
 * @copyright Copyright (C) 2014 EWSD
 * @datetime 2016-03-16 12:40
 * @version 1.0
 * @description
 */

namespace Admin\Common\Controller;

use Think\Controller;
use Org\Util\Rbac;

class CommonController extends Controller {
    /**
     * 初始化
     * 如果 继承本类的类自身也需要初始化那么需要在使用本继承类的类里使用parent::_initialize();
     */
    public function _initialize() {
        //判断是否开启认证，并且当前模块需要验证
        if(C('USER_AUTH_ON')&&!in_array(MODULE_NAME, explode(',', C('NOT_AUTH_MODULE')))){
            //通过accessDecision获取权限信息
            if(!RBAC::AccessDecision()){
                //没有获取到权限信息时需要执行的代码
                //1、用户没有登录
                if(!$_SESSION[C('USER_AUTH_KEY')]){
                    $url= __ROOT__.'/';
                    $this->error("您还没有登录不能访问",$url);
                }
                $this->error("您没有操作权限");
            }
        }
    }
    
    /* public function checkLogin(){
    //表单数据不能为空
        if($_POST('username')&&$_POST('password')&&$_POST('verifycode')){
            $pwd=  $this->$_POST('password');
            $username=  $this->$_POST('username');
            //验证码是否正确
            $verify=  $this->$_POST('code');
            if($this->$_session('verify')!=  md5($verify)){
                $this->error("验证码错误");
            }else{
                //创建数据库对象
                $user=M('user');
                //根据用户名查询               
                $cond['account']=$username;
                $cond['active']=array('gt',0);
                //加载RBAC类
                import('ORG.Util.RBAC');
                //通过authenticate读取用户信息
                $result=RBAC::authenticate($cond);
                //dump($result);
                if($result){
                    if($result['password']==md5($pwd)){
                        $_SESSION[C('USER_AUTH_KEY')]=$result['id'];
                        //使用saveAccessList缓存访问权限
                        RBAC::saveAccessList();
                        $this->display('Manager:index');
                    }else{
                        $this->error("用户密码错误");
                    }
                }else{
                    $this->error("用户名不存在或已经被禁用");
                }
            }  
        }    
    } */
    
    public function getPasswordMD5($password){
        $password=md5($password);
        return $password;
    }
    
    public function getSessionUserId(){
    	if(null!=$_SESSION[C('USER_AUTH_KEY')]){
    		return $_SESSION[C('USER_AUTH_KEY')];
    	}
    }
    
}