<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	ajaxGetDictionaryByCode("/taoyongjin/Admin/Dictionary/getRowByCode","SYSTEM_TYPE","type_option");
	var tableList="tableList_option";
	var auForm ="addForm_option";
	var saveBtn="saveBtn_option";
	var addDiv="addDiv_option";
	var cancelBtn="cancelBtn_option";
	
	var th = $(".top").height();
	th = 111-th
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
		url:'/taoyongjin/Admin/Option/pageList',
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
				$('#'+auForm).form('clear');
				$('#'+auForm).form('load',{
					
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
						'data[value]':selectedRow.value,
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
				var selectedRow=$('#'+tableList).datagrid('getSelected');
				if(null==selectedRow){
					$.messager.alert('警告','请先选择一行！','warning');
				}else{
					var ids=selectedRow.id;
					ajaxDelRowsDatagrid('/taoyongjin/Admin/Option/delRows',ids,tableList);
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
			{field:'name',title:'参数名称',width:40,sortable:true},
			{field:'value',title:'参数值',width:40,sortable:true},
			{field:'code',title:'参数编码',width:40,sortable:true}, 
			{field:'type',title:'类型',width:40,sortable:true},
			{field:'remark',title:'备注',width:40,sortable:true}
		]]
	});
	$("#"+saveBtn).click(function(){
		ajaxSubmitForm(auForm,'/taoyongjin/Admin/Option/addOrUpdate',addDiv,tableList);
	});
	$("#"+cancelBtn).click(function(){
		$('#'+addDiv).window('close');
	});
});

</script>
<div>
 
	<table id="tableList_option"></table>

</div>
<div id="addDiv_option" class="easyui-window" title="添加" data-options="iconCls:'fa fa-dot-circle-o',closed:true" style="width:600px;height:360px;padding:5px;">
	<div class="easyui-layout" data-options="fit:true">
		<div data-options="region:'center',border:true">
			<form id="addForm_option" class="easyui-form" method="post" data-options="novalidate:true">
				<input name="data[id]" type="hidden" />
		    	<table cellpadding="5">
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">名称:</div></td>
		    			<td><input class="easyui-textbox" name="data[name]" data-options="required:true" style="width:200px;height:30px;" type="text"></input></td>
		    			
		    			<td>值:</td>
		    			<td><input class="easyui-textbox" name="data[value]" data-options="required:true" style="width:200px;height:30px;" type="text"></input></td>
		    			
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">编码:</div></td>
		    			<td><input class="easyui-textbox" name="data[code]" data-options="required:true" style="width:200px;height:30px;" type="text"></input></td>
		    		
		    			<td><div>类型:</div></td>
		    			<td colspan="3">
		    				<select id="type_option" name="data[type]" class="easyui-combobox" data-options="required:true" style="width:200px;height:30px;" >
		    					
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
			<a id="saveBtn_option" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-check'" href="javascript:void(0)" style="width:80px">保存</a>
			<a id="cancelBtn_option" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-times'" href="javascript:void(0)" style="width:80px">取消</a>
		</div>
	</div>
</div>