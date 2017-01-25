<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	var tableList="tableList_attachment";
	var auForm ="addForm_attachment";
	var saveBtn="saveBtn_attachment";
	var addDiv="addDiv_attachment";
	var cancelBtn="cancelBtn_attachment";
	
	var th = $(".top").height();
	th = 204-th
	var wh = $(window).height()-th;
	var pr = 30;
	var pn = false;
	if(pr>0){
		pn = true;
	}
	$("#"+tableList).datagrid({
		//title:'用户列表',
		idField:'id',
		fix:true, 
		height:wh,
		autoRowHeight:false,
		singleSelect:true,
		striped:true,
		method:'get',
		sortName:'id',
		sortOrder:'desc',
		rownumbers:true,
		pagination:pn,
		pageSize:pr,
		pageList:[30,50,80,100],
		url:'/taoyongjin/Admin/Attachment/pageList',
		fitColumns:true,
		nowrap:true,
		selectOnCheck:false,
		animate:true,
		checkOnSelect:true,
		onBeforeLoad: function () {  
			
		},
		onDblClickRow:function(e,rowIndex,rowData){
			
		},
		toolbar:[/* {
		iconCls: 'fa fa-easyui fa-plus-square',
			text : '添加',
			handler: function(){
				$('#'+auForm).form('clear');
				$('#'+auForm).form('load',{
					'data[is_open]':1,
					'data[pingyin]':'自动生成',
				});
				$("#"+addDiv).window('open');
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-edit',
			text : '编辑',
			handler: function(){
				var selectedRow=$('#'+tableList).datagrid('getSelected');
				if(null==selectedRow){
					$.messager.alert('警告','请先选择一行！','warning');
				}else{
					$('#'+auForm).form('load',{
						'data[id]':selectedRow.id,
						'data[name]':selectedRow.name,
						'data[code]':selectedRow.code,
						'data[order_num]':selectedRow.order_num,
						'data[pingyin]':selectedRow.pingyin,
						'data[is_open]':selectedRow.is_open,
					});
					$("#"+addDiv).window('open');
				}
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-times',
			text : '删除',
			handler: function(){
				var selectedRow=$('#'+tableList).datagrid('getSelected');
				if(null==selectedRow){
					$.messager.alert('警告','请先选择一行！','warning');
				}else{
					var ids=selectedRow.id;
					ajaxDelRowsDatagrid('/taoyongjin/Admin/Attachment/delRows',ids,tableList);
				}
			}
		},'-', */{
			iconCls: 'fa fa-easyui fa-bolt',
			text : '更新缓存',
			handler: function(){
				
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-check-square-o',
			text : '取消选择',
			handler: function(){
				$('#'+tableList).datagrid('clearSelections'); 
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-retweet',
			text : '重载',
			handler: function(){
				$("#"+tableList).datagrid('reload');
			}
		}],
		frozenColumns:[[   
		    
		]],
		columns:[[  
			{field:'name',title:'源名',width:40,sortable:true},
			{field:'filename',title:'引用名',width:40,sortable:true},
			{field:'path',title:'路径',width:40,sortable:true},
			{field:'type',title:'类型',width:40,sortable:true,
				formatter:function(value,row){  
			          if(value==1){  
			        	  return '图片类型'; 
			          }else{  
			              return '';  
			          }  
			   }  	
			},{field:'status',title:'状态',width:40,sortable:true,
				formatter:function(value,row){  
			          if(value==1){  
			        	  return '缓存'; 
			          }else if(value==2){
			        	  return '使用';
			          }else if(value==3){
			        	  return '游离';
			          }else{ 
			              return '';  
			          }  
			   }  	
			},{field:'cat',title:'分类',width:40,sortable:true,
				formatter:function(value,row){  
			          if(value==1){  
			        	  return '用户头像 '; 
			          }else if(value==2){
			        	  return '营业执照 ';
			          }else if(value==3){
			        	  return '分类图片 ';
			          }else{ 
			              return '';  
			          }  
			   }  	
			}
		]]
	});
	$("#"+saveBtn).click(function(){
		ajaxSubmitForm(auForm,'/taoyongjin/Admin/Attachment/addOrUpdate',addDiv,tableList);
	});
	$("#"+cancelBtn).click(function(){
		$('#'+addDiv).window('close');
	});
});

</script>
<div>
 
	<table id="tableList_attachment"></table>

</div>
<div id="addDiv_attachment" class="easyui-window" title="添加" data-options="iconCls:'fa fa-dot-circle-o',closed:true" style="width:600px;height:360px;padding:5px;">
	<div class="easyui-layout" data-options="fit:true">
		<div data-options="region:'center',border:true">
			<form id="addForm_attachment" class="easyui-form" method="post" data-options="novalidate:true">
				<input name="data[id]" type="hidden" />
		    	<table cellpadding="5">
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">名称:</div></td>
		    			<td><input class="easyui-textbox" name="data[name]" data-options="required:true" style="width:200px;height:30px;" type="text"></input></td>
		    			
		    			<td>代号:</td>
		    			<td><input class="easyui-textbox" name="data[code]" data-options="required:true" style="width:200px;height:30px;" type="text"></input></td>
		    			
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">排序:</div></td>
		    			<td><input class="easyui-textbox" name="data[order_num]" data-options="required:true,validType:['number']" style="width:200px;height:30px;" type="text"></input></td>
		    			
		    			<td>开关:</td>
		    			<td>
		    				<select name="data[is_open]" class="easyui-combobox" data-options="required:true" style="width:200px;height:30px;" >
		    					<option value="1">开启</option>
		    					<option value="0">关闭</option>
		    				</select>
		    			</td>
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">拼音:</div></td>
		    			<td colspan="3"><input class="easyui-textbox" name="data[pingyin]" style="width:200px;height:30px;" type="text"></input></td>
		    		</tr>
		    	</table>
		    </form>
		</div>
		<div data-options="region:'south',border:false" style="text-align:right;padding:5px 0 0;">
			<a id="saveBtn_attachment" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-check'" href="javascript:void(0)" style="width:80px">保存</a>
			<a id="cancelBtn_attachment" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-times'" href="javascript:void(0)" style="width:80px">取消</a>
		</div>
	</div>
</div>