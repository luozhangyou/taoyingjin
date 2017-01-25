<?php

/**
 * 淘宝客商品详情
 * @author auto create
 */
class NTbkItemDetail
{
	
	/** 
	 * 宝贝描述
	 **/
	public $description;
	
	/** 
	 * 淘客商品地址
	 **/
	public $item_click_url;
	
	/** 
	 * 卖家昵称
	 **/
	public $nick;
	
	/** 
	 * 商品ID
	 **/
	public $num_iid;
	
	/** 
	 * 商品主图
	 **/
	public $pict_url;
	
	/** 
	 * 宝贝所在地
	 **/
	public $provcity;
	
	/** 
	 * 商品一口价格
	 **/
	public $reserve_price;
	
	/** 
	 * 卖家id
	 **/
	public $seller_id;
	
	/** 
	 * 淘客店铺地址
	 **/
	public $shop_click_url;
	
	/** 
	 * 商品小图列表
	 **/
	public $small_images;
	
	/** 
	 * 商品标题
	 **/
	public $title;
	
	/** 
	 * 卖家类型，0表示集市，1表示商城
	 **/
	public $user_type;
	
	/** 
	 * 30天销量
	 **/
	public $volume;
	
	/** 
	 * 商品折扣价格
	 **/
	public $zk_final_price;	
}
?>