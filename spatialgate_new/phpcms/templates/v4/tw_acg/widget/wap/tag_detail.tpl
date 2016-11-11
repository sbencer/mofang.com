<div class="hotsearch">
        <div class="list_title clearfix">
            <h2 class="logo fl">相關分類資訊</h2>
        </div>
        <div class="search_content">
        {pc module="content" action="types" typeid=$typeid}
        	<ul>
            {foreach $data as $val}
        		<li>
                    <a href="{$smarty.const.APP_PATH}/index.php?m=content&c=tag&catid={$catid}&tag={$val.name}">{$val.name}（{$val.total}）
                    </a>
                </li>
            {/foreach}         
        	</ul>
        {/pc}
        </div>
</div>
{require name="tw_acg:statics/wap/css/hot_search.css"}
