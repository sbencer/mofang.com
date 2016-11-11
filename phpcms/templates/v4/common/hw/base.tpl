{*
    * -->> base/seajs_base.tpl
    *************************
    *  base基类模板
    *************************
    *  登录注册
    *  统计代码
    *************************
*}

{extends file='common/hw/seajs_base.tpl'}

{* 头部添加环境变量 *}
{block name=head}
    {$smarty.block.parent}
    <script>
        var lang_conf = "TW";
        {block name=head_js}
            var defaultURL = "http://u.mofang.com.tw";
        {/block}
    </script>
    {require name="common:statics/css/login.css"}
    {require name="common:statics/js/hw/base-config.js"}
    {require name="common:statics/css/common-ref.css"}
    {script}
        seajs.use(["login/check"])
    {/script}   
{/block}
{block name='tongji'}
{literal}
	<div style="display:none;">

		<!-- Start Alexa Certify Javascript -->
		<script type="text/javascript">
		_atrk_opts = { atrk_acct:"yaoJi1a8Dy00w9", domain:"mofang.com.tw",dynamic: true};
		(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
		</script>
		<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=yaoJi1a8Dy00w9" style="display:none" height="1" width="1" alt="" /></noscript>
		<!-- End Alexa Certify Javascript -->
	</div>
{/literal}
{/block}
