<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;
class IndexController extends CommonController {
    public function index(){
    	$user_id=self::getSessionUserId();
    	$beanName="Node";
    	
    	$order['sort']="id";
    	$order['order']="asc";
    	$example['order']=$order;
    	
    	$example['relation']=false;
    	$condition['n.type']=1;
    	$condition['n.level']=2;
    	$condition['ru.user_id']=$user_id;
    	$example['condition']=$condition;
    	$rtr = D($beanName)->roleNodes($example,$beanName);//
    	for ($x=0;$x<count($rtr);$x++){
    		$condition['n.pid']=$rtr[$x]['id'];
    		$condition['n.level']=3;
    		$example['condition']=$condition;
    		$rtr[$x]['children']=D($beanName)->roleNodes($example,$beanName);
    	}
    	$this->assign('menuList',$rtr);
    	
		$this->display();
    }
    
    public function console(){
    	$this->display();
    }
    
    //缓存清除
    //获取要清楚的目录和目录所在的绝对路径
    public function clearcache(){
    	////前台用ajax get方式进行提交的，这里是先判断一下
    	if($_POST['type']){
    		//得到传递过来的值
    		$type=$_POST['type'];
    		//将传递过来的值进行切割，我是用“-”进行切割的
    		$name=explode('-', $type);
    		//得到切割的条数，便于下面循环
    		$count=count($name);
    		//循环调用上面的方法
    		for ($i=0;$i<$count;$i++){
    			//得到文件的绝对路径
    			$abs_dir=dirname(dirname(dirname(dirname(__FILE__))));
    			//组合路径
    			$pa=$abs_dir.'\Application\Runtime\Cache\\';
    			$runtime=$abs_dir.'\Application\Runtime\\~runtime.php';
    			if(file_exists($runtime))//判断 文件是否存在
    			{
    				//unlink($runtime);//进行文件删除
    			}
    			//调用删除文件夹下所有文件的方法
    			$this->rmFile($pa,$name[$i]);
    		}
    		//给出提示信息
    		$rtr['flag']=true;
    		$rtr['msg']="操作成功！";
    		$this->ajaxReturn($rtr);
    	}else{
    		$rtr['flag']=false;
    		$rtr['msg']="操作失败！";
    		$this->ajaxReturn($rtr);
    	}
    }
    public function rmFile($path,$fileName){//删除执行的方法
    	//去除空格
    	//得到完整目录
    	$path.= $fileName;
    	//判断此文件是否为一个文件目录
    	if(is_dir($path)){
    		//打开文件
    		if (($dh = opendir($path)) !== false){
    			//遍历文件目录名称
    			while (($file = readdir($dh)) != false){
    				//逐一进行删除
    				unlink($path.'\\'.$file);
    			}
    			//关闭文件
    			closedir($dh);
    		}
    	}
    }
}