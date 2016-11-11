<div class="hw-header">
	<div class="header-wrap w1000 clearfix">
		<div class="header-left fl">
			<div class="hw-mf-logo fl">
				<a href="http://www.mofang.com.tw">
					<img src="http://sts0.mofang.com/statics/v4/hw_mfang/img/logo_en.png" alt="">
				</a>
			</div>
			<div class="fl nav-lanmu">
				<a href="http://www.mofang.com.tw/News/10000050-1.html" class="news" target="_blank">
					<img src="http://sts0.mofang.com/statics/v4/hw_mfang/img/new.png" alt="{t}News{/t}">
					{t}News{/t}
				</a>
				<a href="http://fahao.mofang.com.tw" class="xubao" target="_blank">
					<img src="http://sts0.mofang.com/statics/v4/hw_mfang/img/xubao.png" alt="{t}Gifts{/t}">
					{t}Gifts{/t}
				</a>
				<a href="http://game.mofang.com.tw" class="chanpin" target="_blank">
					<img src="http://sts0.mofang.com/statics/v4/hw_mfang/img/youxi.png" alt="{t}Games{/t}">
					{t}Games{/t}
				</a>
				<a href="http://bbs.mofang.com.tw" class="luntan" target="_blank">
					<img src="http://sts0.mofang.com/statics/v4/hw_mfang/img/luntan.png" alt="{t}Forums{/t}">
					{t}Forums{/t}
				</a>
				<a href="http://www.mofang.com.tw/Videos/10000058-1.html" class="shipin" target="_blank">
					<img src="http://sts0.mofang.com/statics/v4/hw_mfang/img/shipin.png" alt="{t}Videos{/t}">
					{t}Videos{/t}
				</a>
				<a href="http://www.mofang.com.tw/Zones/10000070-1.html" class="zhuanqu" target="_blank">
					<img src="http://sts0.mofang.com/statics/v4/hw_mfang/img/zhuanqu.png" alt="{t}Zone{/t}">
					{t}Zone{/t}
				</a>
			</div>
		</div>
		<div class="header-right fr">
			<div class="hw-login clearfix">
				<div class="hw-login-user fr" id="header-user-login">
					<div class="hw-login-no" id="header-user-nologin">
						<a href="#" class="mf-login" id="login">{t}Login{/t}</a>
						<a href="#" class="mf-register" id="reg">{t}Register{/t}</a>
					</div>
					<div class="hw-login-had  disno" id="header-user-info">
						<a href="http://u.mofang.com.tw" id="logined" target="_blank"></a>
						<a href="http://u.mofang.com.tw/account/logout" id="logout">退出</a>
					</div>
				</div>
				<div id="fb-root"></div>
				<div class="third-login-wrap">
					<a href="http://u.mofang.com.tw/account/facebook" class="fb-login login-comm">
						<img src="/statics/v4/common/img/hw/v1/fb.png" alt="">
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
						<input type="text" class="search-input" name="q" placeholder="" onkeydown="if(event.keyCode==13){ search.click() }">
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
