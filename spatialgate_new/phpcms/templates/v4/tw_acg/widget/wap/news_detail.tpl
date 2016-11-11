<div class="news_detail">
	<div class="news_detail_title">
        <h2>{$title}</h2>
        {$weekarray=array("日","一","二","三","四","五","六")}
        <p class="fl">{date("Y年m月d日", strtotime($inputtime))} 星期{$weekarray[date("w", strtotime($inputtime))]}</p><p class="fr">作者: {$authorname|default:$username}</p>
    </div>
    <div class="fl">
            <span class="inb">{get_views("c-{$modelid}-{$id}")}</span>
    </div>
    <div class="shares clearfix">
        <h2>分享到:</h2>
        <ul class="clearfix">
            <li>
                <a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));">
                    <img src="/statics/v4/tw_acg/wap/images/fb_02.png" />
                </a>
            </li>
            <li>
                <a href="https://twitter.com/intent/tweet?text={urlencode($title)}&url={urlencode($url)}">
                    <img src="/statics/v4/tw_acg/wap/images/tw_02.png" />
                </a>
            </li>
            <li>
                <a href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));">
                    <img src="/statics/v4/tw_acg/wap/images/go_02.png" />
                </a>
            </li>
            <li>
                <a href="http://line.me/R/msg/text/?{urlencode($title)}%0D%0A{urlencode($url)}">
                    <img src="/statics/v4/tw_acg/wap/images/li_02.png" />
                </a>
            </li>
            <li>
                <a href="javascript:void(window.open('http://www.plurk.com/m?qualifier=shares&content='.concat(encodeURIComponent(window.location.href)).concat(' ').concat('(').concat(encodeURIComponent(document.title)).concat(')')));">
                    <img src="/statics/v4/tw_acg/wap/images/po_02.png" />
                </a>
            </li>
        </ul>
    </div>
    <div class="fb-like" data-show-faces="false" data-width="450">&nbsp;</div>
    <div id="detailBox" class="news_detail_content">
    	{html5_convert($content)}
    </div>
    <div class="fb-like" data-show-faces="false" data-width="450">&nbsp;</div>
    <div class="share clearfix">
    	<h2>分享到:</h2>
        <ul class="clearfix">
        	<li>
                <a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));">
                    <img src="/statics/v4/tw_acg/wap/images/fb_01.png" />
                </a>
            </li>
            <li>
                <a href="https://twitter.com/intent/tweet?text={urlencode($title)}&url={urlencode($url)}">
                    <img src="/statics/v4/tw_acg/wap/images/tw_01.png" />
                </a>
            </li>
            <li>
                <a href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));">
                    <img src="/statics/v4/tw_acg/wap/images/go_01.png" />
                </a>
            </li>
            <li>
                <a href="http://line.me/R/msg/text/?{urlencode($title)}%0D%0A{urlencode($url)}">
                    <img src="/statics/v4/tw_acg/wap/images/li_01.png" />
                </a>
            </li>
            <li>
                <a href="javascript:void(window.open('http://www.plurk.com/m?qualifier=shares&content='.concat(encodeURIComponent(window.location.href)).concat(' ').concat('(').concat(encodeURIComponent(document.title)).concat(')')));">
                    <img src="/statics/v4/tw_acg/wap/images/pu_01.png" />
                </a>
            </li>
        </ul>
    </div>
</div>
{require name="tw_acg:statics/wap/css/news_detail.css"}
{require name="tw_acg:statics/wap/css/swipebox.css"}
{require name="tw_acg:statics/wap/js/swipebox.js"}