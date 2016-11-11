<div class="hw-header">
	<div class="header-wrap w1000 clearfix">
		<div class="header-left fl">
			<div class="hw-mf-logo fl">
				<a href="http://www.mofang.com.tw">
					<img src="/statics/v4/common/img/hw/v1/log_tw.png" alt="">
				</a>
			</div>
			<div class="hw-search fl">
				<div class="search-wrap fl">
					<form method="get" action="http://{$smarty.server.SERVER_NAME}/index.php" target="_blank">
						<input type="hidden" name="m" value="search">
						<input type="text" class="search-input" name="q" placeholder="找遊戲、新聞、攻略、產業資訊" onkeydown="if(event.keyCode==13){ search.click() }">
						<input type="submit" class="search-btn" id="search" value="">
					</form>
				</div>		
			</div>		
		</div>
		<div class="header-right fr">
			<div class="hw-login">
				<div class="hw-login-user fr" id="header-user-login">
					<div class="hw-login-no" id="header-user-nologin">
						<a href="javascript:;" class="mf-login" id="login">登入</a>
						<a href="javascript:;" class="mf-register" id="reg">註冊</a>
					</div>
					<div class="hw-login-had  disno" id="header-user-info">
						<a href="http://u.mofang.com.tw" id="logined" target="_blank"></a>
						<a href="http://u.mofang.com.tw/account/logout" id="logout">退出</a>
					</div>	
				</div>
				<div id="fb-root"></div>
				<div class="third-login-wrap">
					<a href="https://www.facebook.com/mofangTW" class="fb-login login-comm">
						<img src="/statics/v4/common/img/hw/v1/new_facebook_03.png" alt="">
					</a>
					<a href="https://www.youtube.com/user/MoFangTW" class="tw-login login-comm">
						<img src="/statics/v4/common/img/hw/v1/youtube_icon.jpg" alt="">
					</a>
					<a href="https://plus.google.com/+MofangTwgame/posts" class="google-login login-comm">
						<img src="/statics/v4/common/img/hw/v1/nav_adg_03.jpg" alt="">
					</a>
				</div>
			</div>
			<div class="mf-global clearfix">
				<span class="fl">分站導航：</span>
				<div class="mf-list j_mf_list">
					<a href="http://www.mofang.com.tw" class="mf-tw"><s class="tw-icon"></s>繁中</a>
					<div class="mf-list-con j_mf_con">
						<a href="http://www.mofang.com" target="_blank" class="mf-china"><s class="china-icon"></s>簡中</a>
						<a href="http://www.mofang.jp" target="_blank" class="mf-jp"><s class="jp-icon"></s>日文</a>
						<a href="http://www.appmofang.com" target="_blank" class="mf-usa"><s class="usa-icon"></s>英文</a>
						<a href="http://www.thaimofang.com" target="_blank" class="mf-china"><s class="tai-icon"></s>泰文</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="header-title J_navbar stuckMenu">
		<div class="title-wrap clearfix">
			<ul class="title-diff clearfix">
				<li>
					<a href="http://www.mofang.com.tw/News/10000050-1.html">遊戲新聞</a>
				</li>
				<li>
					<a href="http://www.mofang.com.tw/INnews/10000054-1.html">產業</a>
				</li>
				<li>
					<a href="http://www.mofang.com.tw/Zones/10000070-1.html">攻略專區</a>
				</li>
				<li>
					<a href="http://www.mofang.com.tw/girlplus/10000222-1.html">女性向專區</a>
				</li>
				<li>
					<a href="http://fahao.mofang.com.tw/">虛寶專區</a>
				</li>
				<li>
					<a href="http://www.mofang.com.tw/Videos/10000058-1.html">影音</a>
				</li>
				<li>
					<a href="http://www.spatialgate.com.tw/">次元角落</a>
				</li>
				<li>
					<a href="http://h5game.mofang.com.tw/">H5遊戲</a>
				</li>
				<li>
					<a href="http://newbbs.mofang.com.tw/">論壇</a>
				</li>
				<li>
					<a href="http://mission.mofang.com.tw/">魔務團</a>
				</li>
			</ul>
		</div>
	</div>
</div>
{* search *}

{* 
   {
	require name="hw_mfang:statics/js/search.js"
   } 
*}

{require name="common:statics/css/hw/v1/floatLayer.css"}
{require name="common:statics/css/hw/v3/header.css"}
{require name="common:statics/js/hw_common.js"}
{require name="common:statics/js/hw/login_tip.js"}
{require name="common:statics/js/header/stickmenu.js"}
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
