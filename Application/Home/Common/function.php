<?php

/**
 * 获取此业务开通省列表
 */
function provinceList($service_id){
	$beanName = "ServiceDistrict";
	$condition['service_id']=$service_id;
	$example['condition']=$condition;
	$provinceList=D($beanName)->provinceList($example,$beanName);
	return $provinceList;
}

/**
 * 获取开通城市列表
 */
function cityList($province_id,$service_id){
	$beanName = "ServiceDistrict";
	$condition['service_id']=$service_id;
	$condition['province_id']=$province_id;
	$example['condition']=$condition;
	$cityList=D($beanName)->cityList($example,$beanName);
	return $cityList;
}

/**
 * 获取开通区域列表
 */
function districtList($city_id,$service_id){
	$beanName = "ServiceDistrict";
	$condition['service_id']=$service_id;
	$condition['city_id']=$city_id;
	$example['condition']=$condition;
	$districtList=D($beanName)->districtList($example,$beanName);
	return $districtList;
}

/**
 * 判断缓存数据是否存在登录用户购物车
 */
function cookieIsExist($business_id,$service_id,$district_id){
	$flag=false;
	$beanName = "Cart";
	$condition['business_id']=$business_id;
	$condition['service_id']=$service_id;
	$condition['district_id']=$district_id;
	$condition['user_id']=$_SESSION[C('USER_AUTH_KEY')];
	$example['condition']=$condition;
	
	$count=D($beanName)->cookieIsExist($example,$beanName);
	if($count>0){
		$flag=true;
	}
	return $flag;
}

/**
 * 获取商家对应业务的价格
 */
function BusinessServicePrice($business_id,$service_id,$district_id){
	$beanName = "BusinessService";
	$price=D($beanName)->price($example,$beanName);
	return $price;
}

/**
 * 根据IP获取城市
 */
function WSTIPAddress(){
	$url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$queryIP; 
    $ch = curl_init($url); 
    curl_setopt($ch, CURLOPT_ENCODING ,'utf8'); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $location = curl_exec($ch); 
    curl_close($ch);
    if($location){
    	$location = json_decode($location);
    	return array('province'=>$location->province,'city'=>$location->city,'district'=>$location->district);
    }
    return array();
}


