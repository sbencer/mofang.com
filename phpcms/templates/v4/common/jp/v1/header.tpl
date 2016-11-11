<div class="hw-header">
	<div class="header-wrap w1000 clearfix">
		<div class="header-left fl">
			<div class="hw-mf-logo fl">
				<a href="http://www.mofang.com.tw">
					<img src="/statics/v4/common/img/jp/v1/logo_jp.png" alt="魔方網">
				</a>
			</div>
			<div class="fl nav-lanmu">
				<a href="http://www.mofang.com.tw/News/10000050-1.html" class="news" target="_blank">
					<img src="/statics/v4/common/img/jp/v1/nav_01.png" alt="ニュース">
					ニュース
				</a>
				<a href="http://fahao.mofang.com.tw" class="xubao" target="_blank">
					<img src="/statics/v4/common/img/jp/v1/nav_02.png" alt="ギフト">
					ギフト
				</a>
				<a href="http://game.mofang.com.tw" class="chanpin" target="_blank">
					<img src="/statics/v4/common/img/jp/v1/nav_03.png" alt="ゲーム">
					ゲーム
				</a>
				<a href="http://bbs.mofang.com.tw" class="luntan" target="_blank">
					<img src="/statics/v4/common/img/jp/v1/nav_04.png" alt="フォーラム">
					フォーラム 
				</a>
				<a href="http://www.mofang.com.tw/Videos/10000058-1.html" class="shipin" target="_blank">
					<img src="/statics/v4/common/img/jp/v1/nav_05.png" alt="ムービー">
					ムービー
				</a>
				<a href="http://www.mofang.com.tw/Zones/10000070-1.html" class="zhuanqu" target="_blank">
					<img src="/statics/v4/common/img/jp/v1/nav_06.png" alt="ゾーン">
					ゾーン
				</a>
			</div>
		</div>
		<div class="header-right fr">
			<div class="hw-login clearfix">
				<div class="hw-login-user fr" id="header-user-login">
					<div class="hw-login-no" id="header-user-nologin">
						<a href="#" class="mf-login" id="login">アカウント作成</a>
						<a href="#" class="mf-register" id="reg">ログオフ</a>
					</div>
					<div class="hw-login-had  disno" id="header-user-info">
						<a href="http://u.mofang.com.tw" id="logined" target="_blank"></a>
						<a href="http://u.mofang.com.tw/account/logout" id="logout">退出</a>
					</div>
				</div>
				<div id="fb-root"></div>
				{*<div class="mf-global clearfix">
					<span class="fl">魔方全球：</span>
					<div class="mf-list j_mf_list">
						<a href="http://www.mofang.com.tw" class="mf-tw">繁中</a>
						<div class="mf-list-con j_mf_con">
							<a href="http://www.mofang.jp" target="_blank" class="mf-jp">日本</a>
							<a href="http://www.appmofang.com" target="_blank" class="mf-usa">歐美</a>
						</div>
					</div>
				</div>*}
				 <div class="third-login-wrap">
					<a href="http://u.mofang.com.tw/account/facebook" class="fb-login login-comm">
						<img src="/statics/v4/common/img/hw/v1/fb.png" alt="">
					</a>
					<a href="http://u.mofang.com.tw/account/google" class="google-login login-comm">
						<img src="/statics/v4/common/img/hw/v1/gg.png" alt="">
					</a>
					<a href="http://u.mofang.com.tw/account/twitter" class="tw-login login-comm">
						<img src="/statics/v4/common/img/hw/v1/tt.png" alt="">
					</a>
				</div> 
			</div>
			<div class="hw-search clearfix">
				<!-- <div class="hot-word fl">
					<a href="#">仙境幻想</a>
					<a href="#">仙境幻想</a>
					<a href="#">仙境幻想</a>
					<a href="#">仙境幻想</a>
				</div> -->
				<div class="search-wrap fr">
					<form method="get" action="http://{$smarty.server.SERVER_NAME}/index.php" target="_blank">
						<input type="hidden" name="m" value="search">
						<input type="text" class="search-input" name="q" placeholder="ゲーム探す　攻略探す" onkeydown="if(event.keyCode==13){ search.click() }">
						<input type="submit" class="search-btn" id="search" value="">
					</form>
				</div>		
			</div>		
		</div>
	</div>
</div>
{* search *}

{* {require name="hw_mfang:statics/js/search.js"} *}
{require name="common:statics/css/jp/v1/header.css"}
{require name="common:statics/js/hw_common.js"}
{require name="common:statics/js/hw/login_tip.js"}
{script}
	{* seajs.use(['hw/search'],function(search){
			search({
				href:"http:///",
				ele:"#search",
				style:"all",
				skipFlag:true
			})
	}) *}
{/script}
