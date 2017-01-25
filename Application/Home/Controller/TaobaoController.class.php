<?php
namespace Home\Controller;
use Home\Common\Controller\CommonController;
class TaobaoController extends CommonController {
    
    public function taobao_atb_items_get(){

        Vendor('Topbc.TopClient');
        Vendor('Topbc.ResultSet');
        Vendor('Topbc.TopLogger');
        Vendor('Topbc.RequestCheckUtil');
        Vendor('Topbc.request.AtbItemsGetRequest');
        
        $c = new \TopClient();
        $c->appkey = C('TB_APP_KEY_TGJ');
        $c->secretKey = C('TB_APP_SECRET_TGJ');
        $req = new \AtbItemsGetRequest();
        $req->setCid("杭州");
        $req->setFields("open_iid");
        $resp = $c->execute($req);

        $this->ajaxReturn($resp);
    }
    
    
    public function taobao_tbk_item_detail_get(){
    
        Vendor('Topbc.TopClient');
        Vendor('Topbc.ResultSet');
        Vendor('Topbc.TopLogger');
        Vendor('Topbc.RequestCheckUtil');
        Vendor('Topbc.request.TbkItemDetailGetRequest');
        
        $c = new \TopClient;
        $c->appkey = C('TB_APP_KEY_TGJ');
        $c->secretKey = C('TB_APP_SECRET_TGJ');
        $req = new \TbkItemDetailGetRequest;
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,description,item_click_url,shop_click_url");
        $req->setNumIids("541399859609");
        $req->setPlatform("1");
        $req->setAdzoneId("53042943");
        $req->setUnid("demo");
        $resp = $c->execute($req);
    
        $this->ajaxReturn($resp);
    }
    
    public function taobao_tbk_item_info_get(){
    
        Vendor('Topbc.TopClient');
        Vendor('Topbc.ResultSet');
        Vendor('Topbc.TopLogger');
        Vendor('Topbc.RequestCheckUtil');
        Vendor('Topbc.request.TbkItemInfoGetRequest');
    
        $c = new \TopClient;
        $c->appkey = C('TB_APP_KEY_TGJ');;
        $c->secretKey = C('TB_APP_KEY_TGJ');
        $req = new \TbkItemInfoGetRequest;
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url");
        $req->setPlatform("1");
        $req->setNumIids("123,456");
        $resp = $c->execute($req);
    
        $this->ajaxReturn($resp);
    }
    
}