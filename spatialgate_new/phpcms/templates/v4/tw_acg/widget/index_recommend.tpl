<div class="recommend">
	<div class="title">
		<h2>超次元編輯推薦</h2>
	</div>
	<div class="recom_con">
		<div class="recom_list">
			<div class="title_text">
				<h3 class="fl">動畫</h3>
				<a class="fr" href="{cat_url(6)}">更多</a>
			</div>
			<ul class="clearfix">
			{pc M="content" action="position" posid="21" order="listorder DESC" thumb="1" num="4"}
        		{foreach $data as $val}
				<li>
					<a href="{$val.url}">
						<img src="{qiniuthumb($val.thumb, 320, 180)}" alt="{$val.title}">
						<span>{$val.title}</span>
					</a>
				</li>
				{/foreach}
			{/pc}
			</ul>
		</div>
		<div class="recom_list">
			<div class="title_text">
				<h3 class="fl icon_novel">小說</h3>
				<a class="fr" href="{cat_url(21)}">更多</a>
			</div>
			<ul class="clearfix">
			{pc M="content" action="position" posid="22" order="listorder DESC" thumb="1" num="4"}
        		{foreach $data as $val}
				<li>
					<a href="{$val.url}">
						<img src="{qiniuthumb($val.thumb, 320, 180)}" alt="{$val.title}">
						<span>{$val.title}</span>
					</a>
				</li>
				{/foreach}
			{/pc}
			</ul>
		</div>
		<div class="recom_list">
			<div class="title_text">
				<h3 class="fl icon_cartoon">漫畫</h3>
				<a class="fr" href="{cat_url(9)}">更多</a>
			</div>
			<ul class="clearfix">
			{pc M="content" action="position" posid="23" order="listorder DESC" thumb="1" num="4"}
        		{foreach $data as $val}
				<li>
					<a href="{$val.url}">
						<img src="{qiniuthumb($val.thumb, 320, 180)}" alt="{$val.title}">
						<span>{$val.title}</span>
					</a>
				</li>
				{/foreach}
			{/pc}
			</ul>
		</div>
		<div class="recom_list">
			<div class="title_text">
				<h3 class="fl icon_game">遊戲</h3>
				<a class="fr" href="{cat_url(23)}">更多</a>
			</div>
			<ul class="clearfix">
			{pc M="content" action="position" posid="24" order="listorder DESC" thumb="1" num="4"}
        		{foreach $data as $val}
				<li>
					<a href="{$val.url}">
						<img src="{qiniuthumb($val.thumb, 320, 180)}" alt="{$val.title}">
						<span>{$val.title}</span>
					</a>
				</li>
				{/foreach}
			{/pc}
			</ul>
		</div>
		<div class="recom_list">
			<div class="title_text">
				<h3 class="fl icon_mmd">萌圖</h3>
				<a class="fr" href="{cat_url(15)}">更多</a>
			</div>
			<ul class="clearfix">
			{pc M="content" action="position" posid="25" order="listorder DESC" thumb="1" num="4"}
        		{foreach $data as $val}
				<li>
					<a href="{$val.url}">
						<img src="{qiniuthumb($val.thumb, 320, 180)}" alt="{$val.title}">
						<span>{$val.title}</span>
					</a>
				</li>
				{/foreach}
			{/pc}
			</ul>
		</div>
	</div>
</div>
{require name="tw_acg:statics/css/recommend.css"}