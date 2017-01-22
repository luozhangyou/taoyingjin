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
		url:url,//+"?time="+ (new Date()).getTime()
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

function ajaxGetDictionaryByCode(basePath,code,elementId,value){
	var rtr;
	$.ajax({
		url: basePath,
		type: 'POST',
		dataType: 'json',
		data: {'data[code]':code},
		success:function(obj){
			rtr=obj;
			if(null!=obj){
				for(var i=0;i<obj.length;i++){
					$('#'+elementId).append('<option class="optHeight" value="'+obj[i].code+'">'+obj[i].name+'</option>');
				}
			}
			$('#'+elementId).val(value);
		},
		error:function(data){
		    $.messager.alert('警告', obj.msg , 'warn');
		}
	});
	return rtr;
}

