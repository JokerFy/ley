window.base={
    getData:function(params){
        if(!params.type){
            params.type='get';
        }
        var that=this;
        $.ajax({
            type:params.type,
            url:params.url,
            data:params.data,
            success:function(res){   ;
                console.log(res);
                /*str = JSON.parse(res);
                console.log(str)*/
                params.sCallback && params.sCallback(res);
            },
            error:function(res){
                var str = res.responseText;
                var Exception = JSON.parse(str).msg;
                if(!Exception){
                    Exception = '处理异常'
                }
                params.eCallback && params.eCallback(Exception);
            }
        });
    }
};