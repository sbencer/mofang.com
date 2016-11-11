<div class="login-notice w680 mb10">
	<div class="login-notice-con">
        <div class="login-notice-title">
            <a href="{cat_url(10000111)}" class="fr" target="_blank">看更多 <em>&gt;</em></a>
		    <h3>大家都在關注的事前登錄</h3>
        </div>
		<div class="login-notice-list">
		{pc M=content action=lists catid=10000111 num=3 order='RAND()' type=coupon}
			<ul>
				{foreach $data as $val}
				{if $val@iteration == 2}
				<li class="grey-2">
					<a href="{$val.url}" target="_blank">{$val.title}</a>
				</li>
				{else}
				<li class="grey-1">
					<a href="{$val.url}" target="_blank">{$val.title}</a>
				</li>
				{/if}
				{/foreach}
			</ul>
		{/pc}
		</div>
	</div>
</div>
{require name="tw_mofang:statics/css/bef_login/login_notice.css"}

