{* 新闻资讯栏目 *}
{if !empty($news_arr) }
{$news=explode(',',$news_arr)}

<div class="containerA w340 container_left fl">
    <div class="header_back"></div>

    <div class="body_back">

        {* 4 4 12 *}
        {if isset($news[2]) }
        
            {pc M=partition action=lists2 partid=$news[0] makeurl=1 order='`inputtime` DESC' fields='id,catid,url,title,shortname,inputtime,thumb' pagenum=4}
                {$con_data= $data.contents}
                <h1><a href="{get_info_url($con_data[0]['catid'],$con_data[0]['id'])}" target="_blank">{mb_strimwidth($con_data[0]['title'], 0, 38)}</a></h1>
                <p>
                    {foreach from=$con_data key=key item=val}
                        <a href="{get_info_url($val['catid'],$val['id'])}" target="_blank">{mb_strimwidth($val['shortname'],0,10)}</a>
                        {if $key!=3 }|{/if}
                    {/foreach}
                </p>
            {/pc}
            
            {pc M=partition action=lists2 partid=$news[1] makeurl=1 order='`inputtime` DESC' fields='id,catid,url,title,shortname,inputtime,thumb' pagenum=4}
                {$con_data = $data.contents}
                <h1 class="mat10">
                    <a href="{get_info_url($con_data[4]['catid'],$con_data[4]['id'])}" target="_blank">
                        {mb_strimwidth($con_data[4]['title'], 0, 38)}
                    </a>
                </h1>
                <p>
                    {foreach from=$con_data key=key item=val}
                        <a href="{get_info_url($val['catid'],$val['id'])}" target="_blank">{mb_strimwidth($val['shortname'],0,10)}</a>
                        {if $key!=3 }|{/if}
                    {/foreach}
                </p>
            {/pc}

            {pc M=partition action=lists2 partid='$news[2]' makeurl=1 order='`inputtime` DESC' fields='id,catid,url,title,shortname,inputtime,thumb' pagenum=11}
                {$con_data = $data.contents}
                <ul class="mat10">
                    {foreach from=$con_data key=key item=val}
                        <li><a href="{get_info_url($val['catid'],$val['id'])}" target="_blank">{mb_strimwidth($val['title'], 0, 36)}</a><em>{date('m-d', $val['inputtime'])}</em></li>
                    {/foreach}
                </ul>
            {/pc}

                <a href="{get_part_url($news[2])}" class="body_back_more">更多>></a>
        {* 8 12 *}
        {elseif isset($news[1]) }

            {pc M=partition action=lists2 partid=$news[0] order='`inputtime` DESC' makeurl=1 fields='id,catid,url,title,shortname,inputtime,thumb' pagenum=8}

                {$con_data = $data.contents}

                <h1><a href="{get_info_url($con_data[0]['catid'],$con_data[0]['id'])}" target="_blank">{mb_strimwidth($con_data[0]['title'], 0, 38)}</a></h1>
                <p>

                    {foreach from=$con_data key=key item=val}
                        {if ($key > 0 && $key < 4) }
                        <a href="{get_info_url($val['catid'],$val['id'])}" target="_blank">{mb_strimwidth($val['shortname'],0,10)}</a>
                        {if $key!=3 }|{/if}
                        {/if}
                    {/foreach}
                </p>
                <h1 class="mat10"><a href="{get_info_url($con_data[4]['catid'],$con_data[4]['id'])}" target="_blank">{mb_strimwidth($con_data[4]['title'], 0, 38)}</a></h1>
                <p>

                    {foreach from=$con_data key=key item=val}
                        {if $key > 4 } 
                        <a href="{get_info_url($val['catid'],$val['id'])}" target="_blank">{mb_strimwidth($val['shortname'],0,10)}</a>
                        {if $key!=7 }|{/if}
                        {/if}
                    {/foreach}
                </p>
            {/pc}

            {pc M=partition action=lists2 partid=$news[1] order='`inputtime` DESC' makeurl=1 fields='id,catid,url,title,shortname,inputtime,thumb' pagenum=11}
            
                {$con_data = $data.contents}
                <ul class="mat10">
                    {foreach from=$con_data key=key item=val}
                        <li><a href="{get_info_url($val['catid'],$val['id'])}" target="_blank">{mb_strimwidth($val['title'], 0, 36)}</a><em>{date('m-d', $val['inputtime'])}</em></li>
                    {/foreach}
                </ul>
            {/pc}

                <a href="{get_part_url($news[1])}" class="body_back_more">更多>></a>
        {* 20 *}
        {else}
            {pc M=partition action=lists2 partid=$news[0] makeurl=1 order='`inputtime` DESC' fields='id,catid,url,title,shortname,inputtime,thumb' pagenum=19}

                {$con_data = $data.contents}
                <h1><a href="{get_info_url($con_data[0]['catid'],$con_data[0]['id'])}" target="_blank">{mb_strimwidth($con_data[0]['title'], 0, 38)}</a></h1>
                <p>

                    {foreach from=$con_data key=key item=val}
                        {if ($key > 0 && $key < 4) }
                            <a href="{get_info_url($val['catid'],$val['id'])}" target="_blank">{mb_strimwidth($val['shortname'],0,10)}</a>
                            {if $key!=3 }|{/if}
                        {/if}
                    {/foreach}
                </p>
                <h1 class="mat10"><a href="{get_info_url($con_data[4]['catid'],$con_data[4]['id'])}" target="_blank">{mb_strimwidth($con_data[4]['title'], 0, 38)}</a></h1>
                <p>

                    {foreach from=$con_data key=key item=val}
                        {if ($key > 4 && $key < 8)} 
                            <a href="{get_info_url($val['catid'],$val['id'])}" target="_blank">{mb_strimwidth($val['shortname'],0,10)}</a>
                            {if $key!=7 }|{/if}
                        {/if}
                    {/foreach}
                </p>
                <ul class="mat10">

                    {foreach from=$con_data key=key item=val}
                        {if ($key > 7) }
                            <li><a href="{get_info_url($val['catid'],$val['id'])}" target="_blank">{mb_strimwidth($val['title'], 0, 36)}</a><em>{date('m-d', $val['inputtime'])}</em></li>
                        {/if}
                    {/foreach}
                </ul>
            {/pc}
                <a href="{get_part_url($news[0])}" class="body_back_more">更多>></a>
        {/if}

    </div>

    <div class="foter_back"></div>
</div>
{/if}


