{*
    * -->> base/doctype.tpl
    *************************
    *  base基类模板
    *************************
    *
    *  无新的内容块定义,倒入seajs
    *  和config文件
    *
    *************************
*}

{extends file='common/hw/doctype.tpl'}

{block name=head}

    {$smarty.block.parent}
    {if $smarty.const.MFE_USE_COMBO}
        {require name='common:statics/js/loader/boot.js'}
    {else}
        {require name='common:statics/js/loader/sea.js'}
    {/if}

    {require name='modules:statics/js/sea-config.js'}
    {require name='common:statics/js/base-config.js'}
{/block}

{block name=body}

    {*如果本地测试环境，则显示向上按钮*}
    {if $smarty.const.MFE_GO_HOME}
        <style type="text/css" media="screen">
            .debug_options{
                position:fixed;
                border:solid 1px #ccc;
		background:#fff;
                padding:2px 10px;
                border-radius: 4px;
		display:none;
            }
        </style>

        <div class="debug_options">
            <a href="/?tpl={$up}">向上</a>
        </div>

        <script>
            seajs.use(['jquery/ui'],function($){
                var opt = $('.debug_options').draggable();
                opt.css({
                    left:$(window).innerWidth() - 80,
                    top:$(window).innerHeight() - 60
                });
                opt.show();
            });
        </script>
    {/if}
{/block}
