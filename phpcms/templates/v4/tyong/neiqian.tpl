<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{if isset($SEO['title']) && !empty($SEO['title'])}{$SEO['title']}{else}魔方网攻略-mofang.com{/if}</title>
    <meta name="keywords" content="{$SEO['keyword']}">
    <meta name="description" content="{$SEO['description']}">
    <base href="http://www.mofang.com/" />
    <style type="text/css">
        body, div, h1, h2, h3, h4, form, img, ul, ol, li, dl, dt, dd, p { margin:0; padding:0; }
        body { }
        ul, li { list-style:none; }
        .mf_frame{
            margin:0px;
            padding:{$neiqian_list.global.pt}px 0 0 {$neiqian_list.global.pl}px;
            margin:{$neiqian_list.global.mt}px 0 0 {$neiqian_list.global.ml}px;
            width:{$neiqian_list.global.width-$neiqian_list.global.pl}px;
            height:{$neiqian_list.global.height-$neiqian_list.global.pt}px;
            overflow:hidden;
            background-color:{$neiqian_list.global.iframe_color};
        }
        .pic_frame{
            margin:3px;
            width:{$neiqian_list.pic.width}px;
            height:{$neiqian_list.pic.height}px;
            float:{$neiqian_list.pic.pic_type};
        }
        .pic_frame img{
            width:{$neiqian_list.pic.width}px;
            height:{$neiqian_list.pic.height}px;
            border:1px solid #a38e6a;
        }

        .news_frame{
            float:left;
            font-family:"宋体";
            {if $neiqian_list.global.type != 1}width:{$neiqian_list.global.width-$neiqian_list.pic.width-$neiqian_list.global.pl-20}px;{/if}
            font-size:{$neiqian_list.list.font}px;
        }
        .news_frame ul {
            margin:0px; padding:0px; padding-left:12px; overflow:hidden; padding-top: 3px;
        }
        .news_frame ul li {
            list-style-type:none;
            border-bottom:1px {$neiqian_list.list.li_style} {$neiqian_list.list.li_color};
            line-height:{$neiqian_list.list.height}px;
            height:{$neiqian_list.list.height}px;
            color:#cbcbca; overflow:hidden;
        }
        a {
            text-decoration:none; color:{$neiqian_list.global.a_color};
        }
        a:hover {
            color:{$neiqian_list.global.a_hover_color};
        }
        .news_frame p{ float:left; display:block; padding:0px; margin:0px;width:250px;height:24px; }
        .news_frame span{
            float:right;
            color: {$neiqian_list.global.a_color};
        }
        .in_frame{ float:right;margin:10px 10px 0 0; }
        .search { width:450px; text-align:left; margin:15px auto; overflow:hidden;line-height:19px; }
        .search input { float:left; font-family:"宋体";font-size:14px; }
        .search .text { border:0; width:335px; height:26px; line-height:30px; background:#373B44; color:#fff; border:1px solid #333; }
        .search .sub { width:100px; height:30px; cursor:pointer; background:#30587C; border:0; margin-left:10px;color:#fff; }
    </style>
    <script type="text/javascript">
        function checkForm_search(this_form){
            if (searchform1.title.value == ''){
                alert("搜索关键词不能为空, 请重新输入！");
                searchform1.title.focus();
                return false;
            }
            return true;
        }
        function search_submit(){
            document.searchform1.key.value=document.searchform1.title.value;
            var keyname=document.searchform1.key.value;
            var partid=document.searchform1.partid.value;
            document.searchform1.action="http://www.mofang.com/tag/"+partid+"/"+keyname+"-news-1.html";
        }
    </script>
</head>
<body>
<div class="mf_frame">
    {if !empty($neiqian_list.pic.partid) }
    {$partid=$neiqian_list.pic.partid}
    <div class="pic_frame">
    {pc M=partition action=partition_contents partid=$partid makeurl=1 fields='id,catid,url,title,shortname,inputtime,thumb' nums=1}
        {foreach from=$data item=val}
        <a href="{get_info_url($val['catid'],$val['id'])}"  title="{$val['title']}" target="_blank"><img src="{$val['thumb']}" title="{$val['title']}" /></a>
        {/foreach}
    {/pc}
    </div>
    {/if}
    {if ($neiqian_list.global.is_search==1 )}
    <div class="search">
        <form name="searchform1" method="post" action="" target="_blank" onsubmit="{literal}if(checkForm_search(this.form)){return search_submit();}else return false;{/literal}">
            <input type="hidden" name="key">
            <input type="hidden" name="partid" value="{$partition_id}">
            <input type="hidden" name="example">
            <input type="text" class="text" name="title" maxlength="100" onclick="javascript:this.value=''" value="">
            <input type="submit" class="sub" name="submit_answer" value="搜索攻略">
        </form>
    </div>
    {/if}
    {if !empty($neiqian_list.list.partid) }
    {$partid=$neiqian_list.list.partid}
    {$nums=$neiqian_list.list.nums}
    <div class="news_frame">
        <ul>
            {pc M=partition action=partition_contents partid=$partid makeurl=1 fields='id,catid,url,title,shortname,inputtime' nums=$nums}
                {foreach from=$data item=val}
                    <li>
                        {if ( $neiqian_list.list.time_type==1 )}
                            <span>[{date('Y-m-d',$val['inputtime'])}]</span>
                        {elseif ( $neiqian_list.list.time_type==2 )}
                            <span>[{date('m-d',$val['inputtime'])}]</span>
                        {/if}
                        <a href="{get_info_url($val['catid'],$val['id'])}" target="_blank"  title="{$val['title']}">
                            {$neiqian_list.list.tag} {mb_strimwidth($val['title'],0,$neiqian_list.list.limit*2)}
                        </a>
                    </li>
                {/foreach}
            {/pc}
        </ul>
        <div class="in_frame">
            {if ( $neiqian_list.global.is_mfin==1 )}
                <a target="_blank" href="http://www.mofang.com">[魔方网]</a>
            {/if}
            {if ( $neiqian_list.global.is_partin==1 )}
                <a target="_blank" href="http://www.mofang.com/{$neiqian_list.partname}/">[进入专区]</a>
            {/if}
        </div>
    </div>
    {/if}
</div>
</body>
</html>
