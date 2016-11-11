define('ad',['jquery'], function(require, exports, module){

    var $ = require('jquery');
    var jQuery = $;

    /**
    *	jquery 广告扩展 支持 Google baidu  等常见的广告商
    *
    *	1 参数 加载的js 文件 多个js 依次使用数组 []
    *	2 参数 init 回调函数
    *	3 参数 完成 回调函数
    *
    *	// Google 的
    *	$('#ad_google').ad('http://pagead2.googlesyndication.com/pagead/show_ads.js', function(){
    *		google_ad_client = "pub-12312312312";
    *		google_ad_slot = "12312312";
    *		google_ad_width = 728;
    *		google_ad_height = 90;
    *	});
    *
    *	// 搜狗的
    *	$('#ad_sohu').ad('http://images.sohu.com/cs/jsfile/js/c.js',function(){
    *		window.sogou_ad_id=12312;
    *		window.sogou_ad_height=60;
    *		window.sogou_ad_width=468;
    *	});
    *
    *	// 百度的
    *	$('#ad_baidu').ad('http://cpro.baidu.com/cpro/ui/c.js',function(){
    *		window.cpro_id = 'u123';
    *	});
    *
    *
    *	// 淘宝的
    *	$('#ad_taobao').ad('http://a.alimama.cn/inf.js',function(){
    *		alimama_pid="mm_123_123_123";
    *		alimama_width=336;
    *		alimama_height=280;
    *	});
    *
    *	主意: 变量声明带有var的就需要修改 var lianyue 需要修改成 window.lianyue
    *
    **/
    ;(function($){
        var ad = [], old = [document.write,document.writeln], run = false, load = false;

        var handle = function(){
            run = true;
            if ( !ad.length ) {
                run = false;
                return false;
            }
            var a = ad.shift(), s = [];

            // 执行 init
            a[2].apply();

            // 修改2个函数
            document.write = function(){
                var g = arguments, j = [], k, v;
                // 处理 里面带有的 js

                $.buildFragment( g, document, j );
                for( k in j ) {
                    v = j[k];
                    if( j[k].src ) {
                        s.push( j[k].src );
                    }
                    if ( j[k].innerHTML ) {
                        eval( j[k].innerHTML );
                    }
                }
                // 遍历添加 值
                $.each( g,function( kk, vv ){
                    $(a[0]).each(function() {
                        this.innerHTML += vv;
                    });
                });
            };
            document.writeln = function() {
                var g = [];
                $.each( arguments,function( k, v ){
                    g[k] = v + "\n";
                });
                document.write.apply( this, g );
            };


            // 执行函数
            forcall = function(){
                if ( !a[1].length ) {
                    document.write = old[0];
                    document.writeln = old[1];

                    // 执行 complete
                    a[3].apply();

                    // 运行 下一个 ad
                    handle.apply();

                    return false;
                }


                var	complete = function(){
                    a[1] = s.concat( a[1] );
                    s = [];
                    forcall.apply();
                };
                var e = $('<script></script>').attr({ type: 'text/javascript', src: a[1].shift() })[0];
                if( e.readyState ) {
                    e.onreadystatechange = function() {
                        if( $.inArray( e.readyState, ['loaded', 'complete'] ) != -1 ) {
                            complete.apply();
                        }
                    };
                } else {
                    e.onload = function() {
                        complete.apply();
                    };
                }
                $('head')[0].appendChild(e);

                return true;
            };

            // 回调
            forcall.apply();
            return false;
        };
        $(function(){
            $(window).load(function(){
                load = true;
                // 执行 ad
                handle.apply();
            });
        });


        $.fn.extend({
            'ad':function( a, b, c ) {
                a = a || [];
                a = typeof( a ) == 'string' ? [a] : a;
                b = b || function(){};
                c = c || function(){};
                ad.push([this,a,b,c]);
                if ( !run && load ) {
                    handle.apply();
                }
            }
        });
    })(jQuery);

    module.exports = $;

});
