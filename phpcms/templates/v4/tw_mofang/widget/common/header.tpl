<div class="hw-header">
	<div class="header-wrap w1000x clearfix">
		<div class="header-left fl">
			<div class="hw-mf-logo fl">
				<a href="http://www.mofang.com.tw">
					<img src="/statics/v4/tw_mofang/img/log_tw.png" alt="">
				</a>
			</div>
			<div class="hw-search fl">
				<!-- <div class="hot-word fl">
					<a href="#">仙境幻想</a>
					<a href="#">仙境幻想</a>
					<a href="#">仙境幻想</a>
					<a href="#">仙境幻想</a>
				</div> -->
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
						<a href="#" class="mf-login" id="login">登入</a>
						<a href="#" class="mf-register" id="reg">註冊</a>
					</div>
					<div class="hw-login-had  disno" id="header-user-info">
						<a href="http://u.mofang.com.tw" id="logined" target="_blank"></a>
						<a href="http://u.mofang.com.tw/account/logout" id="logout">退出</a>
					</div>	
				</div>
				<div id="fb-root"></div>
				<div class="third-login-wrap">
					<a href="https://www.facebook.com/mofangTW" class="fb-login login-comm">
						<img src="/statics/v4/tw_mofang/img/new_facebook_03.png" alt="">
					</a>
					<a href="https://twitter.com/mofangjp" class="google-login login-comm">
						<img src="/statics/v4/tw_mofang/img/new_twitter_03.png" alt="">
					</a>
					<a href="https://www.youtube.com/user/MoFangTW" class="tw-login login-comm">
						<img src="/statics/v4/tw_mofang/img/youtube_03.png" alt="">
					</a>
				</div>
				
				{* <a href="http://u.mofang.jp/account/facebook" class="fb-login login-comm">
					<img src="/statics/v4/tw_mofang/img/fb.png" alt="">
				</a>
				<a href="http://u.mofang.jp/account/google" class="google-login login-comm">
					<img src="../../statics/img/gg.jpg" alt="">
				</a>
				<a href="http://u.mofang.jp/account/twitter" class="tw-login login-comm">
					<img src="../../statics/img/tw.jpg" alt="">
				</a> *}
			</div>
			<div class="mf-global clearfix">
				<span class="fl">分站導航：</span>
				<div class="mf-list j_mf_list">
					<a href="http://www.mofang.com.tw" class="mf-tw"><s class="tw-icon"></s>繁中</a>
					<div class="mf-list-con j_mf_con">
						<a href="http://www.mofang.jp" target="_blank" class="mf-jp"><s class="jp-icon"></s>日文</a>
						<a href="http://www.appmofang.com" target="_blank" class="mf-usa"><s class="usa-icon"></s>英文</a>
						<a href="http://www.mofang.com" target="_blank" class="mf-china"><s class="china-icon"></s>簡中</a>
						<a href="http://www.thaimofang.com" target="_blank" class="mf-china"><s class="tai-icon"></s>泰文</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="header-title">
		<div class="title-wrap w1000s clearfix">
			<ul class="title-diff clearfix">
				<li>
					<a href="javascript:;" class="one"><i class="new"></i>魔新聞<span></span><p>NEWS</p></a>
					<div class="dropdown" style="background:#b37ae3;">
						<a href="http://www.mofang.com.tw/EUnews/10000051-1.html" class="new">遊戲</a>
						<a href="http://www.mofang.com.tw/NGnews/10000056-1.html" class="new">情報</a>
						<a href="http://www.mofang.com.tw/INnews/10000054-1.html" class="new">產業</a>
						<a href="http://www.mofang.com.tw/funnews/10000053-1.html" class="new">趣味</a>
						<a href="http://www.mofang.com.tw/appnews/10000057-1.html" class="new">應用</a>
						<a href="http://www.mofang.com.tw/3C/10000052-1.html" class="new last">3C</a>
					</div>
				</li>
				<li>
					<a href="javascript:;" class="one"><i class="game"></i>魔遊戲<span></span><p>GAME</p></a>
					<div class="dropdown" style="background:#4fd3ce;">
						<a href="http://h5game.mofang.com.tw/" class="game">H5 GAME</a>
						<a href="http://www.mofang.com.tw/Zones/10000070-1.html" class="game">遊戲專區</a>
						<a href="http://bbs.mofang.com.tw/" class="game last">魔方論壇</a>
					</div>
				</li>
				<li>
					<a href="javascript:;" class="one"><i class="gift"></i>魔虛寶<span></span><p>GIFT</p></a>
					<div class="dropdown" style="background:#93c82a;">
						<a href="http://www.mofang.com.tw/pregister/10000111-1.html" class="gift">事前登錄</a>
						<a href="http://fahao.mofang.com.tw/" class="gift last">虛寶中心</a>
					</div>
				</li>
				<li>
					<a href="javascript:;" class="one"><i class="acg"></i>魔動漫<span></span><p>ACG</p></a>
					<div class="dropdown" style="background:#e6d90b;">
						<a href="http://www.spatialgate.com.tw" class="acg last">次元角落</a>
					</div>
				</li>
				<li>
					<a href="javascript:;" class="one"><i class="video"></i>魔影院<span></span><p>VIDEOS</p></a>
					<div class="dropdown" style="background:#fda92c;">
						<a href="http://www.mofang.com.tw/Videos/10000058-1.html" class="video last">魔方影音</a>
					</div>
				</li>
				<li style="margin-right:0">
					<a href="javascript:;" class="one coming_soon"><i class="team"></i>魔務團<p>MISSION</p></a>
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

{require name="tw_mofang:statics/css/header.css"}
{require name="common:statics/css/hw/v1/floatLayer.css"}
{require name="tw_mofang:statics/js/hw_common.js"}
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
