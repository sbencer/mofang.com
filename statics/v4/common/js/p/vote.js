define('mf/vote', ['jquery', 'jquery/cookie'], function(require, exports, module) {
    var $ = require('jquery');
    require('jquery/cookie');

    $('.mf-commom-vote').each(function(){
        var vote = $(this);
        var support = vote.find('.support-btn');
        var oppose = vote.find('.oppose-btn');

        var support_count = vote.find('.support-count');
        var oppose_count = vote.find('.oppose-count');
        var id= support.attr("name");
        $.ajax({
            url: 'http://www.mofang.com/index.php?m=content&c=index&a=ajax_nocache',
            type: 'get',
            dataType: 'jsonp',
            data: {
                id:id,
                type:'mood'
            },
            error:function(){
                alert("连接服务器失败,请重试");
            },
            success:function(data){
                support_count.text(data.n7);
                oppose_count.text(data.n5);
            }
        });
        function change(el,n){
            var c = el.text();
            c = window.parseInt(c,10);
            if(isNaN(c)){
                c = 0;
            }
            c = c < 0 ? 0 :c;
            el.text(c+n);
        }
        var key = 'has-vote'+id;
        function hasVote(){
            var v = $.cookie(key);
            if(v==="1"){
                return true;
            }
            return false;
        }
        function v(code,paream){
            if(hasVote()){
                alert("您已经投过票了");
                return false;
            }
            var count = code === 1 ? support_count.text() : oppose_count.text();
            $.ajax({
                url: 'http://www.mofang.com/index.php?m=mood&c=index&a=mf_good&id='+paream+'&count='+count,
                type: 'get',
                dataType: 'jsonp',
                data: {
                    code:code
                },
                error:function(){
                    alert("连接服务器失败,请重试");
                },
                success:function(response){
                    if(!response.code){
                        if(code===1){
                            change(support_count,1);
                        }
                        if(code===-1){
                            change(oppose_count,1);
                        }
                        $.cookie(key, 1, {expires: 7, path: '/'});
                        return true;
                    }
                    if(response.code){
                        if(response.msg){
                            alert(response.msg);
                        }else{
                            alert("连接服务器失败,请重试");
                        }
                        return false;
                    }
                    return true;
                }
            });
            return true;
        }
        support.click(function(){
            v(1,id);
        });
        oppose.click(function(){
            v(-1,id);
        });
    });
})
seajs.use('mf/vote');
