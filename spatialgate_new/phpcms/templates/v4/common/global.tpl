
    {* 统计代码 *}
    {block name=tongji}
    {literal}
    <script>
        //load cnzz
        function loadScript(id,src, callback) {

            var cnzz_protocol = (("https:" == document.location.protocol) ? " https://": " http://");
            var cnzz_url = ""+cnzz_protocol+"w.cnzz.com/q_stat.php?id=" + id + "";

            var s, r, t;
            r = false;
            s = document.createElement('script');
            s.defer = "defer";
            s.async="async";
            s.type = 'text/javascript';
            s.src = src || cnzz_url;

            s.onload = s.onreadystatechange = function() {
                if (!r && (!this.readyState || this.readyState == 'complete')) {
                    r = true;
                   callback && callback();
                }
            };

            t = document.getElementsByTagName('script')[0];
            t.parentNode.insertBefore(s, t);
        }
        //封装多事件
        function bindEvent(obj, ev, fn) {
            if (obj.addEventListener) {
                obj.addEventListener(ev, fn, false);
            } else if(obj.attachEvent) {
                obj.attachEvent('on' + ev, function() {
                    fn.call(obj);
                })
            } else {
                obj['on'+ ev] = fn;
            }
        }
    </script>
    {/literal}
    <div style="display: none">
        {$smarty.const.STATISTICAL}
        {block name=statistical}

            {* 在不同页面增加不同统计代码 *}
            {* 如果在phpcms内 *}
            {if $smarty.const.PC_PATH }
                {pc M=content action=get_catid_son catid=471 type=1 return=video_catids} {/pc}
                {pc M=content action=get_catid_son catid=121 type=1 return=chanye_catids} {/pc}
                {if in_array($smarty.get.catid, $video_catids)}
                    {literal}
                    <script type="text/javascript">
                        //测试异步cnzz
                        bindEvent(window,"load",function(){
                            loadScript("1000353566");
                        })
                        //var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
                        //document.write(unescape("%3Cspan id='cnzz_stat_icon_1000353566'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "w.cnzz.com/q_stat.php%3Fid%3D1000353566' type='text/javascript'%3E%3C/script%3E"));
                    </script>
                    {/literal}
                {elseif in_array($smarty.get.catid, $chanye_catids)}
                    {literal}
                    <script type="text/javascript">
                        bindEvent(window,"load",function(){
                            loadScript("1000353559");
                        })

                        //var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
                        //document.write(unescape("%3Cspan id='cnzz_stat_icon_1000353559'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "w.cnzz.com/q_stat.php%3Fid%3D1000353559' type='text/javascript'%3E%3C/script%3E"));
                    </script>
                    {/literal}
                {else}
                    {literal}
                    <script type="text/javascript">
                        bindEvent(window,"load",function(){
                            loadScript("1000008655");
                        })

                        //var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
                        //document.write(unescape("%3Cspan id='cnzz_stat_icon_1000008655'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "w.cnzz.com/q_stat.php%3Fid%3D1000008655' type='text/javascript'%3E%3C/script%3E"));
                    </script>
                    {/literal}
                {/if}
            {/if}

        {/block}

        {* 全站通用的 *}
        {* 百度 *}
        {literal}
        <script type="text/javascript">
        var _hmt = _hmt || [];
            (function() {
              var hm = document.createElement("script");
              hm.src = "//hm.baidu.com/hm.js?c010118fc9ccb89ca3c38b4808b4dd4e";
              var s = document.getElementsByTagName("script")[0];
              s.parentNode.insertBefore(hm, s);
            })();
        </script>
        {* Google *}
        <script>
            (function(i,s,o,g,r,a,m){
                i['GoogleAnalyticsObject']=r;
                i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},
                i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];
                a.async=1;
                a.src=g;
                m.parentNode.insertBefore(a,m)
            })
            (window,document,'script','//www.google-analytics.com/analytics.js','ga');
            ga('create', 'UA-55120651-1', 'auto');
            ga('send', 'pageview');
        </script>
        {/literal}
    </div>
    {/block}

    {* 全站命令行招聘信息 *}
    {if !$mfe_go_home }
	<script>
	    setTimeout(function(){
            seajs.use(['jobs']);
	    },100);
	</script>
    {/if}

    {* ie低版本浏览器提示 *}
	<script>
	if(/MSIE\s+[4567]/.test(navigator.userAgent)){
            setTimeout(function(){
               seajs.use(['ie/update_tip']);
            },100);
        }
	</script>

    {* 所有专区右下角推送内 容 *}
    {if $is_partition==1}
    <script>
        window.CONFIG = window.CONFIG || {};
        CONFIG.partationPopupUrl = "{$floating_url}";
        seajs.use("p/popup");
    </script>
    {/if}

    {* ie6 firebug lite 调试工具 *}
    {if $smarty.get.firebug }
        <script type="text/javascript" src="https://getfirebug.com/firebug-lite-debug.js"></script>
    {/if}
