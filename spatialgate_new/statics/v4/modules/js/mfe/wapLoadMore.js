/*
    分页插件,适合只有加载更多，（只有"下一页"按钮的情况）
*/

define('mfe/wapLoadMore', ['jquery'], function(require, exports, module) {
    var $ = require('jquery');
    ;(function(){
        var isTouch = ('ontouchstart' in document.documentElement) ? 'touchstart' : 'click', _on = $.fn.on;
        $.fn.on = function(){
        arguments[0] = (arguments[0] === 'click') ? isTouch: arguments[0];
        return _on.apply(this, arguments);
        };
    })();

    /*
    $(".loadMore").loadMore({
        obj:_this,//在某个元素插入,（可不填，默认是绑定的元素）
        insertMode:'before',//插入方式,这里指得时jquery各种插入方式（可不填，默认是插入绑定的元素的前面）
        insertAction:'click',//插入时的动作,click,mouseover,mouseenter,scrollBottom[滚动加载],default[直接加载]（可不填,默认是click）
        data:{},//传递的参数，以及分页所需的基本参数（可不填，默认当前页数据是第0条，每次加载10条。可以获取绑定元素的属性比如，data-currpage,data-total等）
        ajaxData:{//ajax参数
            url:'',
            type:'GET',
            dataType:'json',
            success:null,
            error:null,
            complete:null
        },
        namePar:{
            total: 'total', //总个数变量名，（可不填，不填的话，后台每次返回总数）
            currpage: 'currpage',//当前页变量名（必填,值和data传递的参数一致）
            pagenum: 'pagenum' //每页几条变量名（必填,值和data传递的参数一致）
        }
    });
    */

    $.fn.loadMore=function(message){
        var _this = this ;
        var defaults={
            obj:_this,//在某个元素插入,（可不填，默认是绑定的元素）
            insertMode:'before',//插入方式,这里指得时jquery各种插入方式（可不填，默认是插入绑定的元素的前面）
            insertAction:'click',//插入时的动作,click,mouseover,mouseenter,scrollBottom[滚动加载],default[直接加载]（可不填,默认是click）
            data:{},//传递的参数，以及分页所需的基本参数（可不填，默认当前页数据是第0条，每次加载10条）
            ajaxData:{//ajax参数
                url:'',
                type:'GET',
                dataType:'json',
                success:null,
                error:null,
                complete:null
            },
            namePar:{
                total: 'total', //总个数变量名，（可不填，不填的话，后台每次返回总数）
                currpage: 'currpage',//当前页变量名（可不填,默认值“currpage”，必须和data传递的参数一致）
                pagenum: 'pagenum' //每页几条变量名（可不填,默认值'pagenum'，必须和data传递的参数一致）
            }
        };

        var options  = $.extend(defaults, message);
        //是否加载
        _this.isLoad=true;
        //防止重复点击
        _this.lock=false;

        ;(function(){
            var isTouch = ('ontouchstart' in document.documentElement) ? 'touchstart' : 'click', _on = $.fn.on;
            $.fn.on = function(){
            arguments[0] = (arguments[0] === 'click') ? isTouch: arguments[0];
            return _on.apply(this, arguments);
            debugger;
            };
        })();

        //如果ajax的参数为空的时候，取obj上面的属性值
        for(var i in options.data){
            options.data[i]= options.data[i] || _this.attr('data-'+options.data[i]);
        }

        //当前页
        options.data[options.namePar.currpage] = options.data[options.namePar.currpage] || 0;
        
        //是否total pagenum 值
        if(options.data[options.namePar.pagenum] == undefined){
            options.data[options.namePar.pagenum]=10;
           
        }
        //是否传了总条数
        if(options.data[options.namePar.total]){
           _this.pageTotal = Math.ceil(options.data[options.namePar.total]/options.data[options.namePar.pagenum]);
        }
        //成功地回调函数
        options.ajaxData.success = options.ajaxData.success || function(res){   
            //res =  $.parseJSON(res);
            
            if(typeof res == 'string'){
                res = $.parseJSON(res);
            }
            if(res && res.code == 0){
                //渲染数据
                $(options.obj)[options.insertMode](res.data);

                //
                if(res && res.total<=(options.data[options.namePar.pagenum]*options.data[options.namePar.currpage])){
                    $(_this).hide();
                    _this.isLoad = false;
                    return true;
                }
                //
                if(options.data[options.namePar.total] && _this.pageTotal<=options.data[options.namePar.currpage]){
                    $(_this).hide();
                    _this.isLoad = false;
                    return true;
                }
            }else{
                if(res.msg){
                    alert(res.msg);
                }else{
                    alert("加载完毕，已没有更多数据");
                }
               options.data[options.namePar.currpage]--;
            }
        };

        //失败的回调函数
        options.ajaxData.error = options.ajaxData.error || function(res){
            alert("网络出错,请刷新后重试");
            options.data[options.namePar.currpage]--;
        };
        //不管成功失败都回调的函数
        options.ajaxData.complete = options.ajaxData.complete || function(){
           
        };

        //执行ajax交互
        function ajaxFn(){

            if(_this.lock || !_this.isLoad){
                return;
            }
            options.data[options.namePar.currpage]++;
            _this.lock=true;
            $.ajax({
                url: options.ajaxData.url,
                type: options.ajaxData.type,
                dataType:options.ajaxData.dataType,
                timeout:8000,
                data: options.data,
                error:function(res){
                    options.ajaxData.error(res);
                    return false;
                },
                success:function(res){
                    options.ajaxData.success(res);

                    return true;
                },
                complete:function(){
                    options.ajaxData.complete();
                    _this.lock=false;
                    return;
                }

            });
        }
        //以上是处理参数，处理参数完毕
        
        //直接加载
        if(options.insertAction == 'default'){
            ajaxFn();
            return true;
        }

        //滚动加载
        if(options.insertAction == 'scrollBottom'){ 
            $(window).scroll(function(event) {
                scrollB();
            });
            $(window).load(function(event) {
                scrollB();
            });
            function scrollB(){
               /* Act on the event */
                var oObjOffsetTop = _this.offset().top;
                var docHeight = $(window).height();
                var winScrollTop = $(window).scrollTop();
                if(oObjOffsetTop<=(docHeight+winScrollTop)){
                    ajaxFn();
                } 
            }
            return true;
        }
        // 绑定事件加载
        $(_this).off(options.insertAction).on(options.insertAction,function(e){
            e.preventDefault();
            ajaxFn();

        });
    
    }
    if (typeof module != "undefined" && module.exports) {
        module.exports = $;
    }
    
});


