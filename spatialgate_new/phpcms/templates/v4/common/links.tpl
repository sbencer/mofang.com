    <div id="footer" class="footer">
        <div class="footer-hd grid-970 ">
            <ul class="footer-hd-wrap clearfix">
                <li class="footer-hd-item">
                    <dl>
                        <dt>iPhone/iPad</dt>
                        <dd>
                            <ul>
                                {pc M=content action=lists catid=681 order='inputtime DESC'}
                                    {foreach from=$data item=val}
                                        <li><a href="{$val['url']}" target="_blank">{$val['title']}</a></li>
                                    {/foreach}
                                {/pc}
                            </ul>
                        </dd>
                    </dl>
                </li>
                <li class="footer-hd-item">
                    <dl>
                        <dt>Android</dt>
                        <dd>
                            <ul>
                                {pc M=content action=lists catid=682 order='inputtime DESC'}
                                    {foreach from=$data item=val}
                                        <li><a href="{$val['url']}" target="_blank">{$val['title']}</a></li>
                                    {/foreach}
                                {/pc}
                            </ul>
                        </dd>
                    </dl>
                </li>
                <li class="footer-hd-item">
                    <dl>
                        <dt>新游中心</dt>
                        <dd>
                            <ul>
                                {pc M=content action=lists catid=683 order='inputtime DESC'}
                                    {foreach from=$data item=val}
                                        <li><a href="{$val.url}" target="_blank">{$val['title']}</a></li>
                                    {/foreach}
                                {/pc}
                            </ul>
                        </dd>
                    </dl>
                </li>
                <li class="footer-hd-item">
                    <dl>
                        <dt>热门专区</dt>
                        <dd>
                            <ul>
                                {pc M=content action=lists catid=684 order='inputtime DESC'}
                                    {foreach from=$data item=val}
                                        <li><a href="{$val['url']}" target="_blank">{$val['title']}</a></li>
                                    {/foreach}
                                {/pc}
                            </ul>
                        </dd>
                    </dl>
                </li>
                <li class="footer-hd-item no-bd footer-hd-last">
                    <dl>
                        <dt>游戏论坛</dt>
                        <dd>
                            <ul>
                                {pc M=content action=lists catid=685 order='inputtime DESC'}
                                    {foreach from=$data item=val}
                                        <li><a href="{$val['url']}" target="_blank">{$val['title']}</a></li>
                                    {/foreach}
                                {/pc}
                            </ul>
                        </dd>
                    </dl>
                </li>
            </ul>
        </div>
        {pc M=link action=lists typeid=155 num=300}
            {if $data}
            <div class="footer-bd grid-970 clearfix footer-friend">
                <div class="footer-friend-hd">
                    友情链接
                </div>
                <div class="footer-bd-friend">
                    <ul class="clearfix">
                        {foreach from=$data item=v}
                            <li><a href="{$v['url']}" target="_blank">{$v['name']}</a></li>
                        {/foreach}
                        <!-- <a class="more-hezuo" href="#" target="_blank">更多&gt;&gt;</a> -->
                    </ul>
                </div>
            </div>
            {/if}
        {/pc}
        <div class="t-ft-inner clearfix">
        <div class="ft-logo">
            <a class="pngfix" href="http://www.mofang.com" target="_blank">魔方网</a>
        </div>
        <div class="ft-nav">
            <p>
                <a href="http://www.mofang.com/about/index" target="_blank">关于我们</a>|
                <a href="http://www.mofang.com/about/join" target="_blank">诚聘英才</a>|
                <a href="http://www.mofang.com/about/contact" target="_blank">联系我们</a>|
                <a href="http://www.mofang.com/about/law" target="_blank">服务条款</a>|
                <a href="http://www.mofang.com/about/protect" target="_blank">权利保护</a>
            </p>
            <p>&copy;2015 魔方网 MOFANG.COM 皖B2-20150012-1</p>
        </div>
        <div class="hs-r1 pngfix"></div>
    </div>
    </div>