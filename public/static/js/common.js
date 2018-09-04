$(function () {
    //加载弹出层
    layui.use(['form', 'upload', 'laypage'], function () {
        var layer = parent.layer === undefined ? layui.layer : parent.layer
            , form = layui.form, upload = layui.upload, laypage = layui.laypage;
        form.on('submit(lay-finCms-form)', function (data) {
            var datas = $("#finCms-form").serializeArray();
            postData = {};
            $(datas).each(function (i) {
                postData[this.name] = this.value;
            });
            // 将获取到的数据post给服务器
            // console.log(datas);
            url = SCOPE.save_url;
            var params = {
                url: url,
                type: 'post',
                data: datas,
                sCallback: function (res) {
                    if (res.error_code == 0) {
                        return dialog.successon(res.msg)
                    }else{
                        return dialog.error(res.msg)
                    }
                },
                eCallback: function (Exception) {
                    return dialog.error(Exception)
                }
            };
            window.base.getData(params);
            return false;
        });

        //普通图片上传
        var uploadInst = upload.render({
            elem: '#test1'
            , url: 'http://mylay.cn/api/v1/image/toupload'
            , before: function (obj) {
                //预读本地文件示例，不支持ie8
                obj.preview(function (index, file, result) {
                    $('#demo1').attr('src', result); //图片链接（base64）
                    $('#demo1').attr('width', '100px');
                    $('#demo1').attr('height', '100px');
                });
            }
            , done: function (res) {
                if (res.status === 1) {
                    res.image = '/' + res.data;
                    $("#imgName").val(res.image);
                    return layer.msg('上传成功');
                } else if (res.status === 0) {
                    return layer.msg('上传失败');
                }
            }

            , error: function () {
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> ');
            }
        });

        laypage.render({
            elem: 'demo0'
        });
        /*        $(window).one("resize",function(){
                    $(".newsAdd_btn").click(function(){
                        var index = layui.layer.open({
                            title : "添加文章",
                            type : 2,
                            content : "add",
                            success : function(layero, index){
                                setTimeout(function(){
                                    layui.layer.tips('点击此处返回文章列表', '.layui-layer-setwin .layui-layer-close', {
                                        tips: 3
                                    });
                                },500)
                            }
                        })
                        layui.layer.full(index);
                    })
                }).resize();*/
    });

    /**
     * 推送JS相关
     */
    $("#finCms-push").click(function(){
        var id = $("#select-push").val();
        if(id==0) {
            return dialog.error("请选择推荐位");
        }
        push = {};
        postData = {};
        $("input[name='pushcheck']:checked").each(function(i){
            push[i] = $(this).val();
        });
        console.log(push);
        postData['model'] = 'position_content';
        postData['push'] = push;
        postData['position_id']  =  id;
        //console.log(postData);return;
        // var url = SCOPE.push_url;
        var params = {
            url: '/admin/cms.content/push',
            type: 'post',
            data: postData,
            sCallback: function (res) {
                if (res.error_code == 0) {
                    return dialog.successon(res.msg)
                }
            },
            eCallback: function (Exception) {
                return dialog.error(Exception)
            }
        };
        window.base.getData(params);
    });


    /**
     * 排序操作
     */
    $('#button-listorder').click(function () {
        // 获取 listorder内容
        var inputs=$('#tabodyform').find("input[type='text']");
        postData = {};
        $(inputs).each(function(i){
            postData[this.name] = this.value;
        });
        postData['table'] = SCOPE.table;
        var params = {
            url: '/admin/base/listorder',
            type: 'post',
            data: postData,
            sCallback: function (res) {
                if (res.error_code == 0) {
                    return dialog.successon(res.msg)
                }
            },
            eCallback: function (Exception) {
                return dialog.error(Exception)
            }
        };
        window.base.getData(params);
    });

});

/**
 * 修改状态
 */
function changeStatus(obj){

    var id = $(obj).attr('attr-id'),
    status = $(obj).attr("attr-status"), datas = {};
    datas['id'] = id;
    datas['status'] = status;
    datas['model'] = SCOPE.model;
    layer.open({
        type : 0,
        title : '是否提交？',
        btn: ['yes', 'no'],
        icon : 3,
        closeBtn : 2,
        content: "是否确定更改状态",
        scrollbar: true,
        yes: function(){
            var params = {
                url: '/admin/base/changeStatus',
                type: 'post',
                data: datas,
                sCallback: function (res) {
                    if (res.error_code == 0) {
                        return dialog.successon(res.msg)
                    }
                },
                eCallback: function (Exception) {
                    return dialog.error(Exception)
                }
            };
            window.base.getData(params);
            return false;
        }

    });

};


/**
 * layer弹出层做的表单
 * @param title
 * @param url
 * @param w
 * @param h
 * @param obj
 */
function layerForm(title, url, w, h, obj) {
    if (obj) {
        var id = $(obj).attr('attr-id'),
            urls = SCOPE.edit_url + id;
    } else {
        urls = url;
    }

    if (w == null || w == '') {
        w = ($(window).width() * 0.9);
    }
    if (h == null || h == '') {
        h = ($(window).height() - 50);
    }
    layer.open({
        type: 2,
        area: [w + 'px', h + 'px'],
        fix: false, //不固定
        maxmin: true,
        shadeClose: true,
        shade: 0.4,
        title: title,
        content: urls
    })
}

/*真删除*/
function realDelete(obj) {
    var id = $(obj).attr('attr-id'),
        datas = {id: id};
    url = SCOPE.delete_url;
    layer.confirm('确认要删除吗？', function (index) {
        var params = {
            url: url,
            type: 'post',
            data: datas,
            sCallback: function (res) {
                if (res.error_code == 0) {
                    layer.msg('已删除!', {icon: 1, time: 1000});
                    $(obj).parents("tr").remove();
                }
            },
            eCallback: function (Exception) {
                return dialog.error(Exception)
            }
        };
        window.base.getData(params);
        return false;
    });
}


/*关联删除*/
function relationDelete(obj) {
    var id = $(obj).attr('attr-id'),
        datas = {id: id},
        url = SCOPE.delete_url;

    layer.confirm('确认要删除吗？', function (index) {
        console.log(id);
        var params = {
            url: url,
            type: 'post',
            data: datas,
            sCallback: function (res) {
                if (res.error_code == 0) {
                    layer.msg('已删除!', {icon: 1, time: 1000});
                    $(obj).parents("tr").remove();
                }
            },
            eCallback: function (Exception) {
                return dialog.error(Exception)
            }
        };
        window.base.getData(params);
        return false;
    });
}



/**
 * 排序操作
 */
$('#button-listorder').click(function () {
    // 获取 listorder内容
    var inputs=$('#tabodyform').find("input[type='text']");
    postData = {};
    $(inputs).each(function(i){
        postData[this.name] = this.value;
    });
    postData['table'] = SCOPE.listmodel;
    $.post('/admin/base/listorder', postData, function (result) {
        if (result.status === 1) {
            //成功
            return dialog.success(result.message);
        } else if (result.status === 0) {
            // 失败
            return dialog.error(result.message);
        }
    }, "JSON");
});