{* 多说评论框 start *}

{*
# TODO调用位置
 * 主站详情页 小克
     http://www.mofang.com/hwkyx/1311-277314-1.html

 * 专区详情页 刘天夫
     http://www.mofang.com/kkams/1317_261635.html
     有评论的专区
     http://hs.mofang.com/1317_275514.html
     http://cc.mofang.com/785_255785.html
     http://pvz2.mofang.com/266_274248.html
     http://dtcq.mofang.com/1317_277394.html
     无评论的
     http://shenqu.mofang.com/265_215624.html
     http://cqzj.mofang.com/1317_276663.html
     http://luobo2.mofang.com/275_278534.html

 * 游戏库详情页(还需要重新设计,详情页还需改) 李伟
     http://game.mofang.com/info/13985.html
*}
<div class="comment" data-flag="art_{$modelid}_{$smarty.get.id}"></div>
<script>
   seajs.use("comment",function(cur){
       cur.fnMFComment(".comment",{
           flag: 'cms:art_{$modelid}_{$smarty.get.id}',
           pagesize: 4
       });
   });
</script>
{* <div class="ds-thread"
     data-thread-key="{$comment_article_id|default:'test_article_001'}"
     data-title="{$comment_article_title|default:'测试文章标题'}"
     data-url="{$comment_article_url|default:'http://www.mofang.com\/article_test.html'}"></div> *}
{* 多说评论框 end *}

{* 多说公共JS代码 start (一个网页只需插入一次) *}
{* {literal}
<script type="text/javascript">
    var duoshuoQuery = {short_name:"mofang"};
	(function() {
		var ds = document.createElement('script');
		ds.type = 'text/javascript';ds.async = true;
		ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
		ds.charset = 'UTF-8';
		(document.getElementsByTagName('head')[0]
		 || document.getElementsByTagName('body')[0]).appendChild(ds);
	})();
	</script>
{/literal} *}
{* 多说公共JS代码 end *}
