<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	ajaxGetDictionaryByCode("/taoyongjin/Admin/Dictionary/getRowByCode","MESSAGE_TYPE","type_message");
	var tableList="tableList_message";
	var auForm ="addForm_message";
	var saveBtn="saveBtn_message";
	var addDiv="addDiv_message";
	var cancelBtn="cancelBtn_message";
	
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
		url:'/taoyongjin/Admin/Message/pageList',
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
						'data[url]':selectedRow.url,
						'data[content]':selectedRow.content,
						'data[type]':selectedRow.type,
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
					ajaxDelRowsDatagrid('/taoyongjin/Admin/Message/delRows',ids,tableList);
				}
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
			{field:'name',title:'名称',width:40,sortable:true},
			{field:'type',title:'类型',width:40,sortable:true},
			{field:'url',title:'链接',width:40,sortable:true},
			{field:'content',title:'内容',width:40,sortable:true},
			
			{field:'create_user',title:'创建人',width:40,sortable:true,
				formatter: function(value,row,index){
					if (row.createUser){
						return row.createUser.nickname;
					} else {
						return value;
					}
				}	
			},
			
			{field:'create_time',title:'创建时间',width:40,sortable:true,formatter:formatDatebox},
			{field:'update_user',title:'修改人',width:40,sortable:true,
				formatter: function(value,row,index){
					if (row.updateUser){
						return row.updateUser.nickname;
					} else {
						return value;
					}
				}		
			},
			{field:'update_time',title:'修改时间',width:40,sortable:true,formatter:formatDatebox},
		]]
	});
	$("#"+saveBtn).click(function(){
		ajaxSubmitForm(auForm,'/taoyongjin/Admin/Message/addOrUpdate',addDiv,tableList);
	});
	$("#"+cancelBtn).click(function(){
		$('#'+addDiv).window('close');
	});
});

</script>
<div>
 
	<table id="tableList_message"></table>

</div>
<div id="addDiv_message" class="easyui-window" title="添加" data-options="iconCls:'fa fa-dot-circle-o',closed:true" style="width:600px;height:360px;padding:5px;">
	<div class="easyui-layout" data-options="fit:true">
		<div data-options="region:'center',border:true">
			<form id="addForm_message" class="easyui-form" method="post" data-options="novalidate:true">
				<input name="data[id]" type="hidden" />
		    	<table cellpadding="5">
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">名称:</div></td>
		    			<td><input class="easyui-textbox" name="data[name]" data-options="required:true" style="width:455px;height:30px;" type="text"></input></td>
		    			
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">链接:</div></td>
		    			<td><input class="easyui-textbox" name="data[url]" data-options="required:true" style="width:455px;height:30px;" type="text"></input></td>
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">类型:</div></td>
		    			<td>
		    				<select id="type_message" name="data[type]" class="easyui-combobox" data-options="required:true" style="width:455px;height:30px;" ></select>
		    			</td>
		    		
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">内容:</div></td>
		    			<td colspan="1"><input class="easyui-textbox" name="data[content]" data-options="multiline:true,required:true" style="height:100px;width:455px;"></input></td>
		    		</tr>
		    	</table>
		    </form>
		</div>
		<div data-options="region:'south',border:false" style="text-align:right;padding:5px 0 0;">
			<a id="saveBtn_message" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-check'" href="javascript:void(0)" style="width:80px">保存</a>
			<a id="cancelBtn_message" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-times'" href="javascript:void(0)" style="width:80px">取消</a>
		</div>
	</div>
</div>