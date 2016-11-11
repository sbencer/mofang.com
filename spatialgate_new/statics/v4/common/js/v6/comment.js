/**
 * 检测登录状态,wap-pc共用的评论插件
 * @author xukuikui
 * @date 2015-07-06
 * 这个评论插件，是pc,m端公用的
 */
define("comment",["jquery","mf_face","check_login","jquery/jquery-pop","jquery/jquery-reluserurl"],function(require, exports, module) {
  
    var $ = require("jquery");//jquery
        require("mf_face");//表情包
    var login = require("check_login");//是否登录
        require("jquery/jquery-pop");//加载弹出框
        require("jquery/jquery-reluserurl");//登录带上参数

	var getCommentHTMLUrl = window.mfconfig.commentUrl+'/comment/index';//获取html地址
	var setCommentUrl=window.mfconfig.commentUrl+"/comment/reply";//发送消息
    var getCommentUrl=window.mfconfig.commentUrl+"/comment/list";//接收信息
    var isLock=false;//开关
    var ajaxMethod = 'jsonp';
    var lastPid = 0;//最后一个pid
    window.mfconfig = window.mfconfig || {};
    window.mfconfig.bbsUrl = window.mfconfig.bbsUrl || 'http://bbs1.mofang.com';
    window.mfconfig.userInfoUrl = window.mfconfig.userInfoUrl || 'http://u.mofang.com';
    //获取评论列表
    function fnFloorList(obj,options){
        $.ajax({
            url:getCommentUrl,
            type:"GET",
            dataType:ajaxMethod,
            data:{
                flag: options.flag,
                pid: lastPid,
                pagesize: options.pagesize
            },
            beforeSend:function(){
                isLock=true;
            },
            success: function(res) {
                if(res && res.code==0){
                    //总数
                    if(res.data.total == ''){
                        $(obj).find(".mf-cmt-num").html('<a href="javascript:;"><span>0</span>人已评论</a>');
                    }else{
                        $(obj).find(".mf-cmt-num").html('<a href="'+window.mfconfig.bbsUrl+'/thread/'+res.data.tid+'.html" target="_blank"><span>'+res.data.total+'</span>人已评论</a>');
                    }
                    var dataArr = res.data.list;

                    if(dataArr.length<=options.pagesize || dataArr.length==0){
                        var html = floorDom(obj,res.data.list);
                        //进数据
                        $(obj).find(".mf-cmt-con").append(html);
                        //是否显示加载更多
                        $(obj).find(".mf-cmt-more").hide();
                    }else{
                        var html = floorDom(obj,res.data.list);
                        //进数据
                        $(obj).find(".mf-cmt-con").append(html);
                    }
                }else{
                    // $(".pop-top-fail").pop({
        //                 msg:"获取帖子失败~",
        //                 autoTime:1000,
        //                 isAutoClose:false
        //             });
                }
            },
            error: function() {
            },
            complete: function(){
                isLock=false;
            }
        });

        function floorDom(obj,data){
            $(".mf-cmt-more").show();
            
            var str = '';
            for(var i=0;i<data.length;i++){
                lastPid=data[i].pid;

                str += '<div class="mf-cmt-list">'
                    +'<p class="mf-user-head" data-pid="'+data[i].pid+'">'
                        +'<a href="'+window.mfconfig.userInfoUrl+'/home/public/info?to_uid='+data[i].user.user_id+'" target="_blank"><img src="'+data[i].user.avatar+'" alt=""></a>'
                    +'</p>'
                    +'<dl class="mf-user-info">'
                        +'<dt><a href="'+window.mfconfig.userInfoUrl+'/home/public/info?to_uid='+data[i].user.user_id+'" class="cmt-name" target="_blank">'+data[i].user.nickname+'</a><span class="pc-time">   发表于 : '+formatTime(data[i].create_time)+'</span><span class="m-time r">'+formatTime(data[i].create_time)+'</span></dt>'
                        +'<dd>'+data[i].html_content+'</dd>'
                        +'<dd class="mf-cmt-last">'
                            +'<a class="replay" href="javascript:;">回复</a></dd>'
                    +'</dl>'
                +'</div>';
            
            }
            
            return str;

        }

        
    }
    //

    function fnFloorSend(obj,options){
        //点击列表数据回复按钮
        $("body").on("click",'.replay',function(){
            var name = $(this).parents(".mf-user-info").find(".cmt-name").text();
            name = '@'+name+'：';
            $("#commentText").val(name);
            $("#commentText").focus();
        })
        $(obj).find(".mf-cmt-btn").click(function(ev) {
            /* Act on the event */
               isLogin(obj,options);
        });

        $(obj).find(".mf-cmt-text").keydown(function(ev) {
            if(ev.which == 13){
                isLogin(obj,options);
            }
        });

        function isLogin(obj,data){
            //是否登录
            login.fnLoginStatus(function(isLogin){
                if(!isLogin){
                    $(".pop-login").pop({
                        msg:"请登录后继续操作",
                        fnCallback: function(isTrue,msg,obj){
                            if(isTrue){
                                window.location.href=$(obj).loginUserUrl();
                            }
                        }
                    });
                    
                }else{
                    floorSendAjax(obj,data);
                }
                return isLogin;
            });
        }

        function floorSendAjax(obj,data){
            if(isLock){
                return false;
            }
            var con = $(obj).find(".mf-cmt-text").val();
                con = $.trim(con);
                
            if(con==''){
                $(".pop-top-fail").pop({
                    msg:"评论不能为空",
                    autoTime:1000,
                    isAutoClose:true
                });
                return false;
            }
            if(con.length>140){
                $(".pop-top-fail").pop({
                    msg:"超过140字",
                    autoTime:1000,
                    isAutoClose:true
                });
                return false;
            }
            var defaults={};
                defaults.flag=options.flag;
                defaults.content = con;

            $.ajax({
                url:setCommentUrl,
                type:"GET",
                dataType:ajaxMethod,
                data:defaults,
                beforeSend:function(){
                    isLock=true;
                },
                success: function(res) {
                    
                    if(res && res.code==0){
                        
                        $(".pop-post-ok").pop({
                            msg:"评论成功",
                            autoTime:1000,
                            isAutoClose:true
                        });
                        var num = parseInt($(obj).find(".mf-cmt-num a span").html());
                            num+=1;
                        $(obj).find(".mf-cmt-num a span").html(num);
                        var str = '<div class="mf-cmt-list">'
                            +'<p class="mf-user-head" data-pid="'+res.data.pid+'">'
                                +'<a href="'+window.mfconfig.userInfoUrl+'/home/public/info?to_uid='+res.data.user.user_id+'"><img src="'+res.data.user.avatar+'" alt="" target="_blank"></a>'
                            +'</p>'
                            +'<dl class="mf-user-info">'
                                +'<dt><a href="'+window.mfconfig.userInfoUrl+'/home/public/info?to_uid='+res.data.user.user_id+'" class="cmt-name" target="_blank">'+res.data.user.nickname+'</a>   <span class="pc-time">发表于 : '+formatTime(res.data.create_time)+'</span><span class="m-time r">'+formatTime(res.data.create_time)+'</span></dt>'
                                +'<dd>'+res.data.html_content+'</dd>'
                                +'<dd class="mf-cmt-last">'
                                    +'<a href="javascript:;" class="replay">回复</a></dd>'
                            +'</dl>'
                        +'</div>';

                        $(obj).find(".mf-cmt-con").prepend(str);
                        $(obj).find(".mf-cmt-text").val("");
                    }else{
                        $(".pop-top-fail").pop({
                            msg:"评论失败,刷新重试",
                            autoTime:1000,
                            isAutoClose:true
                        });
                    }
                },
                error: function() {
                    $(".pop-top-fail").pop({
                        msg:"评论失败,刷新重试",
                        autoTime:1000,
                        isAutoClose:true
                    });
                },
                complete: function(){
                    isLock=false;
                }
            });
        }


    }
    //打印HTML
    function fnToHtml(obj,options,fnCallback){
        $.ajax({
            url:getCommentHTMLUrl,
            type:"GET",
            dataType:ajaxMethod,
            data:{
                flag: options.flag
            },
            beforeSend:function(){
                
            },
            success: function(res) {
                if(res && res.code==0){
                   $(obj).html(res.data);
                   fnCallback(false);
                }else{
                   fnCallback(true);
                }
            },
            error: function() {
                fnCallback(true);
            }
        });
    }
    //处理时间小方法

    function formatTime(value){
        var time = new Date(value*1);
        var year = time.getFullYear();
        var month = time.getMonth()+1;
        var date = time.getDate();

        var hours = time.getHours();
        var minutes = time.getMinutes();
        var seconds = time.getSeconds();

        function to2(n){
            return n<10 ? '0'+n : n;
        }
        var str = to2(year)+'-'+to2(month)+'-'+to2(date)+' '+to2(hours)+':'+to2(minutes);
        
        return str;
        
    
       
    }
    //
    //对外暴露接口
    function fnMFComment(obj,options){
        var defaults = {
            flag: $(obj).attr("data-flag"),
            pagesize: 20
        };
        options = $.extend(true, defaults, options);

        //打印数据
        fnToHtml(obj,options,function(err){
            if(!err){
                $(".face").face();//表情加载处理
                fnFloorList(obj,options);
                $(obj).find(".mf-cmt-more").click(function(){
                    if(isLock){
                        return false;
                    }
                    fnFloorList(obj,options);
                });

                fnFloorSend(obj,options);  
            }
             
        });

        
    }

    if (typeof module != "undefined" && module.exports) {
        module.exports.fnMFComment = fnMFComment;
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
    
