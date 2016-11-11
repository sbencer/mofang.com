
<div class="photo">
    {pc M="content" action="lists" catid=$catid order="listorder DESC" thumb="1" num="10"}
        <ul class="photo_big append clearfix">
            {foreach $data as $val}
            <li> <a href="{$val.url}"> <img src="{$val.thumb}">
                <p><span>{$val.title}</span></p>
                </a> </li>  
            {/foreach}
        </ul>   
    {/pc}  
    <a class="load_more" href="javascript:;"><span>還要查看更多</span></a>
    
</div>
{require name="tw_acg:statics/wap/css/photo.css"} 
{require name="tw_acg:statics/wap/js/load_more.js"}