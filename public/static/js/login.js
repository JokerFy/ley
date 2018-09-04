/**
 * 前端登录业务类
 * @author singwa
 */
var login = {
    check : function() {
        // 获取登录页面中的用户名 和 密码
        var username = $('input[name="username"]').val();
        var password = $('input[name="userpwd"]').val();

        if(!username) {
            dialog.error('用户名不能为空');
            return false;
        }
        if(!password) {
            dialog.error('密码不能为空');
            return false;
        }

        var url = "/admin/login/check";
        var data = {ac:username,se:password};
        // 执行异步请求  $.post
        $.post(url,data,function(result){
            if(result.status === 0) {
                return dialog.error(result.message);
            }
            if(result.status === 1) {
                return dialog.success(result.message, '/admin/index');
            }

        },'JSON');

    }
}