<div class="con_nav live_nav">
	<span class="fl">直播頻道</span>
	<div class="fr">
    	<a class="close_live" href="javascript:;">關閉直播</a>
	</div>
</div>
<div class="live">
	<h2>現正播出</h2>
    <div class="live_list">
    	<span class="status">即將上映</span>
        <div id="marquee_box">
            <table class="marquee_table" cellspacing='0'>
                <tr>
                    <td valign=top bgcolor=ffffff id="marquee_box1">
                		<table width='100%' border='0' cellspacing='0'>
                        	<tr>
                            {pc M=partition action=partition_contents partid={$module_setting_type['live']['video_arr']} makeurl=1 fields='id,catid,url,title,description,inputtime,thumb' nums=5}
                                {foreach $data as $val}
                            	<td align=center><a href='javascript:;' data-src="{$val.url}">{$val.title}</a></td>
                                {/foreach}
                            {/pc}
                            </tr>
                        </table>
                    </td>
                    <td id="marquee_box2" valign=top></td>
                </tr>
            </table>
    	</div>
    </div>
    <!--直播间 start-->
    <iframe class="iframe_live" width="980" height="359" src="" frameborder="0" allowfullscreen></iframe> 
    <!--直播间 end-->
</div>
{require name="tw_tyong:statics/css/common/bread.css"}
{require name="tw_tyong:statics/js/marquee.js"}
