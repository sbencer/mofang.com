{*

    *************************
    *  移动端base定义
    *************************
    *
    *  所有模板文件都需从此模板继承
    *
    *  title  : 页面title
    *  head   : 插入到head
    *  body   : 插入到body
    *  keyword
    *  description
    *  author : Eilvein
    *************************
*}
{* BIGPIPE QUICKLING NOSCRIPT *}
<!doctype html>
{html mode=NOSCRIPT framework="common:statics/js/loader/sea.js" }
{head}
    <meta charset="utf-8"/>
    <meta name="author" content="m.mofang.com">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    {* phone numer select *}
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    {* <link rel="apple-touch-icon-precomposed" href="./build/img/icon.png" /> *}

    <title>{block name=title}{strip}
        {$title}
    {/strip}{/block}</title>

    <meta name="keywords" content="{block name=keywords}{strip}
        {$keywords}
    {/strip}{/block}">

    <meta name="description" content="{block name=description}{strip}
        {$description}
    {/strip}{/block}">

    {* <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> *}
    <link rel="shortcut icon" href="http://pic1.mofang.com/2015/0728/20150728113409872.ico" type="image/x-icon" />
    {* 加加内页接口 *}
    {include file='common/p/jiajia_api.tpl'}

     {block name="seajs"}
        {if $MFE_USE_COMBO}
            {if $MFE_DEBUG}
                {require name='common:statics/js/loader/sea.js'}
                {require name='common:statics/js/loader/sea/combo.js'}
            {else}
                {require name='common:statics/js/loader/boot.js'}
            {/if}
        {else}
            {require name='common:statics/js/loader/sea.js'}
        {/if}
        {require name='modules:statics/js/sea-config.js'}
        {require name='common:statics/js/base-config.js'}
    {/block}


    {require name="common:statics/css/m_normalize.css"}

    {block name=head}

    {/block}

{/head}

{body}

    {block name=body}

    {/block}

    {block name=footer}

    {/block}

{/body}
{/html}
