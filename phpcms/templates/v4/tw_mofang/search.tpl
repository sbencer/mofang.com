{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_mofang/hw_base_det.tpl'}

{* 主体区域 *}
{block name="main-content"}
{require name="tw_mofang:statics/css/search/search.css"}
<div class="hw-main-content j_left">
    <div class="article-list-con mb20 clearfix">
        <div class="hw-con-left">
            <script>
                (function() {
                    var cx = '010015078464101292734:duzduvqb6ek';
                    var gcse = document.createElement('script');
                    gcse.type = 'text/javascript';
                    gcse.async = true;
                    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
                        '//www.google.com/cse/cse.js?cx=' + cx;
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(gcse, s);
                })();
            </script>
            <gcse:search></gcse:search>
        </div>
        <div class="hw-con-right ">
            {*魔方游戏*}
            {include file="tw_mofang/widget/article/mf_game.tpl"}
            {* 禮包 *}
            {include file="tw_mofang/widget/article/mf_prize.tpl"}
            {*最新视频 *}
            {include file="tw_mofang/widget/article/last_video.tpl"}
        </div>
    </div>
</div>
{/block}

