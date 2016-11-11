{*

    *************************
    *  phpcms 主站基础模板
    *************************
    *
    *************************
*}


{extends file='common/mofang_site.tpl'}

{block name=head}
    {$smarty.block.parent}
    <base target="_blank">
{/block}

{block name=site_nav_content}
<div class="map-box-con clearfix">
    {* 苹果游戏 *}
    <dl>
        <dt><a href="{get_category_url('ios')}" target="_blank">苹果游戏</a></dt>
        <dd>
            {pc M=content action=lists catid=659 order='inputtime DESC' return='sitemap'}
                {foreach from=$sitemap key=k item=val}
                    <a href="{$val.url}" target="_blank">{$val.title}</a>
                {/foreach}
            {/pc}
        </dd>
    </dl>

    {* 安卓游戏 *}
    <dl>
        <dt><a href="{get_category_url('android')}" target="_blank">安卓游戏</a></dt>
        <dd>
            {pc M=content action=lists catid=660 order='inputtime DESC' return='sitemap'}
                {foreach from=$sitemap key=k item=val}
                    <a href="{$val.url}" target="_blank">{$val.title}</a>
                {/foreach}
            {/pc}
        </dd>
    </dl>

    {* 手游产业 *}
    <dl>
        <dt><a href="{get_category_url('chanye')}" target="_blank">手游产业</a></dt>
        <dd>
            {pc M=content action=lists catid=661 order='inputtime DESC' return='sitemap'}
                {foreach from=$sitemap key=k item=val}
                    <a href="{$val.url}" target="_blank">{$val.title}</a>
                {/foreach}
            {/pc}
        </dd>
    </dl>

    {* 热门专区 *}
    <dl>
        <dt><a href="#" target="_blank">热门专区</a></dt>
        <dd>
            {pc M=content action=lists catid=662 order='inputtime DESC' return='sitemap'}
                {foreach from=$sitemap key=k item=val}
                    <a href="{$val.url}" target="_blank">{$val.title}</a>
                {/foreach}
            {/pc}
        </dd>
    </dl>
</div>
{/block}
