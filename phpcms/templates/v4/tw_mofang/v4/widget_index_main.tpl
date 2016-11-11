{require name="tw_mofang:statics/css/v4/widget_index_main.css"}
<div class="index-list clearfix">
    <div class="list-bag-arc fl">
        <div class="list-bag fl">
            <div class="list-bag-video">
                <h3 class="title">
                    <a href="http://www.mofang.com.tw/Videos/10000058-1.html" target="_blank" class="more">更多></a>
                    看三笑影音專區
                </h3>
                <ul class="list-video">
               	   {pc M=content action=lists catid=10000195 order='id desc' num=1}
                     {foreach $data as $val}
                        <li>
                            <a href="{$val.url}" target="_blank">
                                <img src="{$val.thumb}" alt="{$val.title}">
                                <p class="list-video-info ell">{$val.title}</p>
                            </a>
                        </li>
                    {/foreach}
                   {/pc}
		</ul>
            </div>
            <div class="list-bag-advance">
                <h3 class="title">
                    <a href="http://fahao.mofang.com.tw/" target="_blank" class="more">更多></a>
                    好康搶先拿
                </h3>
                <div class="list-package-wrap">
                  {pc M=content action=fahao order='id desc' num=2}
                        {foreach $data as $val}
                            <dl class="list-package">
                                <dt>
                                    <img src="{qiniuthumb($val.icon,80,80)}" alt="{$val.name}" class="game-radius">
                                </dt>
                                <dd class="list-package-title">{$val.name}</dd>
                                <dd class="list-package-btn">
                                    <a href="{$val.url}" target="_blank">領取</a>
                                </dd>
                            </dl>
                        {/foreach}
                  {/pc}

							</div>
                
            </div>
            <div class="list-bag-login">
                <h3 class="title">
                    <a href="http://www.mofang.com.tw/pregister/10000111-1.html" class="more" target="_blank">更多></a>
                    事前登入
                </h3>
		{pc M=content action=lists catid=10000111 order='id desc' num=2}
                    <div class="list-package-wrap">
                        {foreach $data as $val}
                            <dl class="list-package">
                                <dt>
                                    <img src="{$val.thumb}" alt="{$val.title}">
                                </dt>
                                <dd class="list-package-title">{$val.title}</dd>
                                <dd class="list-package-btn">
                                    <a href="{$val.url}" target="_blank">參加</a>
                                </dd>
                            </dl>
                        {/foreach}
                    </div>
                {/pc}
            </div>
        </div>
        <div class="list-arc fr">
            <p class="arc-tab-btn clearfix">
                <span class="arc-btn-active">情報</span>
                <span>遊戲</span>
                <span>動漫</span>
                <span>趣味</span>
                <span>產業</span>
            </p>

	     <div class="arc-tab-wrap">
                <div class="arc-tab-con">
                <!-- 情報  -->
                    {pc M=content action=lists catid=10000056 order='id desc' num=5}
                    {foreach $data as $val}
                    <dl>
                        <dt class="arc-tab-img">
                            <a href="{get_tag_url($val.tag)}" target="_blank" class="tag tag-qingbao">{get_tag($val.tag)}</a>
                            <a href="{$val.url}" target="_blank">
                                <img src="{$val.thumb}" alt="{$val.title}">
                            </a>
                        </dt>
                        <a href="{$val.url}" target="_blank">
	                        <dd class="arc-tab-title">
	                            {$val.title}
	                        </dd>
	                        <dd class="arc-tab-time">更新 : {$val.inputtime|date_format:"%Y.%m.%d %H:%M"}</dd>
	                        <dd class="arc-tab-info">{$val.description}</dd>
                        </a>
                    </dl>
                    {/foreach}
                    {/pc}
                    <p class="list-more">
                        <a href="http://www.mofang.com.tw/NGnews/10000056-1.html" target="_blank">更多新闻</a>
                    </p>
                    
                </div>
                <div class="arc-tab-con" style="display: none;">
                <!-- 遊戲  -->
                    {pc M=content action=lists catid=10000051 order='id desc' num=5}
                    {foreach $data as $val}
                    <dl>
                        <dt class="arc-tab-img">
                            <a href="{get_tag_url($val.tag)}" target="_blank" class="tag tag-youxi">{get_tag($val.tag)}</a>
                            <a href="{$val.url}" target="_blank">
                                <img src="{$val.thumb}" alt="{$val.title}">
                            </a>
                        </dt>
                        <a href="{$val.url}" target="_blank">
                        <dd class="arc-tab-title">
                            {$val.title}
                        </dd>
                         <dd class="arc-tab-time">更新 : {$val.inputtime|date_format:"%Y.%m.%d %H:%M"}</dd>
	                        <dd class="arc-tab-info">{$val.description}</dd>
                        </a>
                    </dl>
                    {/foreach}
                    {/pc}
                    <p class="list-more">
                        <a href="http://www.mofang.com.tw/EUnews/10000051-1.html" target="_blank">更多新闻</a>
                    </p>
                </div>
                <div class="arc-tab-con" style="display: none;">
                	<!-- 動漫  -->
                    {pc M=content action=lists catid=10000142 order='inputtime desc' num=5}
                    {foreach $data as $val}
                    <dl>
                        <dt class="arc-tab-img">
                            <a href="{get_tag_url($val.tag)}" target="_blank" class="tag tag-dongman">{get_tag($val.tag)}</a>
                            <a href="{$val.url}" target="_blank">
                                <img src="{$val.thumb}" alt="{$val.title}">
                            </a>
                        </dt>
                        <a href="{$val.url}" target="_blank">
	                        <dd class="arc-tab-title">
	                            {$val.title}
	                        </dd>
                        	<dd class="arc-tab-time">更新 : {$val.inputtime|date_format:"%Y.%m.%d %H:%M"}</dd>
	                        <dd class="arc-tab-info">{$val.description}</dd>
                        </a>
                    </dl>
                    {/foreach}
                    {/pc}
                    <p class="list-more">
                        <a href="http://www.mofang.com.tw/ACG/10000142-1.html" target="_blank">更多新闻</a>
                    </p>
                </div>
                <div class="arc-tab-con" style="display: none;">
                	<!-- 趣味  -->
                    {pc M=content action=lists catid=10000053 order='id desc' num=5}
                    {foreach $data as $val}
                    <dl>
                        <dt class="arc-tab-img">
                            <a href="{get_tag_url($val.tag)}" target="_blank" class="tag tag-quwei">{get_tag($val.tag)}</a>
                            <a href="{$val.url}" target="_blank">
                                <img src="{$val.thumb}" alt="{$val.title}">
                            </a>
                        </dt>
                        <a href="{$val.url}" target="_blank">
	                        <dd class="arc-tab-title">
	                            {$val.title}
	                        </dd>
	                        <dd class="arc-tab-time">更新 : {$val.inputtime|date_format:"%Y.%m.%d %H:%M"}</dd>
	                        <dd class="arc-tab-info">{$val.description}</dd>
                        </a>
                    </dl>
                    {/foreach}
                    {/pc}
                    <p class="list-more">
                        <a href="http://www.mofang.com.tw/funnews/10000053-1.html" target="_blank">更多新闻</a>
                    </p>
                </div>
                <div class="arc-tab-con" style="display: none;">
                <!-- 產業  -->
                    {pc M=content action=lists catid=10000054 order='id desc' num=5}
                    {foreach $data as $val}
                    <dl>
                        <dt class="arc-tab-img">
                            <a href="{get_tag_url($val.tag)}" target="_blank" class="tag tag-chanye">{get_tag($val.tag)}</a>
                            <a href="{$val.url}" target="_blank">
                                <img src="{$val.thumb}" alt="">
                            </a>
                        </dt>
                        <a href="{$val.url}" target="_blank">
	                        <dd class="arc-tab-title">
	                            {$val.title}
	                        </dd>
	                        <dd class="arc-tab-time">更新 : {$val.inputtime|date_format:"%Y.%m.%d %H:%M"}</dd>
	                        <dd class="arc-tab-info">{$val.description}</dd>
                        </a>
                    </dl>
                    {/foreach}
                    {/pc}
                    <p class="list-more">
                        <a href="http://www.mofang.com.tw/INnews/10000054-1.html" target="_blank">更多新闻</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="list-live-raider fr">
        {include file="tw_mofang/v4/widget_index_live.tpl"}
        <div class="list-raider">
            <h3 class="title">魔方遊戲攻略專區</h3>
            {pc M="content" action="lists" catid="10000070" order="id desc" num="10"}
            <div class="raider-game-wrap">
                <ul class="raider-game clearfix">
                    {foreach $data as $val}
                    <li>
                        <a href="{$val.url}" target="_blank">
                            <img src="{qiniuthumb($val.thumb,80,80)}" alt="{$val.title}" class="game-radius">
                            <span class="raider-game-title ell">{$val.title}</span>
                        </a>
                    </li>
                    {/foreach}
                </ul>
                <a href="http://www.mofang.com.tw/Zones/10000070-1.html" class="more" target="_blank">更多></a>
            </div>
            {/pc}
        </div>
    </div>
