<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<title>{if isset($SEO['title']) && !empty($SEO['title'])}{$SEO['title']}{/if}{$SEO['site_title']}</title>
	<meta name="keywords" content="{$SEO['keyword']}">
	<meta name="description" content="{$SEO['description']}">
    <link rel="stylesheet" type="text/css" href="/statics/v4/common/css/partition/whiteblue/common.css" />
    <link rel="stylesheet" type="text/css" href="/statics/v4/common/css/partition/whiteblue/model.css" />
	<script language="javascript" type="text/javascript" src="/statics/v4/common/js/jquery.min.js"></script>
	<script language="javascript" type="text/javascript" src="/statics/v4/common/js/jquery.sgallery.js"></script>
	<style>
		body{ background:none;}
	</style>
</head>
<body >
	{pc M=comment action=get_comment commentid=$commentid}
	{$comment=$data}
	{/pc}

    {pc M=comment action=lists commentid=$commentid siteid=$siteid hot=1 num=5}
        <div class="gameReviews">
            <form action="http://www.mofang.com/index.php?m=comment&c=index&a=post&commentid={$commentid}" method="post" onsubmit="return on_submit()">
                <div class="coment_number">
                    <input type="hidden" name="title" value="{urlencode($comment.title)}">
                    <input type="hidden" name="url" value="{urlencode($comment.url)}">
                    <input type="hidden" name="direction" id="setGrade" value="0">
                    <textarea id="pinglun" class="textarea" name="content" {literal}onFocus="if(value==defaultValue){this.value=''}" onBlur="if(value=='') this.value=defaultValue"{/literal} rows="">您可以在这里填写对这款游戏的评论内容</textarea>
                    <div class="share">
                        <input type="submit" class="pinglun_btn" value="发表评论"/>
                    </div>
                </div>
            </form>
        </div>

        {if !empty($data)}
        <div class="popularComments">
            <div class="popular">
                <a class="pngfix" href="">查看全部>></a>
                <p>共有<span>{if $comment.total}{$comment.total}{else}0{/if}</span>条评论</p>
                <h4>热门评论</h4>
            </div>

            {foreach from=$data item=r}
            <div class="contentStart">
                <img src="/statics/v4/common/img/head.png">
                <div>
                    <i>{$r.username}</i><span>发表于{format::date($r.creat_at, 1)}</span>
                    <p>{$r.content}</p>
                    <a class="fandui pngfix" onclick="support({$r.id}, '{$commentid}')" href="javascript:void(0)"><span id="support_{$r.id}">{$r.support}</span></a>
                    <a class="zhichi pngfix" onclick="oppose( {$r.id}, '{$commentid}')" href="javascript:void(0)"><span id="oppose_{$r.id}">{$r.oppose}</span></a>
                </div>
            </div>
            {/foreach}
        </div>
        {/if}
	{/pc}
	<script type="text/javascript">
		function support(id, commentid) {
			$.getJSON('http://www.mofang.com/index.php?m=comment&c=index&a=support&format=jsonp&commentid='+commentid+'&id='+id+'&callback=?', function(data){
			if(data.status == 1) {
			$('#support_'+id).html(parseInt($('#support_'+id).html())+1);
			} else {
			alert(data.msg);
			}
			});
		}

		function oppose(id, commentid) {
			$.getJSON('http://www.mofang.com/index.php?m=comment&c=index&a=oppose&format=jsonp&commentid='+commentid+'&id='+id+'&callback=?', function(data){
                if(data.status == 1) {
                    $('#oppose_'+id).html(parseInt($('#oppose_'+id).html())+1);
                } else {
                    alert(data.msg);
                }
			});
		}
		function hide_code() {
            if ($('#yzmText').data('hide')==0) {
                $('#yzm').hide();
            }
		}
		function on_submit() {
			{if $setting[code]}
                var checkcode = $("#yzmText").val() == '' ? $("#yzmreplay").val() : $("#yzmText").val();
                var res = $.ajax({
                    url: "http://www.mofang.com/index.php?m=pay&c=deposit&a=public_checkcode&code="+checkcode,
                    async: false
                }).responseText;
			{else}
				var res = 1;
			{/if}

			if ($('#pinglun').val().trim() == '') {
				alert('请输入评论内容');
				return false;
			}
			if(res != 1) {
				alert('验证码错误');
				return false;
			} else {
				iframe_height(200);
				$('#bodyheight').hide();
				return true;
			}
		}
		function iframe_height(height) {
			if (!height) {
				var height = document.getElementById('bodyheight').scrollHeight;
			} 
			$('#top_src').attr('src', "{$domain}js.html?"+height+'|'+{if $comment['total']}{$comment['total']}{else}0{/if});
		}
		</script>
	</div>
	<iframe width='0' id='top_src' height='0' src='' style="border:0px;"></iframe>
	<script type="text/javascript" src="/statics/v4/common/js/MFbase.js"></script>
	<script>
		(function(){
            MF.grade("#starBox li", 0);
		})();
	</script>
</body>
</html>
