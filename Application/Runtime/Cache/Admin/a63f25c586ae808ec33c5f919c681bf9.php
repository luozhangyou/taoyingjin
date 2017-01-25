<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
 <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" content="ie=edge" />
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <title>后台管理系统</title>
 
 <link rel="stylesheet" type="text/css" href="/taoyongjin/Public/Admin/widget/jquery-easyui-1.4.4/themes/bootstrap/easyui.css" />
 <link rel="stylesheet" type="text/css" href="/taoyongjin/Public/Admin/widget/jquery-easyui-1.4.4/themes/icon.css" />
 <script type="text/javascript" src="/taoyongjin/Public/Admin/widget/jquery-easyui-1.4.4/jquery.min.js"></script>
 <script type="text/javascript" src="/taoyongjin/Public/Admin/widget/jquery-easyui-1.4.4/jquery.easyui.min.js"></script>
 <script type="text/javascript" src="/taoyongjin/Public/Admin/widget/jquery-easyui-1.4.4/locale/easyui-lang-zh_CN.js"></script>
  
 <script type="text/javascript" src="/taoyongjin/Public/Admin/theme/defalut/js/objFunc.js"></script>
 <script type="text/javascript" src="/taoyongjin/Public/Admin/theme/defalut/js/jquery.ajax.js"></script> 
 <script type="text/javascript" src="/taoyongjin/Public/Admin/theme/defalut/js/util.js"></script>  
 <link rel="stylesheet" type="text/css" href="/taoyongjin/Public/Admin/widget/4.2.0/css/font-awesome.min.css" />
 <link rel="stylesheet" type="text/css" href="/taoyongjin/Public/Admin/theme/defalut/css/style.css" />
 <link rel="stylesheet" type="text/css" href="/taoyongjin/Public/Admin/theme/defalut/css/expand.css" /> 
 

<link rel="stylesheet" type="text/css" href="/taoyongjin/Public/Admin/widget/umeditor1_2_2-utf8-php/themes/default/css/umeditor.min.css" />
<script type="text/javascript" src="/taoyongjin/Public/Admin/widget/umeditor1_2_2-utf8-php/umeditor.config.js"></script>
<script type="text/javascript" src="/taoyongjin/Public/Admin/widget/umeditor1_2_2-utf8-php/umeditor.min.js"></script>
<script type="text/javascript" src="/taoyongjin/Public/Admin/widget/umeditor1_2_2-utf8-php/lang/zh-cn/zh-cn.js"></script>

</head>
<body class="easyui-layout">
 <div class="top" id="topBg" data-options="region:'north',height:'62px',border:false">
  <script language="javascript">
$(function(){
	$("#clearCache").click(function(){
		var o={};
		o['type']="Admin-Home";
		var obj=ajaxReturnList("/taoyongjin/Admin/Index/clearCache",o);
		$.messager.alert('系统提示', obj.msg , 'info');
	});
	
	$('#updatePassword').tooltip({
        content: $('<div></div>'),
        showEvent: 'click',
        onUpdate: function(content){
            content.panel({
                width: 320,
                heiht: 400,
                border: false,
                title: '修改密码',
                href: '/taoyongjin/Admin/Index/password'
            });
        },
        onShow: function(){
            var t = $(this);
            t.tooltip('tip').unbind().bind('mouseenter', function(){
                t.tooltip('show');
            }).bind('mouseleave', function(){
                t.tooltip('hide');
            });
        }
    });
});
</script>
<div class="logo">
  <script language="javascript">
   document.write('<img id="logoImg" src="/taoyongjin/Public/Admin/theme/defalut/images/logo.png" /></div>');
  </script>
  <div class="show">
   <div class="l2">
   		<span id="localtime" style="margin-right:18px"></span>
   		<a href="javascript:;" id="chgSkin" title="切换皮肤"><i class='fa fa-user'></i></a>
   		<span class="hi">
   			您好：<strong><?php echo $_SESSION['nickname']?></strong> 
   			[<a id="updatePassword" href="javascript:;">修改密码</a>]
   			[<a id="clearCache" href="javascript:;">清除缓存</a>]
   			[<a target="_top" href="/taoyongjin/Home/Login/logout_manange">安全退出</a>] 
   			[<a href="javascript:;">帮助</a>]
   		</span>
   </div>
