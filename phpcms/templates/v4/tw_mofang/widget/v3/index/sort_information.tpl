<div class="sort-content clearfix">
    <div class="con-left">
        <div class="sort-head">
            <ul class="clearfix">
                <li class="curr"><a href="{cat_url(10000056)}">情報</a></li>
                <li><a href="{cat_url(10000051)}">遊戲</a></li>
                <li><a href="{cat_url(10000222)}">女性向</a></li>
                <li><a href="{cat_url(10000050)}">綜合</a></li>
            </ul>
        </div>
        <div class="sort-main">
            {pc M="content" action="lists" catid="10000056" order="id desc" num="6"}
            <div class="sort-jump">
                <div class="sort-news">
                    {foreach $data as $val}
                        <dl>
                            <dd class="sort-con {if !$val@first}disno{/if}">
                                <a href="{$val.url}">
                                    <img src="{qiniuthumb($val.thumb,260,146)}" class="sort-img">
                                    <div class="title-con">
                                        <p>{$val.title}</p>
                                        <span>{$val.description}</span>
                                    </div>
                                </a>
                            </dd>
                            <a href="{$val.url}" class="turn-posi {if $val@first}disno{/if}">{str_cut($val.title, 57)}</a>
                        </dl>
                    {/foreach}
                </div>
                <a href="{cat_url(10000056)}" class="sort-more">更多 ></a>
            </div>
            {pc M="content" action="lists" catid="10000051" order="id desc" num="6"}
            <div class="sort-jump disno">
                <div class="sort-news">
                    {foreach $data as $val}
                        <dl>
                            <dd class="sort-con {if !$val@first}disno{/if}">
                                <a href="{$val.url}">
                                    <img src="{qiniuthumb($val.thumb,260,146)}" class="sort-img">
                                    <div class="title-con">
                                        <p>{$val.title}</p>
                                        <span>{$val.description}</span>
                                    </div>
                                </a>
                            </dd>
                            <a href="{$val.url}" class="turn-posi {if $val@first}disno{/if}">{str_cut($val.title, 57)}</a>
                        </dl>
                    {/foreach}
                </div>
                <a href="{cat_url(10000051)}" class="sort-more">更多 ></a>
            </div>
            {pc M="content" action="lists" catid="10000222" order="id desc" num="6"}
            <div class="sort-jump disno">
                <div class="sort-news">
                    {foreach $data as $val}
                        <dl>
                            <dd class="sort-con {if !$val@first}disno{/if}">
                                <a href="{$val.url}">
                                    <img src="{qiniuthumb($val.thumb,260,146)}" class="sort-img">
                                    <div class="title-con">
                                        <p>{$val.title}</p>
                                        <span>{$val.description}</span>
                                    </div>
                                </a>
                            </dd>
                            <a href="{$val.url}" class="turn-posi {if $val@first}disno{/if}">{str_cut($val.title, 57)}</a>
                        </dl>
                    {/foreach}
                </div>
                <a href="{cat_url(10000220)}" class="sort-more">更多 ></a>
            </div>
            {pc M="content" action="lists" catid="10000050" order="id desc" num="6"}
            <div class="sort-jump disno">
                <div class="sort-news">
                    {foreach $data as $val}
                        <dl>
                            <dd class="sort-con {if !$val@first}disno{/if}">
                                <a href="{$val.url}">
                                    <img src="{qiniuthumb($val.thumb,260,146)}" class="sort-img">
                                    <div class="title-con">
                                        <p>{$val.title}</p>
                                        <span>{$val.description}</span>
                                    </div>
                                </a>
                            </dd>
                            <a href="{$val.url}" class="turn-posi {if $val@first}disno{/if}">{str_cut($val.title, 57)}</a>
                        </dl>
                    {/foreach}
                </div>
                <a href="{cat_url(10000050)}" class="sort-more">更多 ></a>
            </div>
        </div>
    </div>
    <div class="con-right">
        <div class="sort-head">
            <ul class="clearfix">
                <li  class="curr"><a href="{cat_url(10000054)}">產業</a></li>
                <li><a href="{cat_url(10000052)}">3C</a></li>
                <li><a href="{cat_url(10000053)}">趣味</a></li>
                {*<li><a href="{cat_url(10000057)}">應用</a></li>*}
            </ul>
        </div>
        <div class="sort-main">
            {pc M="content" action="lists" catid="10000054" order="id desc" num="6"}
            <div class="sort-jump">
                <div class="sort-news">
                    {foreach $data as $val}
                        <dl>
                            <dd class="sort-con {if !$val@first}disno{/if}">
                                <a href="{$val.url}">
                                    <img src="{qiniuthumb($val.thumb,260,146)}" class="sort-img">
                                    <div class="title-con">
                                        <p>{$val.title}</p>
                                        <span>{$val.description}</span>
                                    </div>
                                </a>
                            </dd>
                            <a href="{$val.url}" class="turn-posi {if $val@first}disno{/if}">{str_cut($val.title, 57)}</a>
                        </dl>
                    {/foreach}
                </div>
                <a href="{cat_url(10000054)}" class="sort-more">更多 ></a>
            </div>
            {pc M="content" action="lists" catid="10000052" order="id desc" num="6"}
            <div class="sort-jump disno">
                 <div class="sort-news">
                    {foreach $data as $val}
                        <dl>
                            <dd class="sort-con {if !$val@first}disno{/if}">
                                <a href="{$val.url}">
                                    <img src="{qiniuthumb($val.thumb,260,146)}" class="sort-img">
                                    <div class="title-con">
                                        <p>{$val.title}</p>
                                        <span>{$val.description}</span>
                                    </div>
                                </a>
                            </dd>
                            <a href="{$val.url}" class="turn-posi {if $val@first}disno{/if}">{str_cut($val.title, 57)}</a>
                        </dl>
                    {/foreach}
                </div>
                <a href="{cat_url(10000053)}" class="sort-more">更多 ></a>
            </div>
            {pc M="content" action="lists" catid="10000053" order="id desc" num="6"}
            <div class="sort-jump disno">
                <div class="sort-news">
                    {foreach $data as $val}
                        <dl>
                            <dd class="sort-con {if !$val@first}disno{/if}">
                                <a href="{$val.url}">
                                    <img src="{qiniuthumb($val.thumb,260,146)}" class="sort-img">
                                    <div class="title-con">
                                        <p>{$val.title}</p>
                                        <span>{$val.description}</span>
                                    </div>
                                </a>
                            </dd>
                            <a href="{$val.url}" class="turn-posi {if $val@first}disno{/if}">{str_cut($val.title, 57)}</a>
                        </dl>
                    {/foreach}
                </div>
                <a href="{cat_url(10000057)}" class="sort-more">更多 ></a>
            </div>
            {*{pc M="content" action="lists" catid="10000057" order="id desc" num="6"}
            <div class="sort-jump disno">
                <div class="sort-news">
                    {foreach $data as $val}
                        <dl>
                            <dd class="sort-con {if !$val@first}disno{/if}">
                                <a href="{$val.url}">
                                    <img src="{qiniuthumb($val.thumb,260,146)}" class="sort-img">
                                    <div class="title-con">
                                        <p>{$val.title}</p>
                                        <span>{$val.description}</span>
                                    </div>
                                </a>
                            </dd>
                            <a href="{$val.url}" class="turn-posi {if $val@first}disno{/if}">{str_cut($val.title, 57)}</a>
                        </dl>
                    {/foreach}
                </div>
                <a href="{cat_url(10000052)}" class="sort-more">更多 ></a>
            </div>*}
        </div>
    </div>
</div>
{require name="tw_mofang:statics/css/v3/sort_information.css"}
