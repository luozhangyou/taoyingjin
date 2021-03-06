<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	var tableList="tableList_dictionary";
	var auForm="auForm_dictionary";
	var saveBtn="saveBtn_dictionary";
	var addDiv="addDiv_dictionary";
	var cancelBtn="cancelBtn_dictionary";
	
	var th = $(".top").height();
	th = 111-th
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
		treeField:'name',
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
		url:'/taoyongjin/Admin/Dictionary/pageList',
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
				initDictionaryCombox();
				$('#'+auForm).form('clear');
				$('#'+auForm).form('load',{
					'data[status]':1
				});
				$("#"+addDiv).window('open');
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-edit',
			text : '编辑',
			handler: function(){
				var selectedRow=$('#'+tableList).treegrid('getSelected');
				if(null==selectedRow){
					$.messager.alert('警告','请先选择一行！','warning');
				}else{
					var pid=selectedRow.pid;
					if(pid==0){
						pid="顶级结点";
					}
					$('#'+auForm).form('load',{
						'data[id]':selectedRow.id,
						'data[name]':selectedRow.name,
						'data[order]':selectedRow.order,
						'data[status]':selectedRow.status,
						'data[code]':selectedRow.code,
						'data[pid]':pid,
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
					ajaxDelRowsTreeGrid('/taoyongjin/Admin/Dictionary/delRows',ids,tableList);
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
		    {field:'name',title:'名称',width:200,sortable:true}
		]],
		columns:[[  
			{field:'code',title:'识别码',width:100,sortable:true},
			{field:'order',title:'排序',width:100,sortable:true},
			{field:'status',title:'状态',width:100,sortable:true,
				formatter:function(value,row){  
			          if(value==1){  
			        	  return '可用'; 
			          }else{  
			              return '空值';  
			          }  
			   }  	
			}, 
			{field:'remark',title:'备注',width:100,sortable:true}
		]]
	});
	$("#"+saveBtn).click(function(){
		ajaxSubmitFormTreeGrid(auForm,'/taoyongjin/Admin/Dictionary/addOrUpdate',addDiv,tableList);
		initDictionaryCombox();
	});
	$("#"+cancelBtn).click(function(){
		$('#'+addDiv).window('close');
	});
	
	$('#dictionaryCombox').combobox({
		url:'/taoyongjin/Admin/Dictionary/getCombobox',
		valueField: 'id',
        textField: 'name',
	});
});
function initDictionaryCombox(){
	$('#dictionaryCombox').combobox({
		url:'/taoyongjin/Admin/Dictionary/getCombobox',
		valueField: 'id',
        textField: 'name',
	});
}
</script>
<div>
	<table id="tableList_dictionary"></table>
</div>
<div id="addDiv_dictionary" class="easyui-window" title="添加" data-options="iconCls:'fa fa-dot-circle-o',closed:true" style="width:600px;height:360px;padding:5px;">
	<div class="easyui-layout" data-options="fit:true">
		<div data-options="region:'center',border:true">
			<form id="auForm_dictionary" class="easyui-form" method="post" data-options="novalidate:true">
				<input name="data[id]" type="hidden" />
		    	<table cellpadding="5">
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">名称:</div></td>
		    			<td><input class="easyui-textbox" name="data[name]" data-options="required:true" style="width:200px;height:30px;" type="text"></input></td>
		    			<td><div>排序:</div></td>
		    			<td><input class="easyui-textbox" name="data[order]" data-options="required:true" style="width:200px;height:30px;" type="text" ></input></td>
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">识别码:</div></td>
		    			<td><input class="easyui-textbox" name="data[code]" data-options="required:true" style="width:200px;height:30px;" type="text" ></input></td>
		    			
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
		    			<td colspan="3">
		    				<select id="dictionaryCombox" name="data[pid]" class="easyui-combobox" style="width:200px;height:30px;" >
		    					
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
			<a id="saveBtn_dictionary" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-check'" href="javascript:void(0)" style="width:80px">保存</a>
			<a id="cancelBtn_dictionary" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-times'" href="javascript:void(0)" style="width:80px">取消</a>
		</div>
	</div>
</div>