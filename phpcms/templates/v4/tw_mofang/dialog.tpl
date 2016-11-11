<div class="article-dialog-wrap j_dialog" >
    <div class="article-dialog-hd">
        <span class="j_close dialog-close-btn fr"></span>
        <h3>人客 ~ 先看這些熱門文章再走嘛</h3>
    </div>
    <div class="article-dialog-bd clearfix">
        <div class="article-dialog-left">
        {pc M=content action=lists catid=$catid order='id desc' num=3}
        {$big_news[] = array_shift($data)}
            {foreach $big_news as $val}
            <div class="dialog-tuijian">
                <a href="{$val.url}" class="imgarea" title="{$val.title}">
                    <img src="{$val.thumb}" alt="{$val.title}">
                    <span class="tuijian-tg"></span>
                    <p>{$val.title}</p>
                </a>
                <a href="http://www.mofang.com.tw/News/10000050-1.html" class="d-look-more">看更多<b>></b></a>
            </div>
            {/foreach}
            <div class="dialog-hot-wrap">
                <div class="dialog-hot">
                    {foreach $data as $val}
                    <a href="{$val.url}" title="{$val.title}">
                        <img src="{$val.thumb}" alt="{$val.title}">
                        <span class="hot-tg"></span>
                        <p>{$val.title}</p>
                    </a>
                    {/foreach}
                </div>
            </div>
        {/pc}
        </div>
        <div class="article-dialog-right">
            <div class="fb-wraps mb10">
                <h3 class="fb-hd">Facebook上等你來找</h3>
                <iframe src="https://www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/mofangTW&show_faces=false&show_border=false&stream=false&header=false&appId=853338341365826" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:75px;" allowtransparency="true"></iframe>
            </div>
            <div class="dialog-right-img-wrap">
                <div class="dialog-right-img1 mb10">
                {*  {pc M=content action=lists catid=$catid order='id desc' num=1}
                    {foreach $data as $val}
                    <a href="{$val.url}" title="{$val.title}"><img src="{$val.thumb}"></a>
                    {/foreach}
                {/pc}*}
                    <a href="http://www.youtube.com/user/MoFangTW" title="よ盡跋硈挡"><img src="/statics/v4/tw_mofang/img/b_right.jpg"></a>
                </div>
                <div class="dialog-right-img2 mb10">
                {pc M=content action=lists catid=10000098 order='id desc' num=1}
                    {foreach $data as $val}
                    <a href="{$val.url}" title="{$val.title}"><img src="{$val.thumb}"></a>
                    {/foreach}
                {/pc}
                </div>
                <div class="dialog-right-img2">
                {pc M=content action=lists catid=10000099 order='id desc' num=1}
                    {foreach $data as $val}
                    <a href="{$val.url}" title="{$val.title}"><img src="{$val.thumb}"></a>
                    {/foreach}
                {/pc}
                </div>
            </div>
            
        </div>
    </div>
</div>
