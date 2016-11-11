<div class="hw-header">
	<div class="header-wrap w1000 clearfix">
		<div class="header-left fl">
			<div class="hw-mf-logo fl">
				<a href="http://www.thaimofang.com">
					<img src="/statics/v4/common/img/thai/v1/tai.png" alt="魔方網">
				</a>
			</div>
			<div class="fl nav-lanmu">
				<a href="http://www.thaimofang.com/News/10000050-1.html" class="news" target="_blank">
					<img src="/statics/v4/common/img/thai/v1/nav_01.png" alt="新聞">
					NEWS
				</a>
				<a href="javascript:;" class="xubao no-href" target="_blank">
					<img src="/statics/v4/common/img/thai/v1/nav_02.png" alt="Gifts">
					Gifts
				</a>
				<a href="javascript:;" class="chanpin no-href" target="_blank">
					<img src="/statics/v4/common/img/thai/v1/nav_03.png" alt="Games">
					Games
				</a>
				<a href="javascript:;" class="luntan no-href" target="_blank">
					<img src="/statics/v4/common/img/thai/v1/nav_04.png" alt="Forums">
					Forums 
				</a>
				<a href="javascript:;" class="shipin no-href" target="_blank">
					<img src="/statics/v4/common/img/thai/v1/nav_05.png" alt="Videos">
					Videos
				</a>
				<a href="javascript:;" class="zhuanqu no-href" target="_blank">
					<img src="/statics/v4/common/img/thai/v1/nav_06.png" alt="Zone">
					Zone
				</a>
			</div>
		</div>
		<div class="header-right fr">
			<div class="hw-login clearfix">
            {*<div class="hw-login-user fr" id="header-user-login">
					<div class="hw-login-no" id="header-user-nologin">
						<a href="#" class="mf-login" id="login">Login</a>
						<a href="#" class="mf-register" id="reg">Register</a>
					</div>
					<div class="hw-login-had  disno" id="header-user-info">
						<a href="http://u.mofang.com.tw" id="logined" target="_blank"></a>
						<a href="http://u.mofang.com.tw/account/logout" id="logout">退出</a>
					</div>
				</div>*}
				<div id="fb-root"></div>
				<div class="mf-global clearfix">
					<span class="fl">ทั่วโลก</span>
					<div class="mf-list j_mf_list">
						<a href="http://www.thaimofang.com" target="_blank" class="mf-thai"><s class="tai-icon"></s>ภาษาไทย</a>
						<div class="mf-list-con j_mf_con">
							<a href="http://www.mofang.com.tw" class="mf-tw"><s class="tw-icon"></s>繁體中文</a>
							<a href="http://www.mofang.jp" target="_blank" class="mf-jp"><s class="jp-icon"></s>日本語</a>
							<a href="http://www.appmofang.com" target="_blank" class="mf-usa"><s class="usa-icon"></s>English</a>
							<a href="http://www.mofang.com" target="_blank" class="mf-china"><s class="china-icon"></s>简体中文</a>
						</div>
					</div>
				</div>
                {*<div class="third-login-wrap">
					<a href="http://u.mofang.com.tw/account/facebook" class="fb-login login-comm">
						<img src="/statics/v4/common/img/hw/v1/fb.png" alt="">
					</a>
					<a href="http://u.mofang.com.tw/account/google" class="google-login login-comm">
						<img src="/statics/v4/common/img/hw/v1/gg.png" alt="">
					</a>
					<a href="http://u.mofang.com.tw/account/twitter" class="tw-login login-comm">
						<img src="/statics/v4/common/img/hw/v1/tt.png" alt="">
					</a>
				</div>*} 
			</div>
			<div class="hw-search clearfix">
				<!-- <div class="hot-word fl">
					<a href="#">仙境幻想</a>
					<a href="#">仙境幻想</a>
					<a href="#">仙境幻想</a>
					<a href="#">仙境幻想</a>
				</div> -->
                {*<div class="search-wrap fr">
					<form method="get" action="http://{$smarty.server.SERVER_NAME}/index.php" target="_blank">
						<input type="hidden" name="m" value="search">
						<input type="text" class="search-input" name="q" placeholder="กรุณาใส่คำที่ต้องการค้นหา" onkeydown="if(event.keyCode==13){ search.click() }">
						<input type="submit" class="search-btn" id="search" value="">
					</form>*}
				</div>		
			</div>		
		</div>
	</div>
</div>
{* search *}

{* {require name="hw_mfang:statics/js/search.js"} *}
{require name="common:statics/css/thai/v1/header.css"}
{require name="common:statics/js/hw_common.js"}
{*require name="common:statics/js/hw/login_tip.js"*}
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
