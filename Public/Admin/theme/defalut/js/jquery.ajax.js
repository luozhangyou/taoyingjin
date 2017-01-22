/*!
 * luozhangyou[孤傲的项链]
 * Copyright 2011-2016 Java321, Inc.
 * Licensed java321.com
 */
var path=null;
function initPath(value){
	path=value+'/';
}

function ajaxReturnList(url,requestData){
	var rtr;
	$.ajax({
		type:"POST",
		url:url, //+"?time="+ (new Date()).getTime()
		dataType:"JSON",
		async:false,
		data:requestData,
		success:function(data){
			rtr = data;
		},
		error:function(){
			rtr = "系统错误,请联系管理员。";
		}
	});
	return rtr;
}

function ajaxReturnRow(url,requestData){
	var rtr;
	$.ajax({
		type:"POST",
		url:url,
		dataType:"JSON",
		async:false,
		data:requestData,
		success:function(data){
			rtr = data;
		},
		error:function(){
			rtr = "系统错误,请联系管理员。";
		}
	});
	return rtr;
}

function ajaxReturnPage(url,page,rows){
	var rtr;
	$.ajax({
		type:"POST",
		url:url,
		dataType: 'JSON',
		async:false,
		data: {'data[page]':page,'data[rows]':rows},
		success:function(data){
			rtr = data;
		},
		error:function(){
			rtr = "系统错误,请联系管理员。";
		}
	});
	return rtr;
}

function ajaxReturnPage(url,page,rows,extra){
	var rtr;
	$.ajax({
		type:"POST",
		url:url,
		dataType: 'JSON',
		async:false,
		data: {'data[page]':page,'data[rows]':rows,'data[extra]':extra},
		success:function(data){
			rtr = data;
		},
		error:function(){
			rtr = "系统错误,请联系管理员。";
		}
	});
	return rtr;
}

//基于easyui


function ajaxSubmitForm(formName,basePath,closeDiv,tableList){
	
	$('#'+formName).form('submit',{
		url:basePath,
		onSubmit: function(){
			return $('#'+formName).form('validate');
		},
		success:function(data){
			var obj = eval('(' + data + ')');
			if(obj.flag==true){
				if(null!=closeDiv){
					$('#'+closeDiv).window('close');
				}
				$('#'+tableList).datagrid('reload');
				$('#'+tableList).datagrid('clearSelections'); 
			}else{
				 $.messager.alert('系统提示', obj.msg , 'info');
			}
		},
		error:function(data){
		    $.messager.alert('警告', obj.msg , 'warn');
		}
	});
}

function ajaxSubmitFormBack(formName,basePath,backUrl,tableList){
	
	$('#'+formName).form('submit',{
		url:basePath,
		onSubmit: function(){
			return $('#'+formName).form('validate');
		},
		success:function(data){
			var obj = eval('(' + data + ')');
			if(obj.flag==true){
				$.messager.confirm('系统提示', '操作成功，是否返回列表？', function(r){
					if (r){
						var tab = $('#rightTabs').tabs('getSelected');
						tab.panel('refresh', backUrl);
					}else{
						
					}
				});
			}else{
				 $.messager.alert('系统提示', obj.msg , 'info');
			}
		},
		error:function(data){
		    $.messager.alert('警告', obj.msg , 'warn');
		}
	});
}

function ajaxDelRowsDatagrid(basePath,ids,tableList){
	$.ajax({
		url: basePath,
		type: 'POST',
		dataType: 'json',
		data: {'data[ids]':ids},
		success:function(obj){
			if(obj.flag==true){
				$('#'+tableList).datagrid('reload');
				$('#'+tableList).datagrid('clearSelections'); 
			}else{
				 $.messager.alert('系统提示', obj.msg , 'info');
			}
		},
		error:function(data){
		    $.messager.alert('警告', obj.msg , 'warn');
		}
	})
}
function ajaxSubmitFormTreeGrid(formName,basePath,closeDiv,tableList){
	$('#'+formName).form('submit',{
		url:basePath,
		onSubmit: function(){
			return $('#'+formName).form('validate');
		},
		success:function(data){
			var obj = eval('(' + data + ')');
			if(obj.flag==true){
				$('#'+closeDiv).window('close');
				$('#'+tableList).treegrid('reload');
			}else{
				 $.messager.alert('系统提示', obj.msg , 'info');
			}
		},
		error:function(data){
		    $.messager.alert('警告', obj.msg , 'warn');
		}
	});
}

function ajaxDelRowsTreeGrid(basePath,ids,tableList){
	$.ajax({
		url: basePath,
		type: 'POST',
		dataType: 'json',
		data: {'data[ids]':ids},
		success:function(obj){
			if(obj.flag==true){
				$('#'+tableList).treegrid('reload');
				$('#'+tableList).treegrid('clearSelections'); 
			}else{
				 $.messager.alert('系统提示', obj.msg , 'info');
			}
		},
		error:function(data){
		    $.messager.alert('警告', obj.msg , 'warn');
		}
	})
}

function ajaxGetDictionaryByCode(basePath,code,elementId){
	$.ajax({
		url: basePath,
		type: 'POST',
		dataType: 'json',
		data: {'data[code]':code},
		success:function(obj){
			$('#'+elementId).combobox({
				data:obj,
			    valueField:'code',
			    textField:'name'
			});
			return obj;
		},
		error:function(data){
		    $.messager.alert('警告', obj.msg , 'warn');
		}
	})
}

function ajaxSubmitFormSimple(formName,basePath){
	
	$('#'+formName).form('submit',{
		url:basePath,
		onSubmit: function(){
			return $('#'+formName).form('validate');
		},
		success:function(data){
			var obj = eval('(' + data + ')');
			$.messager.alert('系统提示', obj.msg , 'info');
		},
		error:function(data){
		    $.messager.alert('警告', obj.msg , 'warn');
		}
	});
}
