{*

    *************************
    *  h5 css3 base定义
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
{html class="no-js" mode=NOSCRIPT framework="common:statics/js/loader/sea.js"}
{head}
    <meta charset="utf-8"/>
    <title>{block name=title}{strip}
        {$title}
    {/strip}{/block}</title>
    <meta name="keywords" content="{block name=keywords}{strip}
        {$keywords}
    {/strip}{/block}">
    <meta name="description" content="{block name=description}{strip}
        {$description}
    {/strip}{/block}">
    <meta name="author" content="app.mofang.com">
    <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1" />
    <meta name="apple-mobile-web-app-capable" content="no" />
    <meta name="viewport" content = "width = 1024, user-scalable = no">
    {* <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> *}
    <link rel="shortcut icon" href="http://pic1.mofang.com/2015/0728/20150728113409872.ico" type="image/x-icon" />

    {require name="common:statics/css/m_normalize.css"}

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