</div>
<script runat="server" language="javascript">
function tick(){  
    var today;  
    today = new Date();
    document.getElementById("localtime").innerHTML = showLocale(today);  
    window.setTimeout("tick()", 1000);  
}
tick();
</script>
 </div>
 <div data-options="region:'west',title:'菜单'" style="width:165px;">
  <script language="javascript">
	function onClickTree(node){
		var id = node.id;
		var tit = node.text;
		var url = node.url;
		var icon = node.iconCls;
		var code = node.code;
		icon="fa fa-easyui fa-bars";
		//alert(url);
		if(url){
			addTabs(id,tit,url,icon,code);
		}
	}
	function addTabs(id,tit,url,icon,code){
		$(function(){
			var tab = null;
			if(null!=tit){
				tab = $("#rightTabs").tabs('getTab',tit);
			}
			if(null==tab){
				$("#rightTabs").tabs('add',{
					id:id,
					title : tit,
					href : url,
					closable : true,
					iconCls : icon
				});
			}else{
				var index=$("#rightTabs").tabs('getTabIndex',tab);
				$("#rightTabs").tabs('select',index);
				$("#rightTabs").tabs('update',{
					tab:tab,
					options:{
						id:id,
						title : tit,
						href : url,
						closable : true,
						iconCls : icon
					} 
				});
			}
		});
	}
	/* function initTree(){
		 var requestData={};
		 var data=ajaxReturnList("/taoyongjin/index.php/Admin/Node/getSessionNodeList",requestData);
		 if(null!=data){
			 for(var i=0;i<data.length;i++){
				 $("#leftMenu").append('<div id="firstMenu_'+data[i].id+'" title="系统管理" data-options="iconCls:'+"'icon-setting'"+'">'+
						 '<ul class="easyui-tree left-tree" data-options="editable:false,lines:true,onClick:function(node){onClickTree(node);}">'+
						 	
						 '</ul></div>');
				 var childList=data[i].childList;
				 for(var j=0;j<childList.length;j++){
					 $("#firstMenu_"+data[i].id+" ul").append('<li data-options="'+"text:'"+childList[j].title+"',url:'/taoyongjin/index.php/Admin/User/index'"+'">'+childList[j].title+'</li>');
				 }
			 }
		 }
	} */
	$(document).ready(function(){
		//initTree();
		
	});
</script>
<div id="leftMenu" data-options="fit:true,border:false" class="easyui-accordion">
  <?php if(is_array($menuList)): foreach($menuList as $key=>$menu): ?><div title="<?php echo ($menu["title"]); ?>" data-options="iconCls:'icon-setting'">
		 <ul class="easyui-tree left-tree" data-options="editable:false,lines:true,onClick:function(node){onClickTree(node);}">
      		<?php if(is_array($menu['children'])): foreach($menu['children'] as $key=>$item): ?><li data-options="id:'<?php echo ($item["id"]); ?>',text:'<?php echo ($item["title"]); ?>',url:'/taoyongjin/Admin/<?php echo ($menu["name"]); ?>/<?php echo ($item["name"]); ?>'"><?php echo ($item["title"]); ?></li><?php endforeach; endif; ?>
		 </ul>
		</div><?php endforeach; endif; ?>
</div>



 </div>
 <div data-options="region:'center'">
  <div id="rightTabs" class="easyui-tabs" data-options="fit:true,border:false">
    <div title="控制台" data-options="closable:false,id:-1,href:'/taoyongjin/index.php/Admin/Index/console'"></div>
  </div>
 </div>
  <div class="footer" data-options="region:'south'" style="height:50px;">
  	<center><p>技术支持：<a href="http://www.java321.com/" target="_blank">项链</a></p></center>
  </div>
 <div id="repwd"></div>
 <div id="setpwd"></div>
</body>
</html>