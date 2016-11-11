<div class="game-intro">
	<ul>
	{pc M="content" action="lists" catid="26" order="listorder DESC" thumb="1" num="1"}
		{foreach $data as $val}
		<li>
			<a href="{$val.url}"  class="special_img">
				<img src="{$val.thumb}">
			</a>
		<li>
		{/foreach}
	{/pc}
	
	{pc M="content" action="lists" catid="27" order="listorder DESC" thumb="1" num="3"}
		{foreach $data as $val}
		<li>
			<a href="{$val.url}">
				<img src="{$val.thumb}">
			</a>
		<li>
		{/foreach}
	{/pc}
	</ul>
</div>
{require name="tw_acg:statics/css/information.css"}