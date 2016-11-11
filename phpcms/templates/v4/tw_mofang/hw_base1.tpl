
{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='hw_mfang/hw_base.tpl'}
    {block name=head}
	    <script>
	        {* 组件之间调用 *}
	        var MFE = {};

	        {* 与后台数据交互 *}
	        var CONFIG = {};
	    </script>

	    {$smarty.block.parent}

	    {if $siteid == 3}
        {require name="hw_mfang:statics/css/hw_list_jp.css"}
        {else}
        {require name="hw_mfang:statics/css/hw_list_en.css"}
        {/if}
	{/block}
    {* 主体区域 *}
    {block name=main}
        

		<div class="hw-game-main w-1000 clearfix">
			<div class="comm-hd">
				<h2>
					<a href="#">{t}首頁{/t}</a>&nbsp;&gt;&nbsp;
					<a href="#" class="wd-orange">{t}文章詳情{/t}</a>
				</h2>
			</div>
			{block name="main-content"}
			{/block}
			{require name="hw_mfang:statics/js/index.js"}
			{require name="hw_mfang:statics/js/article.js"}
			{script}
				seajs.use(['hw/index','hw/article'])
			{/script}
		</div>
    {/block}
    {block name=sidebar}
        {*側邊欄*}
        {* {include file="hw_mfang/widget/sidebar.tpl"} *}
    {/block}

