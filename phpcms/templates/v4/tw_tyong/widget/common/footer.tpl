<div class="footer">
	<div class="foot_top">
		<ul>
			<li>
				<span class="fl" style="line-height:26px;">友情链接:</span>
				{foreach $link.links as $val}
				<a href="{$val.url}" target="_blank">{$val.title}</a>
				{/foreach}
			</li>
		</ul>
	</div>
	<div class="foot_bott">
		<p>魔方數位資訊服務有限公司 版權所有 @ 2015 Mofang Inc All Rights Reserved</p>
	</div>
</div>
{require name="tw_tyong:statics/css/common/footer.css"}