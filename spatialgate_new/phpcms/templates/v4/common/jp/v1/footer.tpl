<div class="hw-footer">
	<div class="footer-wrap w1000 clearfix">
		<div class="friend-link-wrap">
			<span class="link-tit">リンク：</span>
			<div class="friend-link">
			{pc M=link action=type_list typeid=155 order='listorder DESC'}
				{foreach $data as $val}
				<a href="{$val.url}" target="_blank">{$val.name}</a>
				{/foreach}
			{/pc}
			</div>
		</div>
		<div class="about-us">
			<a href="http://www.mofang.com.tw/about/index.php" target="_blank">会社概要</a>
			<a href="http://www.104.com.tw/jobbank/custjob/index.php?r=cust&j=403a426b34363e6730323a63383e3619729292925415c546785j48&jobsource=n104bank1" target="_blank">採用情報</a>
			<a href="mailto:service@mofang.com.tw" target="_blank">業務連絡</a>
			<a href="http://bbs.mofang.com.tw/forum-324-1.html" target="_blank">編集者連絡</a>
		</div>
		<div class="mf-adress">
			魔方數位資訊服務有限公司 版權所有 © 2015 Mofang Inc All Rights Reserved.
		</div>
	</div>
	
</div>
{require name="common:statics/css/hw/v1/footer.css"}
