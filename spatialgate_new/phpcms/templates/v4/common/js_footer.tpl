{*

    **************************************************
    * 创建静态页面时，在底部输出footer和统计代码的js调用
    ***************************************************
*}

{htmljs mode=NOSCRIPT sampleRate=0 fid=false framework="common:statics/js/loader/sea.js" }

{block name="footer_main"}
    {include file="common/links.tpl"}
{/block}

{* 主要内容区域 *}
<script>
seajs.use(['login','wechat'],function(MFLogin,wechat) {
    //console.log(MFLogin,wechat);
});
</script>
<!-- ok -->


{/htmljs}