</div>
<div class="index-extend clearfix">
    <div class="extend-game-arc fl">
        <div class="extend-game fl">
            <h3 class="title">最新上市遊戲</h3>
            <div class="extend-game-tab">
                <p class="game-tab-btn clearfix">
                    <span class="game-active">iOS</span>
                    <span>Android</span>
                </p>
	          <div class="game-con-wrap">
                    {pc M=content action=get_top_ios }
                    <ul class="game-tab-con clearfix">
                        {foreach $data as $val}
                            <li>
                                <a href="{$val.url}" target="_blank">
                                    <img src="{$val.img_url}" title="{$val.img_alt}" class="game-radius">
                                    <span class="game-title ell">{$val.img_alt}</span>
                                </a>
                            </li>
                        {/foreach}
                    </ul>    
                    {/pc}
										{pc M=content action=get_top_andriod }
                    <ul class="game-tab-con" style="display: none;">
                        
                         {foreach $data as $val}
                            <li>
                                <a href="{$val.url}" target="_blank">
                                    <img src="{$val.img_url}" title="{$val.img_alt}" class="game-radius">
                                    <span class="game-title ell">{$val.img_alt}</span>
                                </a>
                            </li>
                        {/foreach}

                    </ul>
                    {/pc}
		</div>
            </div>
        </div>
        <div class="extend-arc fr">
            <div class="pingce-arc">
              <h3 class="title">
                    <a href="http://www.mofang.com.tw/recogame/10000280-1.html" target="_blank" class="more">更多></a>
                    評測文章
                </h3>
                <div class="pingce-list clearfix">
                    {pc M=content action=lists catid=10000280 order='listorder asc, id desc' num=2}
                    	 {foreach $data as $val}
                        <dl>
                            <dt>
                                <a href="{$val.url}" target="_blank">
                                    <img src="{$val.thumb}" alt="{$val.title}">
                                      
                                </a>
                            </dt>
                            <dd class="pingce-list-title">
                                <a href="{$val.url}" target="_blank">
                                    {$val.title}
                                </a>
                            </dd>
                            <dd class="pingce-list-author pingce-list-desc">作者：{$val.outhorname}</dd>
                            <dd class="pingce-list-info pingce-list-desc">{$val.desc}</dd>
                        </dl>
                    {/foreach}
                </div>

            </div>
            <div class="pingce-video">
								<h3 class="title">
                    <a href="http://www.mofang.com.tw/BEST/10000059-1.html" target="_blank" class="more">更多></a>
                    影音評測
                </h3>
                <div class="pingce-list clearfix">
                   {pc M=content action=lists catid=10000059 order='listorder asc, id desc' num=2}
                    	{foreach $data as $val}
                        <dl>
                            <dt>
                                <a href="{$val.url}" target="_blank">
                                    <img src="{$val.thumb}" alt="{$val.title}">
                                </a>
                            </dt>
                            <dd class="pingce-list-title">
                                <a href="{$val.url}" target="_blank">
                                    {$val.title}
                                </a>
                            </dd>
                            <dd class="pingce-list-info">{$val.desc}</dd>
                        </dl>
                      {/foreach}
                   {/pc}
                </div>
            </div>
        </div>
    </div>

    <div class="extend-brand fr">
        <h3 class="title">品牌館</h3>
        {pc M=content action=lists catid=10000254 order='listorder asc, id desc' num=7}
        <ul>    
            {foreach $data as $val}
            <li>
                <a href="{$val['url']}" target="_blank">
                    <img src="{$val.thumb}" alt="{$val['title']}">
                </a>
            </li>
            {/foreach}
        </ul>
        {/pc}
    </div>
</div>
