<div class="hw-header">
	<div class="header-wrap w1200 clearfix">
		<div class="hw-mf-logo fl">
			<a href="http://www.mofang.com.tw" class="logo fl">
				<img src="/statics/v4/common/img/tw/v4/logo.png" alt="">
			</a>
			<img src="/statics/v4/common/img/tw/v4/slogan.png" alt="" class="slogan fl">
		</div>
		<div class="header-right fr">
			<div class="hw-login clearfix">
				<div class="hw-login-user fr" id="header-user-login">
					<div class="hw-login-no" id="header-user-nologin">
						<a href="javascript:;" class="mf-login" id="login">登入</a>
						<a href="javascript:;" class="mf-register" id="reg">註冊</a>
					</div>	
				</div>
				{* <div id="fb-root"></div> *}
				<div class="hw-login-flobal fl">
					<div class="third-login-wrap fl">
						<a href="https://www.facebook.com/mofangTW" class="fb-login login-comm">
							<img src="/statics/v4/common/img/tw/v4/icon_fb.png" alt="">
						</a>
						<a href="https://twitter.com/mofangjp" class="google-login login-comm">
							<img src="/statics/v4/common/img/tw/v4/icon_ytb.png" alt="">
						</a>
						<a href="https://www.youtube.com/user/MoFangTW" class="tw-login login-comm">
							<img src="/statics/v4/common/img/tw/v4/icon_gg.png" alt="">
						</a>
					</div>
					<div class="mf-global fl">
						<span class="fl">站台</span>
						<div class="mf-list j_mf_list">
							<a href="http://www.mofang.com.tw" class="mf-tw">繁體中文</a>
							<div class="mf-list-con j_mf_con">
								<a href="http://www.appmofang.com" target="_blank" class="mf-usa">English</a>
								<a href="http://www.mofang.com" target="_blank" class="mf-china">简体中文</a>
								<a href="http://www.thaimofang.com" target="_blank" class="mf-china"></s>ภาษาไทย</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="hw-search">
				<div class="search-wrap">
					<form method="get" action="http://{$smarty.server.SERVER_NAME}/index.php" target="_blank">
						<input type="hidden" name="m" value="search">
						<input type="text" class="search-input" name="q" placeholder="找遊戲、新聞、攻略、產業資訊" onkeydown="if(event.keyCode==13){ search.click() }">
						<input type="submit" class="search-btn" id="search" value="">
					</form>
				</div>		
			</div>		
			
		</div>
	</div>
	

</div>
{* search *}

{* 
   {
	require name="hw_mfang:statics/js/search.js"
   } 
*}

{require name="common:statics/css/tw/v4/header.css"}
{require name="common:statics/css/tw/v4/floatLayer.css"}
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
