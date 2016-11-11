{*

    **************************************************
    *  V4主站二级底部信息
    *
    *
    **************************************************
*}

{require name="common:statics/css/sub-footer.css"}
<div class="show-footer">
    {if in_array($smarty.get.catid, array(121,471))}
    <div class="footer-inner footer-bottom" style="margin: 0 auto; width: 980px;">
        <div class="friendlink" style="padding: 10px 0 20px;">
            <span>友情链接：</span>
            {if $smarty.get.catid == 121}
                {pc M=link action=lists typeid=534 num=300}
                    {foreach from=$data item=val}
                        <a href="{$val.url}" target="_blank">{$val.name}</a>
                    {/foreach}
                {/pc}
            {elseif $smarty.get.catid == 471}
                {pc M=link action=lists typeid=535 num=300}
                    {foreach from=$data item=val}
                        <a href="{$val.url}" target="_blank">{$val.name}</a>
                    {/foreach}
                {/pc}
            {/if}
        </div>
    </div>
    {/if}
    <div class="footer-bd grid-970 clearfix">

        <div class="footer-bd-log">
            <img src="/statics/v4/common/img/sub_footer_logo.png" alt="魔方网">
        </div>
        <div class="footer-bd-copy">
            <ul class="clearfix">
                <li><a href="http://www.mofang.com/about/index" target="_blank">关于我们</a><b class="ui-line">|</b></li>
                <li><a href="http://www.mofang.com/about/join" target="_blank">诚聘英才</a><b class="ui-line">|</b></li>
                <li><a href="http://www.mofang.com/about/contact" target="_blank">联系我们</a><b class="ui-line">|</b></li>
                <li><a href="http://www.mofang.com/about/law" target="_blank">服务条款</a><b class="ui-line">|</b></li>
                <li><a href="http://www.mofang.com/about/protect" target="_blank">权利保护</a></li>
            </ul>
            <p>© 2015 魔方网 MOFANG.COM 皖B2-20150012-1</p>
        </div>
    </div>
</div>
<!-- ok -->
