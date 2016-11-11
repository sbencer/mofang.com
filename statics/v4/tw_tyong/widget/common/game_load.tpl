<div class="game-load w720 mb10 j_wrap">
	<div class="nav-common title1-bg">
		<ul class="nav-com-list w120 clearfix j_tab">
		{pc M=partition action=app_down_help partid=$partition_id apptype=down return=download}{/pc}
		{pc M=partition action=app_down_help partid=$partition_id apptype=help return=helps}{/pc}
			{if $download}
			<li class="bg-line curr">
				<a href="javascript:;">遊戲下載</a>
			</li>
			{/if}
			<li class="bg-line">
				<a href="javascript:;">GAME+下載</a>
			</li>
			{if $helps.name}
			<li>
				<a href="javascript:;">攻略助手下載</a>
			</li>
			{/if}
		</ul>
	</div>
	<div class="common-con game-con">
		<div class="game-load-con clearfix">
			{if $download}
			<div class="j_con">
				<div class="game-jia fl">
					<a href="#" class="fl img-area">
						<img src="{qiniuthumb($download.image)}" alt="{$download.name}">
					</a>
					<h3><a href="#">{$download.name}</a></h3>
					<p>{$download.desc}</p>
				</div>
				<div class="fl serice-all">
					{if $download.ios}
					<a href="{$download.ios}" class="ios" target="_blank">
						IOS下载
					</a>
					{/if}
					{if $download.android}
					<a href="{$download.android}" class="and" target="_blank">
						Android下载
					</a>
					{/if}
					{if $download.apk}
					<a href="{$download.apk}" class="apk">
						APK下载
					</a>
					{/if}
				</div>
				<div class="fl age-limit">
					<img src="{$download.qrcode}" alt="">
				</div>
			</div>
			{/if}

			<div class="j_con disno">
				<div class="game-jia fl">
					<a href="#" class="fl img-area">
						<img src="/statics/v4/tw_tyong/img/icon_zhou.jpg" alt="">
					</a>
					<h3><a href="#">GAME+下載</a></h3>
					<p>您的全能遊戲助手GAME+<br>官方粉絲團：<a href="https://www.facebook.com/pages/Game-%E5%8A%A0%E5%8A%A0/1385681488388904?fref=ts" target="_blank">點擊進入</a></p>
				</div>
				<div class="fl serice-all">
					<a href="https://itunes.apple.com/us/app/id953944373" class="ios" target="_blank">
						IOS下载
					</a>
					<a href="http://goo.gl/JVxV3l" class="and" target="_blank">
						Android下载
					</a>
					{*<a href="#" class="apk">
						APK下载
					</a>*}
				</div>
				<div class="fl age-limit">
					<img src="http://pic3.mofang.com/2014/1029/20141029020109670.png" alt="">
				</div>
			</div>

			{if $helps}
			<div class="j_con disno">
				<div class="game-jia fl">
					<a href="#" class="fl img-area">
						<img src="{qiniuthumb($helps.image)}" alt="{$helps.name}">
					</a>
					<h3><a href="#">{$helps.name}</a></h3>
					<p>{$helps.desc}</p>
				</div>
				<div class="fl serice-all">
					{if $helps.ios}
					<a href="{$helps.ios}" class="ios" target="_blank">
						IOS下载
					</a>
					{/if}
					{if $helps.android}
					<a href="{$helps.android}" class="and" target="_blank">
						Android下载
					</a>
					{/if}
					{if $helps.apk}
					<a href="{$helps.apk}" class="apk" target="_blank">
						APK下载
					</a>
					{/if}
				</div>
				<div class="fl age-limit">
					<img src="{$helps.qrcode}" alt="">
				</div>
			</div>
			{/if}
		</div>
	</div>
</div>
{require name="tw_tyong:statics/css/game_load.css"}
{require name="tw_tyong:statics/js/index.js"}
