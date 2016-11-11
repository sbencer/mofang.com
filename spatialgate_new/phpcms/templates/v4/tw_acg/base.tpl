{*

    * -->> common/base.tpl
    **************************************************
    *  h5 Game 独立模板
    **************************************************
    *
    *  main              : 主体区域
    *  header            : 页面头部
    *  footer            : 页面底部
    *  sidebar           : 页面侧边栏
    *  tongji            : 统计代码
    *
    ***************************************************
*}

{extends file='common/hw/base.tpl'}

{* 标题 *}
{block name=title}{strip}
    {if $SEO.title}
        {$SEO.title}
    {else}
        {$SEO.site_title}
    {/if}
{/strip}{/block}



{* 关键词 *}
{block name=keywords}{strip}
    {$SEO.keyword}
{/strip}{/block}

{* 页面描述 *}
{block name=description}{strip}
    {$SEO.description}
{/strip}{/block}

{* html body *}
{block name='body'}
	{require name="tw_acg:statics/css/common.css"}
    {require name="tw_acg:statics/js/common.js"}
    {literal}
    <!-- Google Tag Manager -->
    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-T2VNZ3"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-T2VNZ3');</script>
    <!-- End Google Tag Manager -->
    {/literal}

    {* 顶部工具条 *}
    {block name='header'}
        {include file="tw_acg/widget/header.tpl"} 
    {/block}



    {* 主体区域 *}
    <div class="acg-content">
    {pc M="content" action="lists" catid=34 order="listorder desc" num="1"}   
        {foreach $data as $val}
        <a href="{$val.url|default:'javascript:void(0);'}" class="screen-gg j_hw_bg" style="display:block;height:100%;background-image: url({$val.thumb|default:'http://pic1.mofang.com/2015/1117/20151117025247711.jpg'}); background-position: 50% 0%; background-repeat: no-repeat;padding-bottom:80px;">
            <span class="bg-close j_close_btn"></span>   
        </a>
        {/foreach}
    {/pc}
        <div class="container">
        {block name='main'}
    	
        {/block}
        </div>
    </div>
    {*瀑布流列表*}
    {block name='infinite_list'}

    {/block}
    {* 友情链接 *}
    {block name='t_link'}

    {/block}

    {* 页面底部、版权信息等*}
    {block name='footer'}
        {include file="tw_acg/widget/footer.tpl"} 
    {/block}
    
    {* 返回顶部 *}
    {block name='go_back'}

    {/block}

    {* 弹出层 *}
    {block name='pop_box'}

    {/block}

    {* 主站整站百度统计 *}
    {block name='acg_tj'}
        {literal}
        <script>
          var _hmt = _hmt || [];
          (function() {
            var hm = document.createElement("script");
            hm.src = "//hm.baidu.com/hm.js?83386220411d1a3b5e72ae7907d4d49a";
            var s = document.getElementsByTagName("script")[0]; 
            s.parentNode.insertBefore(hm, s);
          })();
        </script>
        {/literal}
    {/block}


    
{/block}

