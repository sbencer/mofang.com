<div class="footerBox">
	<div class="footer">
        {if $isHome}
        <div class="footer-con clearfix">
            <span>友情連結:</span>
            <ul>
            {pc M="link" action="type_list" typeid="73" order="listorder DESC"}
                {foreach $data as $val}
                <li><a href="{$val.url}" target="_blank">{$val.name}</a></li>
                {/foreach}
            {/pc}
            </ul>
        </div>
        {/if}
        <div class="footer-connect clearfix">
            <img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/img/footer_img_82d6333.png">
            <ul>
                <li><a href="mailto:acgmofang@mofang.com.tw">情報投稿</a></li>
                <li><a href="mailto:lenawu@mofang.com.tw"> 商務洽談</a></li>
                <li><a href="http://newbbs.mofang.com.tw/forum/6348.html">次元討論</a></li>
                <li><a href="http://www.mofang.com.tw/">魔方網</a></li>
                <li style="margin-right:-42px;"><a href="mailto:acgmofang@mofang.com.tw">聯絡我們</a></li>
                <li style="margin-left:63px;"><a href="https://www.facebook.com/mofangTW/?fref=ts">魔方粉絲團</a></li>
                <li><a href="http://www.mofang.com.tw/appdownload/277-123-1.html">GAME+</a></li>
                <li><a href="{$smarty.const.APP_PATH}?wap=1">ACG移動端</a></li>
            </ul>
        </div>
        <p>魔方數位資訊服務有限公司 版權所有 © 2015 Mofang Inc All Rights Reserved.</p>
        <p class="pd-bt">如有違反您的權益，或您發現有任何不當內容或圖片錯誤，請與我們聯繫。我們會第一時間修正更改。</p>
	</div>
</div>