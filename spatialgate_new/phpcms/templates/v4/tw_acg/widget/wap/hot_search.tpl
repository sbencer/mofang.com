<div class="hotsearch">
        <div class="list_title clearfix">
            <h2 class="logo fl">熱門搜索分類</h2>
        </div>
        <div class="search_content">
        {pc module="content" action="types"}
        	<ul>
            {foreach $data as $val}
        		<li><a href="{$smarty.const.APP_PATH}index.php?m=content&c=tag&tag={$val.name}">{$val.name}（{$val.total}）</a></li>
            {/foreach}
        	</ul>
        {/pc}
        </div>
</div>
{require name="tw_acg:statics/wap/css/hot_search.css"}