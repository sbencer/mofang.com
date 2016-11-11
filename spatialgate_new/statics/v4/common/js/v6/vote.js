/**
 * 顶踩PK状态,wap-pc共用的评论插件
 * @author xukuikui
 * @date 2015-07-31
 * 这个顶踩插件，是pc,m端公用的
 */
define("v6_vote",["jquery","jquery/cookie","jquery/jquery-pop"],function(require, exports, module) {
    var $ = require("jquery");//jquery
        require("jquery/jquery-pop");//加载弹出框
        require("jquery/cookie");//cookie
    /*
    dom:{
        good:'.good',//顶的选择权
        bad:'.bad',//踩的选择器
        action:'click'//点击
    },
    ajaxData:{
        getVoteUrl:window.mfconfig.mofangUrl+'/index.php?m=digg&c=index&a=digg_zt_is',//获取取顶踩的数据
        setVoteUrl:window.mfconfig.mofangUrl+'/index.php?m=digg&c=index&a=digg_zt_get',//顶踩发送数据
        type:'GET',//发送的方式
        dataType:'jsonp',
        beforeSend:function(CBStr){},
        success:function(CBStr,data){},//返回CBStr:ding,CBStr:down踩
        error:function(CBStr){},
        complete:function(CBStr){}
    },
    data:{
       ztid:'',//评论id
       type:{
            good:'digg',//顶，传递的type=digg
            bad:'down'//踩，传递type=bad
       }
        
    }
    */
	// 投票插件
    $.fn.v6_vote=function(message){
        var defaults = {
            dom:{
                good:'.good',
                bad:'.bad',
                action:'click'
            },
            ajaxData:{
                getVoteUrl:window.mfconfig.mofangUrl+'/index.php?m=digg&c=index&a=digg_zt_is',
                setVoteUrl:window.mfconfig.mofangUrl+'/index.php?m=digg&c=index&a=digg_zt_get',
                type:'GET',
                dataType:'jsonp',
                beforeSend:null,
                success:null,
                error:null,
                complete:null
            },
            data:{
               ztid:'',
               type:{
                    good:'digg',
                    bad:'down'
               }
                
            }
        };
        var options = $.extend(true,defaults,message);
        var _this = this;
        var lock = false;
       // 成功之前的回调函数
        options.ajaxData.beforeSend = options.ajaxData.beforeSend || function(CBStr){
            
        };
        // 成功的回调函数
        options.ajaxData.success = options.ajaxData.success || function(CBStr,res){
            
        };
        // 失败的回调函数
        options.ajaxData.error = options.ajaxData.error || function(CBStr,res){
            
        };

        // 不管成功与否都回调的函数
        options.ajaxData.complete = options.ajaxData.complete || function(CBStr){

        };

        //加载数据
        fnAjax({
           url:options.ajaxData.getVoteUrl
        });

        //赞一个
        $(_this).find(options.dom.good).off(options.dom.action).on(options.dom.action,function(e){
            fnAjax({
               CBStr:options.data.type.good,
               url:options.ajaxData.setVoteUrl,
               data:{
                   type:options.data.type.good
               }
            });
            e.preventDefault();
        });
        //踩一个
        $(_this).find(options.dom.bad).off(options.dom.action).on(options.dom.action,function(e){
            fnAjax({
               CBStr:options.data.type.bad,
               url:options.ajaxData.setVoteUrl,
               data:{
                   type:options.data.type.bad
               }
            });
            e.preventDefault();
        });

        // 执行ajax
        function fnAjax(json){
            var defaultsAjax = {
                CBStr:null,
                url: options.ajaxData.getVoteUrl,
                type: options.ajaxData.type,
                dataType: options.ajaxData.dataType,
                beforeSend: options.ajaxData.beforeSend,
                success: options.ajaxData.success,
                error: options.ajaxData.error,
                complete: options.ajaxData.complete,
                data: {
                    ztid:options.data.ztid
                },
            };
            var optionsAjax = $.extend(true,defaultsAjax,json);
            if(hasVote(optionsAjax.data.ztid) && optionsAjax.CBStr != null){
                $(".pop-warn").pop({
                    msg:"亲,您已经表过态了！^-^",
                    autoTime:2000,
                    isAutoClose:true
                });
                return false;
            }
            if(lock){
                return false;
            }
            $.ajax({
                url: optionsAjax.url,
                type: optionsAjax.type,
                dataType: optionsAjax.dataType,
                data:optionsAjax.data,
                beforeSend:function(){
                    lock=true;
                    return optionsAjax.beforeSend(optionsAjax.CBStr);
                },
                success:function(res){
                    if(typeof res == 'string'){
                        res = $.parseJSON(res);
                    }
                    if(res && !res.code){
                        if(optionsAjax.CBStr != null){
                           $.cookie(optionsAjax.data.ztid, 1, {expires: 7, path: '/'}); 
                        }
                        return optionsAjax.success(optionsAjax.CBStr,res);
                    }
                    
                },
                error:function(res){
                    return optionsAjax.error(optionsAjax.CBStr,res);
                },
                complete:function(){
                    lock=false;
                    return optionsAjax.complete(optionsAjax.CBStr);
                }
            });
        };
        //是否投过票
        function hasVote(key){
            var v = $.cookie(key);
            if(v=="1"){
                return true;
            }
            return false;
        }

    };
    if (typeof module != "undefined" && module.exports) {
        module.exports.$ = $;
    }
     /*
    *   title:'标题,左上角位置',//左上角标题
        msg:'提示信息,你暂时未登录，请登录后操作',//提示信息
        titleClass:'.pop-title',//标题class
        msgClass:'.pop-msg',//提示信息class
        closeClass:'.close',//关闭class
        cancelClass:'.pop-cancel',//取消class
        okClass:'.pop-ok',//确定class
        autoTime: 2000,//自动隐藏pop时间
        isAutoClose:false,//是否自动关闭
        fnCallback: function(isTrue,msg){//回调函数，确定，true,false,msg,提示信息

        }
    *
    *
    */
});
    
