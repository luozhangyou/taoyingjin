<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	 $.extend($.fn.validatebox.defaults.rules, {
       /*必须和某个字段相等*/
       equalTo: { validator: function (value, param) { return $(param[0]).val() == value; }, message: '字段不匹配重复字段' }
      });
	var saveBtn="saveBtn_password";
	var auForm="form_password";
	$("#"+saveBtn).click(function(){
		ajaxSubmitFormSimple(auForm,'/taoyongjin/Admin/User/updatePassword');
	});
});
</script>
<div style="padding:10px;">
	<form id="form_password" method="post">
	    <table cellpadding="5">
	        <tr>
	            <td><div style="width:80px;text-align: right;">旧密码:</div></td>
	            <td><input class="easyui-textbox" name="user[password]" data-options="required:true" style="width:200px;height:30px;" type="password" ></input></td>
	        </tr>
	        <tr>
	            <td><div type="password" style="width:80px;text-align: right;">新密码:</div></td>
	            <td><input id="newpassword_password" class="easyui-textbox"  name="user[newpassword]" data-options="required:true" style="width:200px;height:30px;" type="password" ></input></td>
	        </tr>
	        <tr>
	            <td><div style="width:80px;text-align: right;">确认新密码:</div></td>
	            <td>
	            	<input class="easyui-textbox" name="user[renewpassword]" validType="equalTo['#newpassword_password']" data-options="required:true" style="width:200px;height:30px;" type="password" ></input>
	            </td>
	        </tr>
	        <tr>
	            <td><div style="width:80px;text-align: right;"></div></td>
	            <td>
	            	<a id="saveBtn_password" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-check'" href="javascript:void(0)" style="width:80px">保存</a>
				</td>
	        </tr>
	    </table>
	</form>
</div>