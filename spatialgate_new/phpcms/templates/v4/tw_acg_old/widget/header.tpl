<div class="acg-headerbox">
	<div class="acg-header clearfix">
		<div class="header-wrap w1000 clearfix">
			<a href="{$smarty.const.APP_PATH}" class="acg-logo"></a>
			<div class="header-left">
				<a href="/"><img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/img/header_left_a9e7d13.png"></a>
			</div>
			<div class="header-right">
				<div class="right-share">
					<h3>分享到:</h3>
					<a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href))));" class="fb"></a>
					<a href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));" class="tw"></a>
					<a href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));" class="gp"></a>
					<a href="javascript: void(window.open('http://www.plurk.com/?qualifier=shares&status=' .concat(encodeURIComponent(location.href)) .concat(' ') .concat('&#40;') .concat(encodeURIComponent(document.title)) .concat('&#41;')));" class="pu"></a>
				</div>
				<div class="right-login">
					<form action="/index.php" style="font-size:0;overflow:hidden;float:left;">
						<input type="hidden" name="m" value="search">
						<input type="text" class="search-content" name="q" placeholder="搜尋" value="{$keyword}" onkeydown="">
						<input type="submit" class="search-button" id="search" value="">
					</form>
					<div class="hw-login-no" id="header-user-nologin">
		                <a href="#2" id="login" class="login-in">登入</a>
		                <a href="#2" id="reg" class="sign-in">註冊</a>
		            </div>
		            <div class="hw-login-had  disno" id="header-user-info">
						<a href="#2" id="logined" target="_blank"></a>
						<a href="#2" id="logout">退出</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="title-content clearfix">
		<div class="content-wrap clearfix">
			<ul class="clearfix">
				<li><a href="{cat_url(12)}">新聞</a></li>
				<li><a href="{cat_url(9)}">漫畫</a></li>
				<li><a href="{cat_url(6)}">動畫</a></li>
				<li><a href="{cat_url(21)}">小說</a></li>
				<li><a href="{cat_url(23)}">遊戲</a></li>
				<li><a href="{cat_url(20)}">活動</a></li>
				<li><a href="{cat_url(16)}">專欄</a></li>
				<li style="display:none;"><a href="{cat_url(11)}">排行</a></li>
				<li><a href="{cat_url(22)}">週邊</a></li>
				<li><a href="{cat_url(14)}">COSPLAY</a></li>
				<li><a href="{cat_url(15)}">萌圖</a></li>
				<li><a href="{cat_url(43)}">漫畫線上看</a></li>
			</ul>
		</div>
	</div>
</div>
{require name="tw_acg:statics/css/common.css"}
{require name="tw_acg:statics/css/acg_login.css"}
{require name="tw_acg:statics/js/login_tip.js"}