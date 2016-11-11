{if $relation_game_array}
{pc M=content action=gameinfo_lists catid=10000111 gameid=$relation_game_array id=$id num=1}
	{foreach $data as $val}
	<div class="login-mess w680 mb10">
		<div class="login-mess-con">
			<h3 class="login-title">【事前登錄資訊】</h3>
			<div class="login-game clearfix">
				<a href="{$val.site_url}" target="_blank" class="img-area fl">
					<img src="{qiniuthumb($val.icon,114,114)}" alt="">
				</a>
				<div class="txt-area">
					<div class="log-game-det">
						<span>遊戲名稱</span>{$val.title}
					</div>
					<div class="log-game-det">
						<span>登錄期限</span>{date('Y/m/d',$val.end_time)}
					</div>
					<a href="{$val.site_url}" target="_blank" class="enter-login-list">前往登錄</a>
				</div>
			</div>
		</div>
	</div>
	{/foreach}
{/pc}
{require name="tw_mofang:statics/css/bef_login/login_mess.css"}
{/if}
