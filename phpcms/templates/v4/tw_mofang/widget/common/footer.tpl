<div class="hw-footer">
	<div class="footer-wrap w1000 clearfix">
		<div class="friend-link-wrap">
			<span class="link-tit">友情鏈接：</span>
			<div class="friend-link">
			{pc M=link action=type_list typeid=155 order='listorder DESC'}
				{foreach $data as $val}
				<a href="{$val.url}" target="_blank">{$val.name}</a>
				{/foreach}
			{/pc}
			</div>
		</div>
		<div class="about-us">
			<a href="#">關於我們</a>
			<a href="#">誠聘英才</a>
			<a href="#">聯繫我們</a>
			<a href="#">呼叫編輯</a>
		</div>
		<div class="mf-adress">
			© 2013 魔方网 MOFANG.COM 皖ICP备13001602号-1<br>
			芜湖魔方网络信息服务有限公司北京技术分公司    联系电话：010-56763990
		</div>
	</div>
	
</div>
{require name="tw_mofang:statics/css/footer.css"}
