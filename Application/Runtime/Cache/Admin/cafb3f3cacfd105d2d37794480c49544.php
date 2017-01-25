<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	var tableList="tableList_node";
	var auForm="auForm_role";
	var saveBtn="saveBtn_node";
	var addDiv="addDiv_node";
	var cancelBtn="cancelBtn_node";
	
	var th = $(".top").height();
	th = 204-th
	var wh = $(window).height()-th;
	var pr = 30;
	var pn = false;
	if(pr>0){
		pn = true;
	}
	$("#"+tableList).treegrid({
		//title:'用户列表',
		idField:'id',
		height:wh,
		treeField:'title',
		autoRowHeight:false,
		singleSelect:true,
		striped:true,
		method:'get',
		sortName:'id',
		sortOrder:'desc',
		rownumbers:true,
		pagination:pn,
		pageSize:pr,
		lines:true,
		pageList:[30,50,80,100],
		url:'/taoyongjin/Admin/Node/pageLIst',
		fitColumns:true,
		nowrap:true,
		selectOnCheck:false,
		animate:true,
		checkOnSelect:true,
		onBeforeLoad: function () {  
			
		},
		onDblClickRow:function(e,rowIndex,rowData){
			
		},
		toolbar:[{
		iconCls: 'fa fa-easyui fa-plus-square',
			text : '添加',
			handler: function(){
				initNodeComboxtree();
				$('#'+auForm).form('clear');
				$('#'+auForm).form('load',{
					'data[level]':3,
					'data[status]':1,
					'data[type]':0,
				});
				$("#"+addDiv).window('open');
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-edit',
			text : '编辑',
			handler: function(){
				initNodeComboxtree();
				var selectedRow=$('#'+tableList).treegrid('getSelected');
				if(null==selectedRow){
					$.messager.alert('警告','请先选择一行！','warning');
				}else{
					$('#'+auForm).form('load',{
						'data[id]':selectedRow.id,
						'data[name]':selectedRow.name,
						'data[title]':selectedRow.title,
						'data[level]':selectedRow.level,
						'data[status]':selectedRow.status,
						'data[pid]':selectedRow.pid,
						'data[type]':selectedRow.type,
						'data[remark]':selectedRow.remark,
					});
					$("#"+addDiv).window('open');
				}
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-times',
			text : '删除',
			handler: function(){
				var selectedRow=$('#'+tableList).treegrid('getSelected');
				if(null==selectedRow){
					$.messager.alert('警告','请先选择一行！','warning');
				}else{
					var ids=selectedRow.id;
					ajaxDelRowsTreeGrid('/taoyongjin/Admin/Node/delRows',ids,tableList);
				}
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-bolt',
			text : '更新缓存',
			handler: function(){
				
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-check-square-o',
			text : '取消选择',
			handler: function(){
				$('#'+tableList).treegrid('clearSelections'); 
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-retweet',
			text : '重载',
			handler: function(){
				$("#"+tableList).treegrid('reload');
			}
		}],
		frozenColumns:[[   
		    {field:'title',title:'标题',width:200,sortable:true}
		]],
		columns:[[  
			{field:'name',title:'名称',width:100,sortable:true},
			{field:'status',title:'状态',width:100,sortable:true,
				formatter:function(value,row){  
			          if(value==1){  
			        	  return '可用'; 
			          }else{  
			              return '不可用';  
			          }  
			   }  	
			}, 
			{field:'type',title:'类型',width:100,sortable:true,
				formatter:function(value,row){  
			          if(value==1){  
			        	  return '左侧菜单'; 
			          }else{  
			              return '功能';  
			          }  
			   }  	
			}, 
			{field:'remark',title:'备注',width:100,sortable:true}
		]]
	});
	$("#"+saveBtn).click(function(){
		ajaxSubmitFormTreeGrid(auForm,'/taoyongjin/Admin/Node/addOrUpdate',addDiv,tableList);
	});
	$("#"+cancelBtn).click(function(){
		$('#'+addDiv).window('close');
	});
	
	$('#nodeComboxtree').combotree({
		url:'/taoyongjin/Admin/Node/getParent',
		editable:false,
		lines:true,
		method:'get'
	});
});
function initNodeComboxtree(){
	$('#nodeComboxtree').combotree({
		url:'/taoyongjin/Admin/Node/getParent',
		editable:false,
		lines:true,
		method:'get'
	});
}
</script>
<div>
	<table id="tableList_node"></table>
</div>
<div id="addDiv_node" class="easyui-window" title="添加" data-options="iconCls:'fa fa-dot-circle-o',closed:true" style="width:600px;height:360px;padding:5px;">
	<div class="easyui-layout" data-options="fit:true">
		<div data-options="region:'center',border:true">
			<form id="auForm_role" class="easyui-form" method="post" data-options="novalidate:true">
				<input name="data[id]" type="hidden" />
		    	<table cellpadding="5">
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">名称:</div></td>
		    			<td><input class="easyui-textbox" name="data[name]" data-options="required:true" style="width:200px;height:30px;" type="text"></input></td>
		    			<td><div>标题:</div></td>
		    			<td><input class="easyui-textbox" name="data[title]" data-options="required:true" style="width:200px;height:30px;" type="text" ></input></td>
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">级别:</div></td>
		    			<td>
		    				<select name="data[level]" class="easyui-combobox" data-options="required:true" style="width:200px;height:30px;" >
		    					<option value="3">方法</option>
		    					<option value="2">控制器</option>
		    					<option value="1">模块</option>
		    				</select>
		    			</td>
		    			<td>状态:</td>
		    			<td>
		    				<select name="data[status]" class="easyui-combobox" data-options="required:true" style="width:200px;height:30px;" >
		    					<option value="1">可用</option>
		    					<option value="0">不可用</option>
		    				</select>
		    			</td>
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">父级:</div></td>
		    			<td colspan="1">
		    				<select id="nodeComboxtree" name="data[pid]" style="width:200px;height:30px;" >
		    					
		    				</select>
		    			</td>
		    			<td>类型:</td>
		    			<td>
		    				<select name="data[type]" class="easyui-combobox" data-options="required:true" style="width:200px;height:30px;" >
		    					<option value="0">功能</option>
		    					<option value="1">左侧菜单</option>
		    				</select>
		    			</td>
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">备注:</div></td>
		    			<td colspan="3"><input class="easyui-textbox" name="data[remark]" data-options="multiline:true" style="height:100px;width:455px;"></input></td>
		    		</tr>
		    	</table>
		    </form>
			
		</div>
		<div data-options="region:'south',border:false" style="text-align:right;padding:5px 0 0;">
			<a id="saveBtn_node" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-check'" href="javascript:void(0)" style="width:80px">保存</a>
			<a id="cancelBtn_node" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-times'" href="javascript:void(0)" style="width:80px">取消</a>
		</div>
	</div>
</div>