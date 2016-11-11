{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_acg/wap/base.tpl'}

{block name=head}
    <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
    <meta property="fb:app_id" content="" />
    <meta property="og:type"   content="article" />
    <meta property="og:url"    content="{trim($url)}" />
    <meta property="og:title"  content="{$title}" />
    <meta property="og:image"  content="{$thumb}" />
    <meta property="og:description"  content="{$description}" />
    {$smarty.block.parent}
{/block}

{block name='content'}
    <div class="m-content">
    	{*news-top*}
        {include file="tw_acg/widget/wap/news_detail.tpl"}
    	{*相關標籤*}
        {include file="tw_acg/widget/wap/tag_detail.tpl"}
        {*首页list*}
        {include file="tw_acg/widget/wap/related.tpl"}
	 </div>
{/block}

{block name='footer'}
    {$smarty.block.parent}
    <script language="JavaScript" src="{$smarty.const.APP_PATH}api.php?op=count&id={$id}&modelid={$modelid}"></script>
    <script>
        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.5&appId=1500638963557330";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
{/block}