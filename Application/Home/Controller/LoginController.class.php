<?php
namespace Home\Controller;
use Think\Verify;
use Org\Util\Rbac;
use Home\Common\Controller\CommonController;
class LoginController extends CommonController {
	//获取验证码图片
	public function getVerify(){
		$verify=new Verify();
		$verify->entry(1);
	}
	// 检测输入的验证码是否正确，$code为用户输入的验证码字符串
	function login($userName="",$password="",$code="",$id=1){
		$verify = new Verify();
		$flagCheck=$verify->check($code, $id);
		if($flagCheck){
			$user=M('user');
			//根据用户名查询
			$cond['account']=$userName;
			$cond['active']=array('gt',0);
			//通过authenticate读取用户信息
			$result=RBAC::authenticate($cond);
			$rtr=null;
			if($result){
				if($result['password']==md5($password)){
					$_SESSION[C('USER_AUTH_KEY')]=$result['id'];
					$_SESSION["nickname"]=$result['nickname'];
					$_SESSION["user_type"]=$result['type'];
					RBAC::saveAccessList();
					echo "<SCRIPT language=JavaScript>location.href='".__ROOT__."/Admin/Index/index';</SCRIPT>";
	
				}else{
					echo "<SCRIPT language=JavaScript>alert('用户密码错误');</SCRIPT>";
					$this->display('Index/login_manage');
				}
			}else{
				echo "<SCRIPT language=JavaScript>alert('帐号不存在');</SCRIPT>";
				$this->display('Index/login_manage');
			}
		}else {
			echo "<SCRIPT language=JavaScript>alert('验证码不存在');</SCRIPT>";
			$this->display('Index/login_manage');
		}
	}
	public function logout_manange(){
		session_destroy();
		echo "<SCRIPT language=JavaScript>location.href='".__ROOT__."/Home/Index/login_manage';</SCRIPT>";
	}
	
	// 检测输入的验证码是否正确，$code为用户输入的验证码字符串
	function login_business($userName="",$password="",$code="",$id=1){
		$verify = new Verify();
		$flagCheck=$verify->check($code, $id);
		if($flagCheck){
			$user=M('user');
			//根据用户名查询
			$cond['account']=$userName;
			$cond['active']=array('gt',0);
			//通过authenticate读取用户信息
			$result=RBAC::authenticate($cond);
			$rtr=null;
			if($result){
				if($result['password']==md5($password)){
					$_SESSION[C('USER_AUTH_KEY')]=$result['id'];
					$_SESSION["nickname"]=$result['nickname'];
					$_SESSION["user_type"]=$result['type'];
					RBAC::saveAccessList();
					echo "<SCRIPT language=JavaScript>location.href='".__ROOT__."/Admin/BusinessCenter/order';</SCRIPT>";
	
				}else{
					echo "<SCRIPT language=JavaScript>alert('用户密码错误');</SCRIPT>";
					$this->display('Index/login_business');
				}
			}else{
				echo "<SCRIPT language=JavaScript>alert('帐号不存在');</SCRIPT>";
				$this->display('Index/login_business');
			}
		}else {
			echo "<SCRIPT language=JavaScript>alert('验证码不存在');</SCRIPT>";
			$this->display('Index/login_business');
		}
	}
	
	public function logout_business(){
		session_destroy();
		echo "<SCRIPT language=JavaScript>location.href='".__ROOT__."/Home/Index/login_business';</SCRIPT>";
	}
	
	// 检测输入的验证码是否正确，$code为用户输入的验证码字符串
	function login_customer($userName="",$password="",$code="",$id=1,$returnUrl=""){
		$user=M('user');
		//根据用户名查询
		$cond['account']=$userName;
		$cond['status']=array('gt',0);
		//通过authenticate读取用户信息
		$result=RBAC::authenticate($cond);
		if($result){
			if($result['password']==md5($password)){
				$_SESSION[C('USER_AUTH_KEY')]=$result['id'];
				$_SESSION["nickname"]=$result['nickname'];
				$_SESSION["user_type"]=$result['type'];
				RBAC::saveAccessList();
				//处理本地购物车缓存写入数据库
				
				$cartList=cookie('cartList');
				for ($i=0;$i<count($cartList);$i++){
					$cart=explode("_",$cartList[$i]);
					$cartValue=$cart[0].'_'.$cart[1].'_'.$cart[2];
					if(cookieIsExist($cart[0],$cart[1],$cart[2])){
						//如果存在不做任何处理
					}else{
						$row['business_id']=$cart[0];
						$row['service_id']=$cart[1];
						$row['district_id']=$cart[2];
						$row['number']=$cart[3];
						$row['status']=1;
						$row['user_id']=$result['id'];
						$row['create_time']=time();
						$row['create_user']=$result['id'];
						$beanName="Cart";
						D($beanName)->addRow($row,$beanName);
					}
				}
				cookie('cartList',null);
				
				$rtr['flag']=true;
				$rtr['msg']="登录成功";
				$rtr['returnUrl']=$returnUrl;
				$this->ajaxReturn($rtr);
			}else{
				$rtr['flag']=false;
	    		$rtr['msg']="密码错误";
	    		$this->ajaxReturn($rtr);
			}
		}else{
			$rtr['flag']=false;
    		$rtr['msg']="帐号不存在";
    		$this->ajaxReturn($rtr);
		}
	}
	
	public function logout_customer(){
		session_destroy();
		echo "<SCRIPT language=JavaScript>location.href='".__ROOT__."/Home/Index/login';</SCRIPT>";
	}
}