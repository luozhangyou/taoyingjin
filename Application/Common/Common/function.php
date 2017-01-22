<?php

/**
 * 获取商品分类列表
 */
function serviceCatList(){
    $cats = S("CACHE_SERVICECAT_LIST_WEB");
	if(!$cats){
		$beanName = "ServiceCat";
		$example['relation']=true;
		$condition['pid']=0;
		$example['condition']=$condition;
		$cats=D($beanName)->getAllList($example,$beanName);
		
		S("CACHE_SERVICECAT_LIST_WEB",$cats,31536000);
	}
	return $cats;
}


/**
 * 获取购物车数量
 */
function countCart(){
	$count=0;
	if(sessionLogin()&&sessionUserType()==3){
		$condition['c.user_id']=sessionLogin();
		$example['condition']=$condition;
		$count=D("Cart")->cartListCount($example,"Cart");
	}else {
		$count=count(cookie('cartList'));
	}
	return $count;
}

/**
 * 获取分类下面业务列表
 */
function serviceListByCat($service_cat_id){
	$beanName = "Service";
	$example['relation']=true;
	$condition['service_cat_id']=$service_cat_id;
	$example['condition']=$condition;
	$services=D($beanName)->findRows($example,$beanName);
	return $services;
}

/**
 * 判断就否登录
 */
function sessionLogin(){
	if(null!=$_SESSION[C('USER_AUTH_KEY')]){
    	return $_SESSION[C('USER_AUTH_KEY')];
    }
}

/**
 * 判断就否登录
 */
function sessionUserType(){
	if(null!=$_SESSION['user_type']){
		return $_SESSION['user_type'];
	}
}

/**
 * 获取登录名
 */
function sessionName(){
	return $_SESSION['nickname'];
}

/**
 * 获取唯一定单号
 */
function order_number(){
	static $ORDERSN=array();                                        //静态变量
	$ors=date('ymd').substr(time(),-5).substr(microtime(),2,5);     //生成16位数字基本号
	if (isset($ORDERSN[$ors])) {                                    //判断是否有基本订单号
		$ORDERSN[$ors]++;                                           //如果存在,将值自增1
	}else{
		$ORDERSN[$ors]=1;
	}
	return $ors.str_pad($ORDERSN[$ors],2,'0',STR_PAD_LEFT);     //链接字符串
}

/**
 * 获取所有省份
 */
function provinceAll(){
	$beanName="Province";
	$example['relation']=false;
	$rtr=D($beanName)->getAllList($example,$beanName);
	return $rtr;     //链接字符串
}