{extends file='tyong/base.tpl'}

{block name=main_content}
    <div class="game-load clearfix">
        {include file="tyong/widget/news.tpl"}
		{include file="tyong/widget/bdown.tpl"}
        {include file="tyong/widget/lunbo.tpl"}
    </div>

    {if !empty($module_setting)}
        {foreach from=$module_setting key=md_k item=md_v}
            {$module_name=$md_k}
			{include file="tyong/widget/"|cat:$md_v.type|cat:".tpl"}
        {/foreach}
    {else}
        {foreach from=$column key=c_key item=c_val}
            {include file="tyong/widget/$c_val.tpl"}
        {/foreach}
    {/if}


    {* 百度分享 *}
    {literal}
    <script>
        window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"slide":{"type":"slide","bdImg":"0","bdPos":"right","bdTop":"100"}};
        with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
    {/literal}

    {include file="tyong/widget/relaxed.tpl"}
    {require name="tyong:statics/js/tyong.js"}
    {require name="tyong:statics/js/search.js"}
{/block}

