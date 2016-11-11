
{pc M="content" action="lists" catid="10000296" order="id desc" num="1"}
	{foreach $data as $val}
		{if $val@first}
			<div class="list-live {$show_video_class}" >
			    <h3 class="title">魔方直播廣場</h3>
			    <ul class="list-video">
			        <li>
			            <a href="{$val.url}" target="_blank">
			               <img src="{$val.thumb}" />
			                <p class="list-video-info">{$val.title}</p>
			            </a>
			        </li>
			    </ul>
			</div>
		{/if}
	{/foreach}
{/pc}
