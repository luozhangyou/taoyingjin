//基于easyui  时间戳转时间 
function formatDatebox(value,row){
	if(null==value){
		return "数据为空";
	}else{
		return formatDate('yyyy-MM-dd hh:mm:ss',value);
	}
}

function formatDate(format,value){
	var newDate = new Date();
	newDate.setTime(value * 1000);
	
	var date = {
            "M+": newDate.getMonth() + 1,
            "d+": newDate.getDate(),
            "h+": newDate.getHours(),
            "m+": newDate.getMinutes(),
            "s+": newDate.getSeconds(),
            "q+": Math.floor((newDate.getMonth() + 3) / 3),
            "S+": newDate.getMilliseconds()
     };
     if (/(y+)/i.test(format)) {
            format = format.replace(RegExp.$1, (newDate.getFullYear() + '').substr(4 - RegExp.$1.length));
     }
     for (var k in date) {
            if (new RegExp("(" + k + ")").test(format)) {
                   format = format.replace(RegExp.$1, RegExp.$1.length == 1
                          ? date[k] : ("00" + date[k]).substr(("" + date[k]).length));
            }
     }
     return format;
}


function uploadImage(url,form,file,column){
	var imgPath = $("#"+file).val();
    //判断上传文件的后缀名
    var strExtension = imgPath.substr(imgPath.lastIndexOf('.') + 1);
    if (strExtension != 'jpg' && strExtension != 'gif'
    && strExtension != 'png' && strExtension != 'bmp') {
    	 $.messager.alert('系统提示', '请选择图片文件' , 'info');
        return;
    }
    
    $('#'+form).form('submit',{
		url:url,
		onSubmit: function(){
			
		},
		success:function(data){
			var obj = eval('(' + data + ')');
			if(obj.flag==true){
				var row=obj.object;
				$("#"+column).val(row.id);
				$("#dis_"+column).attr("src",row.path);
			}else{
				 $.messager.alert('系统提示', obj.msg , 'info');
			}
		},
		error:function(data){
		    $.messager.alert('警告', obj.msg , 'warn');
		}
	});
    
}


function GetQueryString(name){
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); return null;
}